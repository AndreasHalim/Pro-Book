<?php
    class bookDetailViewer {
        public const STAR_IMG = 'star.png';
        public const STAR_FULL_IMG = 'star-filled.png';

        public static function viewBookDetail($params) {
            $book_detail = $params['book_detail'];
            $reviews = $params['reviews'];
            $book_rating = $params['book_rating'];
            $book_recommended = $params['book_recommended'];

            echo Header::generateHead($book_detail->judul.' Book Detail', 'book_detail');
            Body::outputInBody(
                Header::headerLogin($params['username']).
                Header::headerMenu(Header::BROWSE).
                self::generateBookDetail($book_detail, $reviews, $book_rating, $book_recommended).
                self::showScript()
            );
        }

        private function generateBookDetail($book_detail, $reviews, $book_rating, $book_recommended) {
            $str = '<body>
                        <div class="detail-container add-nunito-font">'.
                            self::showBookDesc($book_detail, $book_rating).
                            self::showOrder($book_detail).
                            self::showRecommendation($book_recommended).
                            self::showReviews($reviews).
                            self::showModal().
                        '</div>
                    </body>';
            return $str;
        }

        private function showBookDesc($book_detail, $book_rating) {
            $deskripsi = substr($book_detail->deskripsi, 0, 400);
            if (strlen($book_detail->deskripsi) > 100) {
                $deskripsi .= '...';
            }
            $str = '
                <div class="flex-container book-detail">
                    <div class="flex-1 book-desc">
                        <div class="title-author">
                            <div class="book-title orange-text" ><b>'.$book_detail->judul.'</b></div>
                            <div class="book-author">'.$book_detail->pengarang.'</div>
                        </div>
                        <div id="detail-paragraph">'.$deskripsi.'</div>
                    </div>
                    <div class="add-flex-direction-column" id="rightbar-pic" align="center">
                        <div class="flex-1">
                            <img id="book-pict" src="'.self::showPicture('book', $book_detail->gambar).'">
                        </div>
                        <div class="rating-pict">'.
                        self::drawRating($book_rating).
                        '</div>
                        <div class="text-size-20"><b>'.self::floatRating($book_rating).'/5.0</b></div>
                    </div>
                </div>';
            return $str;
        }

        private function drawRating($book_rating) {
            $count = floor($book_rating);
            $str = '<div class="rating-pict">';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $count) {
                    $star = self::STAR_FULL_IMG;
                } else {
                    $star = self::STAR_IMG;
                }
                $img = '<img class="rating" src="../svgIcon/'. $star.'">';
                $str = $str . $img;
            }
            return $str . '</div>';
        }

        private function showPicture($obj, $input) {
            if ($obj == "book") {
                if ($input != "N/A") {
                    return $input;
                } else {
                    return '/images/tayo.jpg';
                }
            } else {
                if ($input == "null" || $input == NULL || !fileProcessing::isExistProfileImage($input)) {
                    return '/images/profiles_picture/default.jpg';
                } else {
                    return '/uploads/'.$input;
                }
            }
        }

        private function showOrder($book_detail) {
            if ($book_detail->isForSale) {
                $show_price = $book_detail->mataUang.' '.$book_detail->harga;
                $show_order = '
                    <div class="order-select">
                        <p id="price">Price: <b>'.$show_price.'</b></p>
                        <label>Harga: </label>
                        <select id="dropdown-order">'.
                            self::generateDropdown().
                        '</select>
                    </div>
                    <div align="right">
                        <button class="order-button c-button light-blue" type="button" onclick="orderBook(\''.$book_detail->idBuku.'\', '.$book_detail->harga.')">Order</button>
                    </div>';
            } else {
                $show_order = '<p id="notAvailable"><b>NOT FOR SALE</b></p>';
            }
            $str = '
                <div class="book-detail">
                    <div class="head-title">Order</div>
                    '.$show_order.'
                </div>';
            return $str;
        }

        private function showRecommendation($book_recommended) {
            $items = '';
            foreach($book_recommended as $book) {
                if ($book->isForSale) {
                    $show_price = '<div class="price">'.$book->mataUang.' '.$book->harga.'</div>';
                } else {
                    $show_price = '<div class="price notForSale">NOT FOR SALE</div>';
                }
                $item = '
                    <div class="book-recommended">
                        <a class="recommended-detail" href="/book_detail?idBuku='.$book->idBuku.'&pengarang='.urlencode($book->pengarang).'">
                            <div class="book-image">
                                <img id="book-pict" src="'.$book->gambar.'">
                            </div>
                            <div class="detail-recommend">
                                <div class="title orange-text">'.$book->judul.'</div>
                                <div class="author">'.$book->pengarang.'</div>
                                '.$show_price.'
                            </div>
                        </a>
                    </div>
                ';
                $items = $items . $item;
            }
            $str = '
                <div class="book-detail">
                    <div class="head-title">Recommendation</div>
                    <div class="slider-recommendation">
                        <div class="recommend-row">'
                            .$items.
                        '</div>
                    </div>
                </div>';
            return $str;
        }

        private function showReviews($reviews) {
            $str = '
                <div class="book-detail">
                    <div class="head-title">Reviews</div>
                        <div class="reviews">'.
                            self::showPerReview($reviews).
                        '</div>
                </div>';
            return $str;
        }

        private function showPerReview($reviews) {
            $str = '';
            if ($reviews != null) {
                foreach ($reviews as $review) {
                    $str_review = '
                        <div class="flex-container align-items-flex-start">
                            <div class="flex-1 flex-review-tab">
                                <div class="reviewer-profile">
                                    <img id="profile_pict" src="'.self::showPicture('user', $review['profile_picture']).'">
                                </div>
                                <div id="comment-user">
                                    <div id="reviewer">@'.$review['username'].'</div>
                                    <div id="detail-paragraph">'.$review['komentar'].'</div>
                                </div>
                            </div>
                            <div class="add-flex-direction-column">
                                <div> <img id="star-icon" src="../svgIcon/'.self::STAR_FULL_IMG.'">
                                </div>
                                <div class="text-size-20" align="center"><b>'.self::floatRating($review['rating']).'/5.0</b></div>
                            </div>
                        </div>';
                    $str = $str . $str_review;
                }
            } else {
                $str = '<p id="notAvailable">No review yet.</p>';
            }
            return $str;
        }

        private function showScript() {
            return '<script type="text/javascript" src="../javascript/order-book.js"></script>';
        }
        
        private function showModal() {
            return '<div id="modal-container">
                        <img id="loading-gif" src="/images/loading-circle.gif">
                        <div id="show-modal"></div>
                    </div>';
        }

        private function generateDropdown() {
            $str = "";
            for ($i=1; $i<=50; $i++) {
                $str .= '<option value="'.$i.'">'.$i.'</option>';
            }
            return $str;
        }

        private function floatRating($rate) {
            return number_format((float)$rate, 1, '.', '');
        }
    }
?>