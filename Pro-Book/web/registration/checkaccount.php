<?php
    require ('controller.php');

    // get the q parameter from URL
    $type = $_REQUEST["type"];
    $input = $_REQUEST["q"];

    $listofaccounts = selectColumnFromTable($type, 'user');
    drawTick ($input, $listofaccounts);
?>