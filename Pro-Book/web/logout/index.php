<?php
    require_once("controller.php");
    removeCookieAndToken();
    $login = '../login';
    header('Location: '.$login);
?>