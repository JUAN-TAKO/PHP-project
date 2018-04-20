<?php
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    require_once('model/user.php');
    require_once('model/video.php');
    include_once('model/utils.php');
    
    class DAO{
        public $pdo;

        function __construct(string $dbname){
            $this->pdo = new PDO('sqlite:' . $dbname);
            $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $create = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/model/create.sql');
            $this->pdo->exec($create);
        }

        function q_login(string $username, string $pwd, bool $remember){
            $stmt = $this->pdo->prepare('SELECT username, id, reg_date, pwd FROM users WHERE username = ?');
            $stmt->execute([$username]);
            $user = new User;
            if($res = $stmt->fetch()){
                if(password_verify($pwd, $res['pwd'])){
                    $user->nom = $res['username'] . $remember;
                    $user->id = $res['id'];
                    $user->reg_date = $res['reg_date'];
                    $this->q_update_cookie($user->id, $remember);
                }
                else
                    $user->id = -2;
            }
            else
                $user->id = -1;
            return $user;
        }

        function q_login_cookie(string $cookie){

            $dateMin = time() - cookieValidity();
            $stmt = $this->pdo->prepare('SELECT username, id , reg_date FROM users WHERE session_cookie = ? AND cookie_date > ?');
            $stmt->execute([$cookie, $dateMin]);
            $res;
            $user = new User;
            if($res = $stmt->fetch()){
                $user->nom = $res['username'];
                $user->id = $res['id'];
                $user->reg_date = $res['reg_date'];
                
            }
            if(isset($_COOKIE['sid']))
                $this->q_update_cookie($user->id, true);
            return $user;
        }
    
        function q_update_cookie(int $userId, bool $remember){
            if(!$userId) //evite de faire une requette inutilement
                return 0;
            $session_cookie = random_bytes(16);
            $cookie_date = time();
            $_SESSION['sid'] = $session_cookie;
            if($remember || isset($_COOKIE['sid']))
                setcookie('sid', $session_cookie, $cookie_date + cookieValidity(), '/');
            $stmt = $this->pdo->prepare('UPDATE users SET session_cookie = ?, cookie_date = ? WHERE id = ?');
            $stmt->execute([$session_cookie, $cookie_date, $userId]);

            return $userId;
        }

        function q_register(string $username, string $pwd, bool $rememberMe){
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if($stmt->fetchColumn() != 0)
                return new User;
            $pass = password_hash($pwd, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('INSERT INTO users(username, pwd, reg_date, session_cookie, cookie_date) VALUES(?, ?, ?, ?, ?)');
            $stmt->execute([$username, $pass, time(), '', time()]);
            $stmt = $this->pdo->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute([$username]);
            $res = $stmt->fetch();
            $user = new User;
            $user->id = $res['id'];
            $user->nom = $username;
            $user->reg_date = time();
            $this->q_update_cookie($user->id, $rememberMe);
            return $user;
        }

        function q_is_subscribed(int $channelId, int $subscriberId){
            if(!$subscriberId)
                return false;
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM subscribtions WHERE channel_id = ? AND subscriber_id = ?');
            $stmt->execute([$channelId, $subscriberId]);

            return ($stmt->fetchColumn() != 0);
        }
        function q_subscribe(bool $subscribe, int $channelId, int $subscriberId){
            if(!$subscriberId)
                return;
            
            $currently_subscribed = $this->q_is_subscribed($channelId, $subscriberId);

            if($subscribe && !$currently_subscribed){
                $stmt = $this->pdo->prepare('INSERT INTO subscribtions VALUES(?, ?, ?)');
                $stmt->execute([$channelId, $subscriberId, 0]);
                $this->q_update_subscription_last_seen($channelId, $subscriberId);
            }elseif($currently_subscribed){
                $stmt = $this->pdo->prepare('DELETE FROM subscribtions WHERE channel_id = ? AND subscriber_id = ?');
                $stmt->execute([$channelId, $subscriberId]);
            }
            
        }

        function q_get_subscribtions(int $userId){
            if(!$userId)
                return [];
            $users = [];
            $stmt = $this->pdo->prepare('SELECT id, username, reg_date FROM subscribtions INNER JOIN users ON channel_id=id WHERE subscriber_id = ?');
            $stmt->execute([$userId]);

            while($res = $stmt->fetch()){
                $user = new User;
                $user->id = $res['id'];
                $user->nom = $res['username'];
                $user->reg_date = $res['reg_date'];
                $user->new = $this->q_get_nb_new_videos($user->id, $userId);
                $users[] = $user;
            }
            return $users;
        }

        function q_add_comment(int $videoId, int $posterId, string $comment){
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM videos WHERE id = ?');
            $stmt->execute([$videoId]);
            if($stmt->fetchColumn() == 0)
                return;

            $stmt = $this->pdo->prepare('INSERT INTO comments(content, pub_date, poster_id, vid_id) VALUES(?, ?, ?, ?)');
            $stmt->execute([$comment, time(), $posterId, $videoId]);
        }

        function q_add_video(string $title, string $description, int $creatorId){
            $time = time();
            $stmt = $this->pdo->prepare('INSERT INTO videos(title, description, pub_date, creator_id, views) VALUES(?, ?, ?, ?, ?)');
            $stmt->execute([$title, $description, $time, $creatorId, 0]);
            
            $stmt = $this->pdo->prepare('SELECT id FROM videos WHERE creator_id = ? AND pub_date = ?');
            $stmt->execute([$creatorId, $time]);

            return $stmt->fetch()['id'];
        }

        function q_get_video(int $id){
            $stmt = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?');
            $stmt->execute([$id]);

            $vid = new Video;
            if($res = $stmt->fetch()){
                $vid->id = $res['id'];
                $vid->title = $res['title'];
                $vid->description = make_links($res['description']);
                $vid->pub_date = $res['pub_date'];
                $vid->channel_id = $res['creator_id'];
                $vid->views = $res['views'];
            }
            
            return $vid;
        }

        function q_get_videos_channel(int $channelId, int $max, int $offset){
            $stmt = $this->pdo->prepare('SELECT v.id as id, title, description, pub_date, creator_id, username, views FROM videos v INNER JOIN users u ON v.creator_id=u.id WHERE creator_id = ? ORDER BY pub_date DESC LIMIT ? OFFSET ?');
            $stmt->execute([$channelId, $max, $offset]);

            $videos = [];
            while($res = $stmt->fetch()){
                $vid = new Video;
                $vid->id = $res['id'];
                $vid->title = $res['title'];
                $vid->description = make_links($res['description']);
                $vid->pub_date = $res['pub_date'];
                $vid->channel_id = $res['creator_id'];
                $vid->channel_name = $res['username'];
                $vid->views = $res['views'];

                $videos[] = $vid;
            }
            
            return $videos;
        }

        function q_get_videos_fresh(int $max, int $offset, int $hideChannel = 0){
            $stmt = $this->pdo->prepare('SELECT v.id as id, title, description, pub_date, creator_id, username, views FROM videos v INNER JOIN users u ON v.creator_id=u.id ORDER BY pub_date DESC LIMIT ? OFFSET ?');
            $stmt->execute([$max, $offset]);

            $videos = [];
            while($res = $stmt->fetch()){
                $vid = new Video;
                $vid->id = $res['id'];
                if($vid->id == $hideChannel)
                    continue;
                $vid->title = $res['title'];
                $vid->description = make_links($res['description']);
                $vid->pub_date = $res['pub_date'];
                $vid->channel_id = $res['creator_id'];
                $vid->channel_name = $res['username'];
                $vid->views = $res['views'];

                $videos[] = $vid;
            }
            
            return $videos;
        }

        function q_get_videos_search(int $max, int $offset, string $search){
            $query = 'SELECT v.id as id, title, description, pub_date, creator_id, username, views FROM videos v INNER JOIN users u ON v.creator_id=u.id WHERE title LIKE ';
            $keywords = explode(' ', $search);
            array_walk($keywords, function (&$value, $key) {
                $value="%$value%";
             });
            for($i = 0; $i < count($keywords)-1; $i++)
                $query .= '? OR title LIKE ';
            
            for($i = 0; $i < count($keywords); $i++)
                $query .= '? OR username LIKE ';

            $query .= '? ORDER BY views DESC LIMIT ? OFFSET ?';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(array_merge($keywords, $keywords, [$max, $offset]));

            $videos = [];
            while($res = $stmt->fetch()){
                $vid = new Video;
                $vid->id = $res['id'];
                $vid->title = $res['title'];
                $vid->description = make_links($res['description']);
                $vid->pub_date = $res['pub_date'];
                $vid->channel_id = $res['creator_id'];
                $vid->channel_name = $res['username'];
                $vid->views = $res['views'];

                $videos[] = $vid;
            }
            
            return $videos;
        }

        function q_get_user(int $id){
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$id]);

            $user = new User;
            if($res = $stmt->fetch()){
                $user->id = $res['id'];
                $user->nom = $res['username'];
                $user->reg_date = $res['reg_date'];
            }
            
            return $user;
        }

        function q_get_nb_comment(int $videoId){
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM comments WHERE vid_id = ?');
            $stmt->execute([$videoId]);
            return $stmt->fetchColumn();
        }

        function q_update_subscription_last_seen(int $channelId, int $userId){
            $stmt = $this->pdo->prepare('UPDATE subscribtions SET last_seen = ? WHERE channel_id = ? AND subscriber_id = ?');
            $stmt->execute([time(), $channelId, $userId]);
        }

        function q_get_nb_new_videos(int $channelId, int $userId){
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM subscribtions INNER JOIN videos ON creator_id = channel_id WHERE channel_id = ? AND subscriber_id = ? AND pub_date > last_seen');
            $stmt->execute([$channelId, $userId]);
            $ret =  $stmt->fetchColumn();
            return $ret;
        }

        function q_add_view(int $videoId){
            $stmt = $this->pdo->prepare('UPDATE videos SET views = views + 1 WHERE id = ?');
            $stmt->execute([$videoId]);
        }

        function login(){
            if(isset($_POST['username']) && isset($_POST['password'])){
                $username = htmlspecialchars($_POST['username']);
                return $this->q_login($username, $_POST['password'], isset($_POST['remember']));
            }
        }
        function register(){
            if(isset($_POST['username']) && isset($_POST['password'])){
                $username = htmlspecialchars($_POST['username']);
                return $this->q_register($username, $_POST['password'], isset($_POST['remember']));
            }
        }
        function logout(){
            setcookie(session_name(), '', 100);
            setcookie('sid', '', 100);
            session_unset();
            session_destroy();
            $_SESSION = array();
        }
        function tryLogingCookie(){
            if(isset($_COOKIE['sid'])){
                $sid = $_COOKIE['sid'];
                $user = $this->q_login_cookie($sid);
                $this->q_update_cookie($user->id, true);
                return $user;
            }
            elseif(isset($_SESSION['sid'])){
                $sid = $_SESSION['sid'];
                $user = $this->q_login_cookie($sid);
                $this->q_update_cookie($user->id, false);
                return $user;
            }
            else{
                return new User;
            }
        }

        function subscribe(){
            $user = $this->tryLogingCookie();
            if(!isset($_POST['subscribed']) || !isset($_POST['channel_id']))
                return;
            $subscribed = ($_POST['subscribed'] == 'true');
            $channelId = $_POST['channel_id'];
            if($user->id > 0){
                $this->q_subscribe($subscribed, $channelId, $user->id);
            }
        }

        function comment(){
            $user = $this->tryLogingCookie();
            if(!isset($_POST['comment']))
                return;
            $comment = htmlspecialchars($_POST['comment']);
            $videoId = $_POST['videoId'];
            if($user->id > 0){
                $this->q_add_comment($videoId, $user->id, $comment);
            }
        }
        function getComments(){
            $videoId;
            $last;
            $nb;

            if(isset($_GET['vid_id']) && isset($_GET['last']) && isset($_GET['nb'])){
                $videoId = $_GET['vid_id'];
                $last = $_GET['last'];
                $nb = $_GET['nb'];
            }
            else{
                echo(json_encode(array()));;
                return;
            }
            
            
            $comments = [];
            $stmt = $this->pdo->prepare('SELECT users.id as uid, username, content, pub_date FROM comments INNER JOIN users ON comments.poster_id=users.id WHERE vid_id = ? AND pub_date < ? ORDER BY pub_date DESC LIMIT ?');
            $stmt->execute([$videoId, $last, $nb]);
            while($comment = $stmt->fetch()){
                $comments[] = ['username' => $comment['username'], 'id' => $comment['uid'], 'comment' => make_links($comment['content']), 'date' => $comment['pub_date']];
            }
            if(empty($comments)){
                echo(json_encode(array()));
                return;
            }
            echo json_encode($comments);
        }

        function addVideo($userId){
            if(isset($_POST['video-title']) && isset($_POST['video-description']) && $userId > 0){
                return $this->q_add_video($_POST['video-title'], $_POST['video-description'], $userId);
            }
            return 0;
        }
        function getVideosSearch(){
            if(isset($_GET['q'])){
                return $this->q_get_videos_search(100, 0, $_GET['q']);
            }
        }
    }
?>