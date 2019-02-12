<?php
    require ('../autoload.php');
    require ('view.php');

    class reviewController {
        private $username;
        private $order_id;
        private $ordered_book;
        private $fetchsuccess = TRUE;

        public function __construct($order_id, $username) {
            $this->order_id = $order_id;
            $this->username = $username;
            $this->fetchOrderDetail();
        }

        public function showReviewForm() {
            if ($this->fetchsuccess) { 
                $params = [
                    'username' => $this->username,
                    'ordered_book' => $this->ordered_book
                ];
                reviewFormViewer::viewReviewForm($params);
            } else {
                include('../404.html');
            }
        }

        private function fetchOrderDetail() {
            $conn = connect_to_mysql();
            $sql_query = 'SELECT Judul, Pengarang, Nomor_Order as order_id, book_id
                          FROM (SELECT Nomor_Order, book_id FROM book_order WHERE Nomor_Order='. $this->order_id .
                          ') as T1 INNER JOIN books ON id=book_id';
            $result = $conn->query($sql_query);

            $this->ordered_book = $result->fetch_assoc();
            if ($this->ordered_book == NULL) {
                $this->fetchsuccess = FALSE;
            }
            $conn->close();
        }

        public static function validateOrderHistory($order_id, $user_id) {
            $listOfHistoryID = selectFromWhere('Nomor_Order', 'book_order', 'user_id='.$user_id);
            foreach ($listOfHistoryID as $hist) {
                if ($hist == $order_id) {
                    return TRUE;
                }
            }
            return FALSE;
        }
    }
?>