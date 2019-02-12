<?php
require_once ('view.php');

class browseController {
    public static function showBrowseController() {
        if (isLogin()) {
            $user_token = getTokenLogin();
            $params = ['username' => getUsername($user_token)];
            viewBrowse($params);
        } else {
            $login = '../login';
            header('Location: '.$login);
        }
    }

    public static function retrieveBooks(array $params) {
        $client = new SoapClient("http://localhost:9000/bookservice?wsdl");
        $param = array(
            "input" => $params["search_text"]
        );
        $respond = $client->__soapCall("searchBooks", $param);
        return $respond;
    }

    public static function showResultController(array $params) {
        $book_result = self::retrieveBooks($params);
        searchResultView::viewResult($book_result);
    }
}