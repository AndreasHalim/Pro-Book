<?php
    require ('../autoload.php');
    require ('view.php');

    class bookDetailController {
        private $BOOKWS_URL = "http://localhost:9000/bookservice?wsdl";
        private $username;
        private $book_id;
        private $book_detail;
        private $reviews;
        private $book_rating;
        private $fetchsuccess = TRUE;
        private $book_recommended;

        public function __construct($book_id, $username, $author) {
            $this->book_id = $book_id;
            $this->username = $username;
            $this->fetchBook($author);
            $this->fetchRecommendations();
        }

        public function showBookDetail() {
            if ($this->fetchsuccess) {
                $this->fetchReviews();
                $this->fetchRating();

                $params = [
                    'username' => $this->username,
                    'book_detail' => $this->book_detail,
                    'reviews' => $this->reviews,
                    'book_rating' => ($this->book_rating + $this->book_detail->rating)/2,
                    'book_recommended' => $this->book_recommended
                ];
                bookDetailViewer::viewBookDetail($params);
            } else {
                include('../404.html');
            }
        }

        private function fetchBook($author) {
            $client = new SoapClient($this->BOOKWS_URL);
            $param = array(
                "id" => $this->book_id,
                "author" => $author
            );
            $result = $client->__soapCall("getBookByID", $param);
            if ($result->jumlahBuku == 1) {
                $this->book_detail = $result->buku;
            } else if ($result->jumlahBuku > 1) {
                $this->book_detail = $result->buku[0];
            } else {
                $this->fetchsuccess = FALSE;
            }
        }
        
        private function fetchReviews() {
            $conn = connect_to_mysql();
            $sql_query =   'SELECT username, profile_picture, komentar, rating
                            FROM (
                                SELECT order_id, book_id, user_id, komentar, rating
                                FROM (
                                    SELECT Nomor_Order, book_id, user_id
                                    FROM books INNER JOIN book_order ON books.ID=book_id 
                                    WHERE books.id='. $this->book_id .') as T1
                                INNER JOIN review ON Nomor_Order=order_id) as T2
                                INNER JOIN user ON user_id=user.id
                          ';
            $result = $conn->query($sql_query);
            $conn->close();
            
            if ($result != NULL) {
                $this->reviews = [];
                while ($row = $result->fetch_assoc())
                    $this->reviews[] = $row;
            } else {
                $this->reviews = NULL;
            }
        }

        private function fetchRating() {
            if ($this->reviews != NULL) {
                $count = 0;
                $sum = 0.0;
                foreach ($this->reviews as $review) {
                    $sum += $review['rating'];
                    $count += 1;
                }
                $this->book_rating = round($sum/$count, 1);
            } else {
                $this->book_rating = 0;
            }
        }

        private function fetchRecommendations() {
            $client = new SoapClient($this->BOOKWS_URL);
            $param = array(
                "id" => "1Q2W3"
            );
            $result = $client->__soapCall("getRekomendasi", $param);
            if ($result->jumlahBuku > 0) {
                $this->book_recommended = array_slice($result->buku, 0, 4);
            } else {
                $this->fetchsuccess = FALSE;
            }
        }
    }
?>