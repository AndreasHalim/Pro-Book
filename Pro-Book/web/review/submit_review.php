<?php
    include_once ('../database/accessDB.php');

    $rating = $_POST['rating-value'];
    $comment = $_POST['comment'];
    $book_id = $_POST['book-id'];
    $order_id = $_POST['order-id'];
    
    $insertsuccess = insertReview($order_id, $rating, $comment);
    header("Location: ../history");

    function insertReview($order_id, $rating, $comment) {
        $conn = connect_to_mysql();
        $sql_query = 'INSERT INTO review(order_id, komentar, rating)
                        VALUES ('. $order_id .', "'.$comment.'", '.$rating.')';
        $result = $conn->query($sql_query);
        $querystatus = setOrderReviewed($conn, $order_id);
        $conn->close();
        return $querystatus;
    }

    function setOrderReviewed($conn, $order_id) {
        $sql_query = 'UPDATE book_order SET has_reviewed=1 WHERE Nomor_Order='.$order_id;
        $result = $conn->query($sql_query);
        return $result != NULL;
    }
?>