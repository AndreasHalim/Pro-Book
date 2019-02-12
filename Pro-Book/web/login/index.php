<?php
    require_once ("../autoload.php");
    $browse = "../browse";
    if (!isLogin()){
        include ("view.php");
    } else{
        header ("Location: $browse");
    }
?>