<?php
    
    include 'model/queries.php';
    $GLOBALS['cookieValidityTime'] = 2592000;
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
        if(isset($_COOKIE['sid'])){
            $model = new Model("model/database.db");
            $sid = $_COOKIE['sid'];
            $GLOBALS['uid'] = $model->q_login_cookie($sid, $GLOBALS['cookieValidityTime']);
            $model->q_update_cookie($GLOBALS['uid']);
        }
    }
?>