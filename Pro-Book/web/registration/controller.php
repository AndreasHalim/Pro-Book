<?php
    require_once ('../database/accessDB.php');

    function selectColumnFromTable($attr, $table) {
        $conn = connect_to_mysql();
        $listofattr = [];
        if ($conn !== NULL){
            $sql_query = "SELECT ". $attr ." FROM ". $table;
            $result = $conn->query($sql_query);
            if ($result != NULL){
                while ($row = $result->fetch_assoc()) {
                    $listofattr[] = $row[$attr];
                }
            }
            $conn->close();
        }
        return $listofattr;
    }
    
    function insertNewUser($name, $username, $password, $email, $address, $phonenumber, $no_kartu) {
        $conn = connect_to_mysql();
        if ($conn !== NULL) {
            $sql_query = 'INSERT INTO user (name, username, password, email, address, phone, profile_picture, no_kartu)
                          VALUES ("'. $name . '", "' . $username . '", "' . $password . '", "' 
                                   . $email . '", "' . $address . '", "' . $phonenumber . '", "null", "' . $no_kartu . '")';
            
            $result = $conn->query($sql_query);
            $conn->close();
        }
    }  

    function drawTick ($param, $listofaccounts) {
        if ($param !== "") {
            $found = false;
            foreach ($listofaccounts as $account) {
                if ($param == $account) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                echo '';
            } else {
                echo '<img src="../svgIcon/tick.png">';
            }
        }
    }
?>