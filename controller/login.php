<?php
    session_start();
    $error = 'undefined';
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    include_once('model/DAO.php');

    $model = new DAO('../model/database.db');
    $user = $model->login();
    if($user->id > 0)
        header('Location: ../index.php');
    else{
        if($user->id == -1)
            $error = 'User does not exist';
        else if($user->id == -2)
            $error = 'Invalid password';
        else{
            $error = 'uid=0';
        }
        include 'vue/error.view.php';
    }
?>