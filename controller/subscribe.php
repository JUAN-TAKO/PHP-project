<?php
    session_start();
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    include_once('model/DAO.php');

    $model = new DAO('../model/database.db');
    $user = $model->subscribe();
?>