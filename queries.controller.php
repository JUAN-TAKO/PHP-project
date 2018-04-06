<?php
    include 'model/queries.php';
    global $cookieValidityTime;
    $cookieValidityTime = 2592000;
    function login(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $model = new Model("model/database.db");
            return $model->q_login($_POST['username'], $_POST['password']);
        }
    }
    function register(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $model = new Model("model/database.db");
            return $model->q_register($_POST['username'], $_POST['password']);
        }
    }
    function tryLogingCookie(){
        $sid = $_COOKIE['sid'];
        $uid = 0;
        if(isset($sid)){
            $uid = q_login_cookie($sid, $cookieValidityTime);
            q_update_cookie($uid);
        }
        return $uid;
    }
?>