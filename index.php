<?php
    
    $uid = 0;
    $uname = '';
    $error = 'undefined error';
    $isLog = true;

    include 'queries.controller.php';

    $act = $_GET['act'];
    if(isset($act)){
        if($act == "login"){
            $uid = login();
            if($uid > 0)
                include 'vue/accueil.view.php';
            else{
                if($uid == -1)
                    $error = "User does not exist";
                else if($uid == -2)
                    $error = "Invalid password";
                else{
                    $error = "unreachable error... ???";
                }
                include 'vue/error.view.php';
            }
        }

        else if($act == "register"){
            $uid = register();
            if($uid){
                include 'vue/accueil.view.php';  
            }
            else{
                $error = "User already exists";
                include 'vue/error.view.php';
            }
        }

        else if($act == "login_page"){
            $isLog = true;
            include 'connection.view.php';
        }

        else if($act == "register_page"){
            $isLog = false;
            include 'connection.view.php';
        }

        else{
            $uid = tryLogingCookie();
            include 'vue/accueil.view.php';
        }

    }
    else{
        include 'vue/accueil.view.php';
    }
?>