<?php
    class Model{
        public $pdo;

        function __construct(string $dbname){
            $this->pdo = new PDO('sqlite:' . $dbname);
            $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $create = file_get_contents('model/create.sql');
            $this->pdo->exec($create);
        }

        function q_login(string $username, string $pwd){
            $stmt = $this->pdo->prepare('SELECT username, id, session_cookie, pwd FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if($res = $stmt->fetch()){
                if(password_verify($pwd, $res['pwd'])){
                    $GLOBALS['uname'] = $res['username'];
                    setcookie('sid', $res['session_cookie'], time() + $GLOBALS['cookieValidityTime'], '');
                    return $res['id'];
                }
                else
                    return -2;
            }
            else
                return -1;
        }

        function q_login_cookie(string $cookie){

            $dateMin = time() - $GLOBALS['cookieValidityTime'];
            $stmt = $this->pdo->prepare('SELECT username, id FROM users WHERE session_cookie = ? AND cookie_date > ?');
            $stmt->execute([$cookie, $dateMin]);
            $res;
            if($res = $stmt->fetch()){
                $GLOBALS['uname'] = $res['username'];
                return $res['id'];
            }
            else{
                return 0;
            }
        }
    
        function q_update_cookie(int $userId){
            if(!$userId) //evite de faire une requette inutilement
                return 0;
            $session_cookie = random_bytes(16);
            $cookie_date = time();
            
            setcookie('sid', $session_cookie, $cookie_date + $GLOBALS['cookieValidityTime'], '');
            $stmt = $this->pdo->prepare('UPDATE users SET session_cookie = ?, cookie_date = ? WHERE id = ?');
            $stmt->execute([$session_cookie, $cookie_date, $userId]);

            return $userId;
        }

        function q_register(string $username, string $pwd){
            $stmt = $this->pdo->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if($stmt->fetchColumn() != 0)
                return false;
            $pass = password_hash($pwd, PASSWORD_DEFAULT);
            $session_cookie = random_bytes(16);
            $stmt = $this->pdo->prepare('INSERT INTO users(username, pwd, reg_date, session_cookie, cookie_date) VALUES(?, ?, ?, ?, ?)');
            $stmt->execute([$username, $pass, time(), $session_cookie, time()]);
            setcookie('sid', $session_cookie, time() + $GLOBALS['cookieValidityTime'], '');
            $stmt = $this->pdo->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute([$username]);

            return $stmt->fetch()['id'];
        }
    }
?>