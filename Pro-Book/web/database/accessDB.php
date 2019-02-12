<?php
    require_once('../config.php');
    
    function connect_to_mysql(){
        $servername =  CONFIG['DB_HOST'];
        $sqlusername = CONFIG['DB_USERNAME'];
        $sqlpassword = CONFIG['DB_PASSWORD'];
        $dbname = CONFIG['DB_DATABASE'];

        $conn = new mysqli($servername, $sqlusername, $sqlpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            //die("Connection failed: " . $conn->connect_error);
            return null;
        } else{
            return $conn;
        }
    }

    function userExist($username, $password){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = "SELECT username, password FROM user";
            $result = $conn->query($sql_query);
            $found = FALSE;
            if ($result != NULL){
                while ((!$found) and ($row = $result->fetch_assoc())) {
                    // echo $row["username"], " ", $row["password"];
                    if (($row["username"] == $username) and ($password == $row["password"])){
                        $found = TRUE;
                    }
                }
            }else{
                echo "No Result";
            }
            $conn->close();
            return $found;
        } else{
            return FALSE;
        }

    }
    function getUserID($username){
        // user pasti ada dan unik
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = 'SELECT id FROM user where username = "'.$username.'"';
            $result = $conn->query($sql_query);
            $conn->close();
            if ($result != NULL){
                $row = $result->fetch_assoc();
                return $row["id"];
            } else{
                return 0;
            }
        } else{
            return 0;
        }
    }

    function getUserInfo($userId) {
        //user pasti ada dan unik
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = "SELECT * FROM user where ID=$userId";
            $result = $conn->query($sql_query);
            $conn->close();
            if ($result !== NULL){
                $row = $result->fetch_assoc();
                return $row;
            } else{
                return NULL;
            }
        } else{
            return NULL;
        }
    }

    function getUserIDbyToken($token){
        // user pasti ada dan unik
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = "SELECT * from active_token where token = \"".$token."\"";
            $result = $conn->query($sql_query);
            $conn->close();
            if ($result != NULL){
                $row = $result->fetch_assoc();
                return $row["user_id"];
            } else{
                return 0;
            }
        } else{
            return 0;
        }
    }

    function getUsername($token){
        $conn = connect_to_mysql();
        $id = getUserIDbyToken($token);
        if (($conn !== NULL) and ($id != 0)){
            $sql_query = 'SELECT * from user where ID = "'.$id.'"';
            $result = $conn->query($sql_query);
            $conn->close();
            $row = $result->fetch_assoc();
            return $row["username"];
        } else{
            return 0;
        }
    }
    function isTokenExist($token){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = 'SELECT * from active_token where token = "'.$token.'"';
            $result = $conn->query($sql_query);
            $found = FALSE;
            if ($result != NULL){
                $found = TRUE;
            } else{
                $found = FALSE;
            }
            $conn->close();
            return $found;
        } else{
            return FALSE;
        }
    }

    function getTokenExpiredTime($token){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = 'SELECT * from active_token where token = "'.$token.'"';
            $result = $conn->query($sql_query);
            $conn->close();
            if ($result != NULL){
                $row = $result->fetch_assoc();
                return $row["expiry_time"];
            } else{
                return 0;
            }
        } else{
            return 0;
        }
    }

    
    function getTokenUsingAgentIP($user_id, $agent, $ip){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = 'SELECT * from active_token where user_id = '.$user_id.' and agent = "'.$agent.'" and ip = "'.$ip.'"';
            $result = $conn->query($sql_query);
            if ($result != NULL){
                $row = $result->fetch_assoc();
                return $row["token"];
            } else{
                return NULL;
            }
            $conn->close();
        } else{
            return NULL;
        }
    }

    function addToken($token, $user_id, $agent, $ip){
        $conn = connect_to_mysql();            
        if ($conn !== NULL){
            date_default_timezone_set('Asia/Bangkok');
            $now_time = date("Y-m-d H:i:s",time());
            
            $session_length = 1; //in hour
            if (date("H", time()) < 23){
                $make_expiry_time = mktime(date("H",time())+$session_length, date("i",time()), date("s",time()), date("m",time()), date("d",time()), date("Y",time()));
            } else {
                $make_expiry_time = mktime((date("H",time())+$session_length)/24, date("i",time()), date("s",time()), date("m",time()), date("d",time())+1, date("Y",time()));
            }
            $expiry_time =  date("Y-m-d H:i:s", $make_expiry_time);
            $sql_query = 'INSERT into active_token(token, agent, ip, expiry_time, user_id) values ("'.$token.'","'.$agent.'","'.$ip.'","'.$expiry_time.'",'.$user_id.')';
            $result = $conn->query($sql_query);
           
            $conn->close();
            return $result;
        } else {
            return FALSE;
        }
    }

    function checkAccessToken($token, $user_id, $agent, $ip) {
        $conn = connect_to_mysql();
        if ($conn !== NULL){

            $sql_query = 'SELECT * FROM active_token where token = "'.$token.'" and user_id = '.$user_id.' and agent = "'.$agent.'" and ip = "'.$ip.'"';

            $result = $conn->query($sql_query);
            $conn->close();
            
            if (mysqli_num_rows($result)==0){
                return FALSE;                    
            } else {
                return TRUE;                    
            }
        }
        
    }

    function removeToken($token){
        $conn = connect_to_mysql();
        if ($conn !== NULL){
            $sql_query = 'DELETE FROM active_token where token = "'.$token.'"';
            $result = $conn->query($sql_query);
            $conn->close();
        }
    }

    function getRealIpAddr(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function isLogin(){
        if (isset($_COOKIE['login'])){
            $browse = get_browser(null, true);
            $agent = $browse['browser'].$browse['version'];
            $ip = getRealIpAddr();
            $token = $_COOKIE["login"];
            $user_id = getUserID(getUsername($token));

            date_default_timezone_set('Asia/Bangkok');
            $now_time = date("Y-m-d H:i:s",time());
            
            if (isTokenExist($token) and ($now_time < getTokenExpiredTime($token)) and checkAccessToken($token, $user_id, $agent, $ip)){
                return TRUE;
            } else{
                return FALSE;
            }
        } else{
            return FALSE;
        }
        
    }

    function getTokenLogin() {
        return $_COOKIE["login"];
    }

    // function selectFromWhere($attr, $table, $wherecondition) {
    //     $conn = connect_to_mysql();
    //     $listofattr = [];
    //     if ($conn !== NULL){
    //         $sql_query = "SELECT ". $attr ." FROM ". $table ." WHERE ". $wherecondition;
    //         $result = $conn->query($sql_query);
    //         if ($result != NULL){
    //             while ($row = $result->fetch_assoc()) {
    //                 $listofattr[] = $row[$attr];
    //             }
    //         }
    //         $conn->close();
    //     }
    //     return $listofattr;
    // }

?>