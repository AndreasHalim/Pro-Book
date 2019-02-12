<?php
    function showOrderModal($result) {
        echo '
            <!-- The Modal-->
            <div id="notification-modal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick="closeModal(\'notification-modal\')">&times;</span>'.
                    showResult($result).
                '</div>
            </div>';
    }

    function showResult($response) {
        if ($response->status == 200) {
            if ($response->values->success) {
                $mesg = "Pembelian Berhasil!";
                $detail = "Nomor Transaksi: ". $response->values->result;
                $mark = 'tick';
            } else {
                $mesg = "Pembelian gagal!";
                $detail = $response->values->result;
                $mark = 'cross';
            }
        } else {
            $mesg = "Pembelian gagal!";
            $detail = $response->values->result;
            $mark = 'cross';
        }
        
        return '
            <div class="modal-message">
                <div><img id="mark-icon" src="../svgIcon/black-'.$mark.'.png"></div>
                <div>
                    <div id="check-description"><b>'.$mesg.'</b></div>
                    <div>'.$detail.'</div>
                </div>
            </div>';
    }
?>