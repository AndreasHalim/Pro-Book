<?php
    require_once ("../autoload.php");
    require_once("controller.php");
    $user_token = $_COOKIE["login"];
    $user_id = getUserIDbyToken($user_token);
    $username = getUsername($user_token);
    $update_name = $_POST["name"];
    $update_address = $_POST["address"];
    $update_phone = $_POST["phone"];
    $update_no_kartu = $_POST["no_kartu"];
    if (isset($_POST['submit'])){
        if(isset($_FILES["profile_picture"])){
            $name = $_FILES["profile_picture"]["name"];
            $tmp_name = $_FILES["profile_picture"]["tmp_name"];
        } else{
            $name = NULL;
            $tmp_name = NULL;    
        }
    } else{
        $name = NULL;
        $tmp_name = NULL;
    }

    $update = setUserProfile($user_id, $update_name, $update_address, $update_phone, $name, $tmp_name, $update_no_kartu, $username);
    header('Location: ../profile');
    exit;
?>