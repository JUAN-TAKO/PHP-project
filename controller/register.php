<?php
    session_start();
    $error = 'undefined';
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    include_once('model/DAO.php');
    $model = new DAO('../model/database.db');
    $user = $model->register();
    if($user->id){
        header('Location: ../index.php');
    }
    else{
        $error = 'User already exists';
        include 'vue/error.view.php';
    }
?>