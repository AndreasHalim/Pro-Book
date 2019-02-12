<?php
    require_once ("../autoload.php");
    function getUserProfile($id){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = 'SELECT * FROM user where id = '.$id;
            $result = $conn->query($sql_query);
            $conn->close();
            if ($result != NULL){
                $row = $result->fetch_assoc();
                return $row;
            } else{
                return [];
            }
        } else{
            return [];
        }
    }

    function setUserProfile($id, $name, $address, $phone, $pp, $tmp_pp, $no_kartu, $username){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query_name = 'UPDATE user SET name = "'.$name.'" WHERE id = '.$id;
            $sql_query_address = 'UPDATE user SET address = "'.$address.'" WHERE id = '.$id;
            $sql_query_phone = 'UPDATE user SET phone = "'.$phone.'" WHERE id = '.$id;
            $sql_query_no_kartu = 'UPDATE user SET no_kartu = "'.$no_kartu.'" WHERE id = '.$id;
            if (($name !== NULL) and ($name !== "")){
                $result = $conn->query($sql_query_name);
            }
            if (($address !== NULL) and ($address !== "")){
                $result = $conn->query($sql_query_address);
            }
            if (($phone !== NULL) and ($phone !== "")){
                $result = $conn->query($sql_query_phone);
            }

            // call Bank-Webservice
            $BANKWS_URL = "http://localhost:3000/update";
            $data = array("no_kartu" => $no_kartu, 
                      "username" => $username);
            $options = array(
                "http" => array(
                    "header"  => "Content-type: application/x-www-form-urlencoded\r\n",
                    "method"  => "POST",
                    "content" => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $res = file_get_contents($BANKWS_URL, false, $context);
            if ($res) {
                $rest = json_decode($res);
            }

            if (($no_kartu !== NULL) and ($no_kartu !== "") and ($rest->values === "true")){
                $result = $conn->query($sql_query_no_kartu);
            }            

            $upload_dir = "../uploads/";
            if ($pp != NULL){
                $upload_file_name = $upload_dir.$pp;
                if (file_exists($upload_file_name)){
                    $sql_query_picture = 'UPDATE user SET profile_picture = "'.$pp.'" WHERE id = '.$id;
                    $result = $conn->query($sql_query_picture);
                } else if (move_uploaded_file($tmp_pp, $upload_dir.$pp)){
                    $sql_query_picture = 'UPDATE user SET profile_picture = "'.$pp.'" WHERE id = '.$id;
                    $result = $conn->query($sql_query_picture);
                }
            }
            return 1;
        } else{
            return 0;
        }
    }
?>