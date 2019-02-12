<?php
    require_once ("controller.php");
    require_once ("../autoload.php");
    $search_result = "view.php";
    $login = "../login/index.php";
    if (isLogin()){
        $text = $_GET["search_text"];
        $param = ["search_text" => $text];
        resultController::showResultController($param);
    } else{
        header("Location: ../login");
    }
?>