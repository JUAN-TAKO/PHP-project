<?php
    include 'queries.php';

    global $error;
    global $logged;
    global $connexionIsLogin;
    $logged = false;
    function login(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            return q_login($_POST['username'], $_POST['password']);
        }
    }
    function register(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            return q_register($_POST['username'], $_POST['password']);
        }
    }
    $act = $_GET['act'];
    if(isset($act)){
        if($act == "login"){
            $e = login();
            if(e == 0){
                $logged = true;
                header('Location:vue/accueil.view.php');
            }
            else{
                if(e == 1)
                    $error = "User does not exist";
                else
                    $error = "Invalid password";

                header('Location:vue/error.view.php');
            }
        }

        else if($act == "register"){
            if(register()){
                $logged = true;
                header('Location:vue/accueil.view.php');   
            }
            else{
                $error = "This user already exists";
                header('Location:vue/error.view.php');
            }
        }

        else if($act == "login_page"){
            $connexionIsLogin = true;
            header('Location:vue/connection.view.php');
        }

        else if($act == "register_page"){
            $connexionIsLogin = false;
            header('Location:vue/connection.view.php');
        }

        else{
            header('Location:vue/accueil.view.php');    
        }

    }
    else{
        header('Location:vue/accueil.view.php');
    }
?>