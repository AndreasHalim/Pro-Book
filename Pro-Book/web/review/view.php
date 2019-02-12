<?php
    class reviewFormViewer {
        public static function viewReviewForm($params) {
            $ordered_book = $params['ordered_book'];

            echo Header::generateHead($ordered_book['Judul'].' Review', 'review');
            Body::outputInBody(
                Header::headerLogin($params['username']).
                Header::headerMenu(Header::HISTORY).
                self::showScript().
                self::showBody($ordered_book)
            );
        }

        private function showScript() {
            return '<script type="text/javascript" src="../javascript/review-book.js"></script>';
        }

        private function showBody($ordered_book) {
            $str = '<body>
                        <div class="detail-container add-nunito-font">'.
                            self::showBookDesc($ordered_book).
                            self::showReviewForm($ordered_book['order_id'], $ordered_book['book_id']).
                        '</div>
                    </body>';
            return $str;
        }

        private function showBookDesc($ordered_book) {
            $str = '
                <div class="flex-container book-detail">
                    <div class="flex-1">
                        <div class="book-title orange-text"><b>'.$ordered_book['Judul'].'</b></div>
                        <div class="book-author"><b>'.$ordered_book['Pengarang'].'</b></div>
                    </div>
                    <div class="add-flex-direction-column" id="rightbar-pic" align="center">
                        <div class="flex-1">
                            <img id="book-pict" src="'.self::showPicture($ordered_book['book_id']).'">
                        </div>
                    </div>
                </div>';
            return $str;
        }

        private function showPicture($input) {
            if (fileProcessing::isExistBookImage($input)) {
                return fileProcessing::getImageBookPathFromRoot($input);
            } else {
                return '/images/books_picture/default.jpg';
            }
        }
        
        private function showReviewForm($order_id, $book_id) {
            $str = '
                <form id="book-review" action="review/submit_review.php" onsubmit="return trySubmitSearch()" method="POST">
                    <div class="book-detail">
                        <div class="head-title">Add Rating</div>
                        <div class="order-select">'.
                            self::showRatingButton().           
                            self::showHiddenInputForm($order_id, $book_id).                 
                        '</div>
                    </div>
                    <div class="book-detail">
                        <div class="head-title">Add Comment</div>
                        <div class="flex-review-tab">
                            <div class="comment-bar">
                                <textarea id="comment" class="textarea-comment" name="comment" cols="180" rows="5"></textarea>
                                <p id="comment-area" class="warning-empty-input red-theme alert-box text-size-20 add-nunito-font c-round">
                                    Input can\'t be empty</p>
                            </div>
                        </div>
                    </div>
                    <div class="review-button">
                        <div>
                            <button class="back-button c-button" type="button" onClick="window.history.back()">Back</button>
                            <button class="submit-button c-button light-blue" type="submit">Submit</button>
                        </div>
                    </div>
                </form>';
            return $str;
        }

        private function showRatingButton() {
            $str = '
                <div class="rating-pict">'.
                    self::show5Stars().
                    '<p id="rating-area" class="warning-empty-input red-theme alert-box text-size-20 add-nunito-font c-round">
                    Rating can\'t be empty</p>
                </div>';
            return $str;
        }

        private function show5Stars() {
            $str = "";
            for ($i=1; $i<=5; $i++) {
                $str = $str .
                        '<input type="image" id="star'.$i.'" class="fivestar-rating" 
                            onclick="ratingClick(this.value); return false;" src="../svgIcon/star.png"
                            value="'.$i.'" onmouseout="noHoverStar(this.value)"
                            onmouseover="hoverStar(this.value)">';
            }
            return $str;
        }

        private function showHiddenInputForm($order_id, $book_id) {
            $str = '
                <!-- Values submitted via POST Method-->
                <input name="rating-value" id="rating-given" type="hidden" value="0">
                <input name="order-id" type="hidden" value="'.$order_id.'">
                <input name="book-id" type="hidden" value="'.$book_id.'">';
            return $str;
        }
    }
?>