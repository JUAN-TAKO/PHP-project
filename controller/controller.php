<?php
    session_start();
    $error = 'undefined';
    $isLog = true;
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    include_once('model/DAO.php');

    $model = new DAO('model/database.db');
    $user = $model->tryLogingCookie();
    if(isset($_GET['act'])){
        $act = $_GET['act'];
        
        if($act == 'login_page'){
            $isLog = true;
            include 'vue/connection.view.php';
        }

        else if($act == 'register_page'){
            $isLog = false;
            include 'vue/connection.view.php';
        }
        else if($act == 'logout'){
            $model->logout();
            header('Location: ../index.php');
        }
        elseif($act == 'upload'){
            $subscribtions = $model->q_get_subscribtions($user->id);
            include 'vue/upload.view.php';
        }
        else{

            header('Location: ../index.php');
        }

    }
    else if(isset($_GET['v'])){
        $model->q_add_view($_GET['v']);
        $video = $model->q_get_video($_GET['v']);
        if($video->id > 0){
            $nb_comments = $model->q_get_nb_comment($video->id);
            $videos = $model->q_get_videos_fresh(100, 0, $video->id);
            $creator = $model->q_get_user($video->channel_id);
            $subscribed = $model->q_is_subscribed($video->channel_id, $user->id);
            include 'vue/play.view.php';
        }
        else
            echo '404 : cette vidéo n\'existe pas';
    }
    else{
        
        $videos;
        $subscribed = false;
        $current_channel = new User;
        if(isset($_GET['channel'])){
            $channel = $_GET['channel'];
            if($channel <= 0)
                $channel = $user->id;
            $model->q_update_subscription_last_seen($channel, $user->id);
            $subscribtions = $model->q_get_subscribtions($user->id);
            $current_channel = $model->q_get_user($channel);
            $subscribed = $model->q_is_subscribed($channel, $user->id);
            $videos = $model->q_get_videos_channel($channel, 100, 0);
        }
        else if(isset($_GET['q'])){
            $videos = $model->getVideosSearch();
            $subscribtions = $model->q_get_subscribtions($user->id);
        }
        else{
            $subscribtions = $model->q_get_subscribtions($user->id);
            $videos = $model->q_get_videos_fresh(100, 0);
        }
        include 'vue/accueil.view.php';
    }
?>