<?php
    require_once ("../autoload.php");
    function removeCookieAndToken(){
        $token = $_COOKIE["login"];
        removeToken($token);
        unset($_COOKIE["login"]);
    }
?>