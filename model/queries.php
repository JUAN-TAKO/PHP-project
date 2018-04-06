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
            $stmt = $this->pdo->prepare('SELECT id, pwd FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if($res = $stmt->fetch()){
                if(password_verify($pwd, $res['pwd']))
                    return $res['id'];
                else
                    return -2;
            }
            else
                return -1;
        }

        function q_login_cookie(string $cookie, int $cookieValidityTime){

            $dateMin = time() - $cookieValidityTime;
            $stmt = $this->pdo->prepare('SELECT id, cookie_date FROM users WHERE session_cookie = ? AND date_cookie > ?');
            $stmt->execute([$cookie, $dateMin]);
            $res;
            if($res = $stmt->fetch()){
                $id = $res['id'];
                $cookie_date = $res[$cookie_date];
                return $id;
            }
            else{
                return 0;
            }
        }
    
        function q_update_cookie(int $userId){
            $session_cookie = random_bytes(16);
            $cookie_date = time();
            
            $stmt = $this->pdo->prepare('UPDATE users SET session_cookie = ?, cookie_date = ? WHERE id = ?');
            $stmt->execute([$session_cookie, $cookie_date, $userId]);
        }

        function q_register(string $username, string $pwd){
            $stmt = $this->pdo->prepare('SELECT COUNT(username) AS c FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if($stmt->fetchColumn() != 0)
                return false;
            $pass = password_hash($pwd, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('INSERT INTO users(username, pwd, reg_date, session_cookie, cookie_date) VALUES(?, ?, ?, ?)');
            $stmt->execute([$username, $pass, time(),random_bytes(16) ,time()]);
    
            return true;
        }
    }
?>