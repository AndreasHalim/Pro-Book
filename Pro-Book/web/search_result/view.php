<?php
    require_once("../autoload.php");
    
    class searchResultView{
        public static function viewResult(array $params){
            Body::outputInBody(
                self::generateSearchResult($params)
            );
        }
        private static function generateSearchResult(array $params){
            $top = '
                <div class="rows">
                    <div class="title-container">
                        <div class="title-left"><h1 class="add-nunito-font">Search Result</h1></div>
                        <div class="title-right"><p class="tRight">Found <u>'.$params->jumlahBuku.'</u> result(s)</p></div>
                    </div>
            ';
            $end = '
                </div>
            ';
            return $top.self::generateSearchItemResult($params).$end;
        }
        private static function generateSearchItemResult(array $params){
            
            
            $i = 0;
            $result = '';
            $num_rows = $params["item"]->num_rows;
            if ($num_rows == 0){
                $result = '<div class="main-container">
                                <div class="main-left">
                                    <h3>NO RESULT</h3>
                                </div>
                            </div>
                ';
            } else{
                while ($i < $num_rows){
                    $row = $params["item"]->fetch_assoc();
                    $id = $row["ID"];
                    $judul = $row["Judul"];
                    $desc = $row["Deskripsi"];
                    $pengarang = $row["Pengarang"];
                    $rating  = $row["avg_rating"];
                    $rating_format = number_format((float)$rating, 2, '.', '');
                    $count_votes = $row["count"];
                    if ($id == NULL){
                        $id = 0;
                    }
                    if (fileprocessing::isExistBookImage($id)){
                        $src = '../images/books_picture/'.$id.'.jpg';
                    }else{
                        $src = '../images/books_picture/default.jpg';
                    }
                    $result = $result.'
                        <div class="main-container">
                            <div class="main-left">
                                <img class="pp" src="'.$src.'" alt="Profile Picture">
                            </div>
                            <div class="main-right">
                                <h3>'.$judul.'</h3>
                                <h4>'.$pengarang.' - '.$rating_format.'/5.0 ('.$count_votes.' Votes)</h4>
                                <p class="desc">'.$desc.'</p>
                            </div>
                        </div>
                        <div class="button_row">
                            <button type="button" class="add-nunito-font light-blue c-round" onclick="location.href=\'../book_detail?id='.$id.'\';">Detail</button>
                        </div>
                    ';
                    $i += 1;
                }
            }
            
            return $result;
        }
    }
        
?>