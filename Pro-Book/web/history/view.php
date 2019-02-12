<?php

require ('../autoload.php');

class historyView {
    public static function viewHistory (array $params) {
        echo Header::generateHead('History', 'history');
        Body::outputInBody(
            Header::headerLogin($params['username']).
            Header::headerMenu(Header::HISTORY).
            self::generateHistory($params)
        );
    }

    private static function generateHistory (array $params) {
        $resultHTML = '            
            <div id="label-history-div" class="orange-text text-size-80">
                <label id="label-history" >History</label>
            </div>
         ';
        return $resultHTML.self::generateHistoryItems($params);
    }


    private static function generateHistoryItems (array $params) {
        #Use map function, must read map array php, use for ease of read
        $newArrayData = array_map(array('historyView', 'generateItem'), $params['dataHistoryItem']);

        return join("",$newArrayData);
    }

    private  static  function generateItem (array $data) {
        if ($data['statusReviewed']) {
            return self::generateHistoryItemReviewed($data);
        } else {
            return self::generateHistoryItemNotReviewed($data);
        }
    }
    private static function generateHistoryItemNotReviewed (array $data) {
        $resultHTML = '
            <div class="flex-history-item align-items-flex-start">
                <div class="flex-1">
                    <img class="c-border history-image-item" src="'.$data['imgSource'].'">
                </div>
                <div class="flex-2" >
                    <div class="orange-text text-size-40 title-item-history" >'.$data['itemName'].'</div>
                    <div class="text-size-20 gray-text">Jumlah : '.$data['numberOfItem'].'</div>
                    <div class="text-size-20 gray-text">Anda belum memberikan review</div>
                </div>
                <div id="right-most-column-history-item">
                    <div class="flex-container align-items-flex-end  add-flex-direction-column ">
                        <div class="font-weight-bold text-size-20 gray-text">'.$data['date'].'</div>
                        <div class="font-weight-bold text-size-20 gray-text">Nomor Order : #'.$data['orderNumber'].'</div>                    
                    </div>
                    <div class="flex-container add-flex-end-justify ">
                        <a href="review?id='.$data['orderNumber'].'" class="c-button light-blue c-round">Review</a>
                    </div>
                </div>
            </div>
        ';

        return $resultHTML;
    }


    private static function generateHistoryItemReviewed (array $data) {
        $resultHTML = '
            <div class="flex-history-item align-items-flex-start">
                <div class="flex-1">
                    <img class="c-border history-image-item" src="'.$data['imgSource'].'">
                </div>
                <div class="flex-2" >
                    <div class="orange-text text-size-40 title-item-history" >'.$data['itemName'].'</div>
                    <div class="text-size-20 gray-text ">Jumlah : '.$data['numberOfItem'].'</div>
                    <div class="text-size-20 gray-text">Anda sudah memberikan review</div>
                </div>
                <div id="right-most-column-history-item">
                    <div class="flex-container align-items-flex-end  add-flex-direction-column ">
                        <div class="font-weight-bold text-size-20 gray-text">'.$data['date'].'</div>
                        <div class="font-weight-bold text-size-20 gray-text">Nomor Order #'.$data['orderNumber'].'</div>                    
                    </div>
                </div>
            </div>
        ';

        return $resultHTML;
    }


}