<?php
    require ('controller.php');

    //Login Check
    if (isLogin()) {
        $user_token = getTokenLogin();
        $user = getUserInfo(getUserIDbyToken($user_token));
        
        if (isset($_GET['id'])) {
            $order_id = $_GET['id'];
            //$order_id = 301; //dummy
            if (reviewController::validateOrderHistory($order_id, $user['ID'])) {
                $review = new reviewController($order_id, $user['username']);
                $review->showReviewForm();
            } else {
                include ('../404.html');
            }
        } else {
            include ('../404.html');
        }
    } else {
        $login = '../login';
        header('Location: '.$login);
    }
?>