<?php
require ('view.php');

class historyController {
    public static function showHistoryController() {
        if (isLogin()) {
            $user_token = getTokenLogin();
            $user = getUserInfo(getUserIDbyToken($user_token));
            $params = [
                'username' => $user['username'],
                'dataHistoryItem' => self::selectBookOrderByUserId($user['ID'])
            ];
            historyView::viewHistory($params);
        } else {
            $login = '../login';
            header('Location: '.$login);
        }
    }
    public static function selectBookOrderByUserId (string $userId) {
        $conn = connect_to_mysql();
        $arrResult = array();
        if ($conn != null) {
//            $sql_query = "SELECT * FROM book_order JOIN books ON book_id=books.ID where user_Id=$userId ORDER BY tanggal DESC";
            $sql_query = "
                        SELECT 
                            *,
                            (CASE
                                WHEN EXISTS (SELECT * FROM review where Nomor_Order=order_id) THEN TRUE
                                ELSE FALSE
                            END) as reviewed
                        FROM 
                            book_order 
                        JOIN 
                            books
                        ON 
                            book_id=books.ID 
                        where user_Id=$userId ORDER BY tanggal DESC, Nomor_Order DESC
            ";
            $result = $conn->query($sql_query);
            if ($result != NULL){
                while ($row = $result->fetch_assoc()) {
                    $arrResult[] = self::orderItemsToViewHistoryParams($row);
                }
            }
            $conn->close();
            return $arrResult;
        } else {
            return null;
        }
    }

    private static function orderItemsToViewHistoryParams(array $orderItem){
        $defaultImageUrl = '../images/books_picture/default.jpg';
        if (fileProcessing::isExistBookImage($orderItem['book_id'])) {
            $imgSource = '../'.fileProcessing::getImageBookPathFromRoot($orderItem['book_id']);
        } else {
            $imgSource = $defaultImageUrl;
        }

        $result = [
            'itemName' => $orderItem['Judul'],
            'numberOfItem' => $orderItem['jumlah'],
            'statusReviewed' => $orderItem['has_reviewed'],
            'orderNumber' => $orderItem['Nomor_Order'],
            'date' => dateDataBaseToIndonesiaDate($orderItem['tanggal']),
            'imgSource' => $imgSource,
            'reviewUrl' => 'review'
        ];
        return $result;
    }
}