<?php
    include 'queries.php';
    function login(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            return q_login($_POST['username'], $_POST['password']);
        }
    }

    if(isset($_GET['act'])){
        
    }
    else{
        header('Location:vue/accueil.view.php');
    }
?>