<?php
    require ('controller.php');
    require ('../login/login.php');

    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phonenumber= $_POST["phonenumber"];
    $no_kartu = $_POST["no_kartu"];

    insertNewUser($name, $username, $password, $email, $address, $phonenumber, $no_kartu);
    login($username);
?>