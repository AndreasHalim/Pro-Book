<?php 
    require_once ("../autoload.php");
    $edit = "view.php";
    $login = "../login/index.php";
    if (isLogin()){
        include ($edit);
    } else{
        header("Location: ../login");
    }
?>