<?php
    require_once ("../database/accessDB.php");
    $username = $_POST["username"];
    $password = $_POST["password"];
    $browse = get_browser(null, true);
    $agent = $browse['browser'].$browse['version'];
    $ip = getRealIpAddr();

    if (userExist($username, $password)){
        login($username, $agent, $ip);
    } else{
        header("Location: ../login");
    }

    function login($username, $agent, $ip) {
        
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        while (!(isTokenExist($token))){
            $token = bin2hex(openssl_random_pseudo_bytes(16));
        }

        $id = getUserID($username);
        setcookie("login", $token, time()+86400,"/");

        if (checkAccessToken($_COOKIE["login"], $id, $agent, $ip)) {
            header("Location: ../browse");
        } else {
            $res = getTokenUsingAgentIP($id, $agent, $ip);
            if ($res == NULL) {
                addToken($token, $id, $agent, $ip);
                header("Location: ../browse");
            } else {
                removeToken($token);
                header("Location: ../login");
            }
        }
    }
?>