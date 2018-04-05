<?php
    include 'model/queries.php';
    
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
    $act = $_GET['act'];
    if(isset($act)){
        if($act == "login"){
            $id = login();
            if($id > 0)
                header('Location:vue/accueil.view.php');
            else{
                $error;
                if($id == -1)
                    $error = "User_does_not_exist";
                else if($id == -2)
                    $error = "Invalid_password";
                else{
                    $error = "unreachable error... ???";
                }
                header('Location:vue/error.view.php?error=' . $error);
            }
        }

        else if($act == "register"){
            if(register()){
                header('Location:vue/accueil.view.php');   
            }
            else{
                $error = "User_already_exists";
                header('Location:vue/error.view.php?error=' . $error);
            }
        }

        else if($act == "login_page"){
            $connexionIsLogin = true;
            header('Location:vue/connection.view.php?act=log');
        }

        else if($act == "register_page"){
            $connexionIsLogin = false;
            header('Location:vue/connection.view.php?act=reg');
        }

        else{
            header('Location:vue/accueil.view.php');    
        }

    }
    else{
        header('Location:vue/accueil.view.php');
    }
?>