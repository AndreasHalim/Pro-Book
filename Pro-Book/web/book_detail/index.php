<?php
    require('controller.php');

    if (isLogin()) {
        $user_token = getTokenLogin();
        $user = getUserInfo(getUserIDbyToken($user_token));
        
        if (isset($_GET['idBuku']) && isset($_GET['pengarang'])) {
            $book_id = $_GET['idBuku'];
            $author = $_GET['pengarang'];
            $bookDetail = new bookDetailController($book_id, $user['username'], $author);
            $bookDetail->showBookDetail();
        } else {
            include ('../404.html');
        }
    } else {
        $login = '../login';
        header('Location: '.$login);
    }
?>