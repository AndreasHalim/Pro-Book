<?php
    require ('../database/accessDB.php');
    require ('view_modal.php');
    //Account Pro-Book
    $probook_acc = '11111';

    //check login state
    if (isLogin()) {
        $user_token = getTokenLogin();
        $user = getUserInfo(getUserIDbyToken($user_token));

        $book_id = $_POST['book_id'];
        $quantity = $_POST['qty'];
        $book_price = $_POST['price'];
        $result = createNewOrder($book_id, $user['ID'], $quantity, $book_price);
        showOrderModal($result);
    }

    //CREATE NEW ORDER
    function createNewOrder($book_id, $user_id, $quantity, $book_price) {
        $conn = connect_to_mysql();
        if ($conn !== NULL) {
            $no_pengirim = getUserBankAccount($conn, $user_id); // pengirim
            $no_penerima = $GLOBALS["probook_acc"]; //penerima
            $total_price = $quantity*$book_price;
            $response_bank = transactionToBankWS($no_pengirim, $no_penerima, $total_price);

            if ($response_bank->values->success) {
                $isSuccess = transactionToBookWS($no_pengirim, $book_id, $quantity);
                if ($isSuccess) {
                    $response_local = saveNewOrderDB($conn, $book_id, $user_id, $quantity);
                    return $response_local;
                } else {
                    return createResponse(500, "Error inserting into Book Webservice");
                }
            } else {
                return $response_bank;
            }
        } else {
            return createResponse(400, "Error connecting to DB");
        }
    }

    //Connect to Bank Webservice
    function transactionToBankWS($no_pengirim, $no_penerima, $total) {
        $BANKWS_URL = 'http://localhost:3000/transaksi';
        $data = array('no_pengirim' => $no_pengirim, 
                      'no_penerima' => $no_penerima,
                      'jumlah' => $total);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($BANKWS_URL, false, $context);
        if (!$result) {
            /* Handle error */
            return createResponse(500, 'Error connecting to server');
        } else {
            return json_decode($result);
        }
    }

    //Connect to Book Webservice: insert Purchase
    function transactionToBookWS($no_pengirim, $id_buku, $jumlah) {
        $BOOKWS_URL = 'http://localhost:9000/bookservice?wsdl';
        $client = new SoapClient($BOOKWS_URL);
        $params = array(
            "id_buku" => $id_buku,
            "jml" => $jumlah,
            "no_kartu" => $no_pengirim
        );
        $isSuccess = $client->__soapCall("insertPurchase", $params);
        return $isSuccess;
    }
    
    function getUserBankAccount($conn, $user_id) {
        $sql_query = 'SELECT no_kartu FROM user WHERE ID="'. $user_id . '"';
        $result = $conn->query($sql_query);
        
        if ($result != NULL){
            $row = $result->fetch_assoc();
            return $row["no_kartu"];
        } else{
            return $user_id;
        }
    }

    //Save history to local DB
    function saveNewOrderDB($conn, $book_id, $user_id, $quantity) {
        $sql_query = 'INSERT INTO book_order (jumlah, tanggal, has_reviewed, book_id, user_id)
                        VALUES ("'. $quantity . '", NOW(), 0, "' 
                                . $book_id . '", "' . $user_id . '")';
        $result = $conn->query($sql_query);
        
        if ($result != NULL) {
            $order_id = mysqli_insert_id($conn);
            $conn->close();
        } else {
            $order_id = NULL;
            $conn->close();
            return createResponse(400, "Pro-Book Internal Error");
        }
        return createResponse(200, $order_id);
    }

    function createResponse($status, $message) {
        $res = new stdClass();
        $res->status = $status;
        $res->values->success = true; //for transaction
        $res->values->result = $message;
        return $res;
    }
?>