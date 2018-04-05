<?php
    class Model{
        public $pdo;

        function q_login(string $username, string $pwd){
            $stmt = $this->pdo->prepare('SELECT pwd FROM users WHERE username = ?');
            $stmt->execute($username);
            if($hash = $stmt->fetch()){
                if(password_verify($pwd, $hash)){
                    return 0;
                }
                else{
                    return 2;
                }
            }
            else{
                return 1;
            }
        }
    
        function q_register(string $username, string $pwd){
            $stmt = $this->pdo->prepare('SELECT COUNT(username) FROM users WHERE username = ?');
            $stmt->execute($username);
            if($stmt->fetch() == 0)
                return false;
            $stmt = $this->pdo->prepare('INSERT INTO users(username, pwd, reg_date) VALUES(?, ?, ?)');
            $stmt->execute($username, $pwd, time());
    
            return true;
        }
    }
    

    

?>