<?php
    session_start();
    const IMAGE_HANDLERS = [
        IMAGETYPE_JPEG => [
            'load' => 'imagecreatefromjpeg',
            'save' => 'imagejpeg',
            'quality' => 100
        ],
        IMAGETYPE_PNG => [
            'load' => 'imagecreatefrompng',
            'save' => 'imagepng',
            'quality' => 0
        ],
    ];

    function createThumbnail($src, $dest, $targetWidth, $targetHeight = null) {

        $type = exif_imagetype($src);
        if (!$type || !IMAGE_HANDLERS[$type]) {
            return null;
        }
        $image = call_user_func(IMAGE_HANDLERS[$type]['load'], $src);
        if (!$image) {
            return null;
        }
        $width = imagesx($image);
        $height = imagesy($image);

        if ($targetHeight == null) {
            $ratio = $width / $height;

            if ($width > $height) {
                $targetHeight = floor($targetWidth / $ratio);
            }

            else {
                $targetHeight = $targetWidth;
                $targetWidth = floor($targetWidth * $ratio);
            }
        }

        $thumbnail = imagecreatetruecolor($targetWidth, $targetHeight);
    
        if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_PNG) {
            imagecolortransparent(
                $thumbnail,
                imagecolorallocate($thumbnail, 0, 0, 0)
            );
            if ($type == IMAGETYPE_PNG) {
                imagealphablending($thumbnail, false);
                imagesavealpha($thumbnail, true);
            }
        }
        imagecopyresampled(
            $thumbnail,
            $image,
            0, 0, 0, 0,
            $targetWidth, $targetHeight,
            $width, $height
        );
        return call_user_func(
            IMAGE_HANDLERS[$type]['save'],
            $thumbnail,
            $dest,
            IMAGE_HANDLERS[$type]['quality']
        );
    }

    set_include_path($_SERVER['DOCUMENT_ROOT']);
    include_once('model/DAO.php');
    $model = new DAO('../model/database.db');
    $user = $model->tryLogingCookie();
    $target_video_dir = '../videos/';
    $target_thumbnail_dir = '../img/';
    
    if($user->id > 0 && isset($_FILES['video-file']) && isset($_FILES['thumbnail-file']) && isset($_POST['video-title']) && isset($_POST['video-description'])){
        $video_type = mime_content_type($_FILES['video-file']['tmp_name']);
        $image_type = mime_content_type($_FILES['thumbnail-file']['tmp_name']);

        $video_error = $_FILES['video-file']['error'];
        $thumnail_error = $_FILES['thumbnail-file']['error'];


        if ($video_type == 'video/mp4' && ($image_type == 'image/jpeg' || $image_type == 'image/png')
        && $video_error == UPLOAD_ERR_OK && $thumnail_error == UPLOAD_ERR_OK) {
            $upload_ok = is_uploaded_file($_FILES['video-file']['tmp_name'])
                      && is_uploaded_file($_FILES['thumbnail-file']['tmp_name']);
            
            if($upload_ok){
                $vid_id = $model->addVideo($user->id);

                $target_video_file = "$target_video_dir$vid_id.mp4";
                $target_thumbnail_file;

                $target_thumbnail_file = "$target_thumbnail_dir$vid_id.jpg";

                createThumbnail($_FILES['thumbnail-file']['tmp_name'], $target_thumbnail_file, 1280, 720);
                move_uploaded_file($_FILES['video-file']['tmp_name'], $target_video_file);

                header('Location: ../index.php');
            }
            else{
                echo 'upload pas ok';
            }
        }else{
            echo 'error';
        }
    }
    else{
        echo 'erreur d\'upload, Il faut peut être augmenter la taille de post_max_size, upload_max_filesize ou max_execution_time dans php.ini pour pouvoir uploader des fichiers';
    }
?>
