<?php
    $GLOBALS['uname'] = 'undefined';
    $GLOBALS['uid'] = 0;
    $error = 'undefined';
    $isLog = true;

    include 'queries.controller.php';

    tryLogingCookie();

    if(isset($_GET['act'])){
        $act = $_GET['act'];
        if($act == "login"){
            $GLOBALS['uid'] = login();
            if($GLOBALS['uid'] > 0)
                header('Location: index.php');
            else{
                if($GLOBALS['uid'] == -1)
                    $error = "User does not exist";
                else if($GLOBALS['uid'] == -2)
                    $error = "Invalid password";
                else{
                    $error = 'uid=0';
                }
                include 'vue/error.view.php';
            }
        }

        else if($act == 'register'){
            $GLOBALS['uid'] = register();
            if($GLOBALS['uid']){
                header('Location: index.php');
            }
            else{
                $error = "User already exists";
                include 'vue/error.view.php';
            }
        }

        else if($act == "login_page"){
            $isLog = true;
            include 'vue/connection.view.php';
        }

        else if($act == "register_page"){
            $isLog = false;
            include 'vue/connection.view.php';
        }

        else{
            include 'vue/accueil.view.php';
        }

    }
    else{
        include 'vue/accueil.view.php';
    }
?>