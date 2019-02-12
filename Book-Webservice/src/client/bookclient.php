<?php
    $client = new SoapClient("http://localhost:9000/bookservice?wsdl");

    //Percobaan insert Purchase: berhasil
    $params = array(
        "id_buku" => "uFWDBAAAQBAJ",
        "jml" => 3,
        "no_kartu" => "1Q2W3"
    );
    //$response = $client->__soapCall("insertPurchase", $params);
    //echo $response;

    //Percobaan search buku
    $param = array(
        "input" => "The Solo Beatles"
    );
    //$respond = $client->__soapCall("searchBooks", $param);
    //var_dump($respond->jumlahBuku);

    //Percobaan rekomendasi: berhasil!
    $param = array(
            "kategori" => array("Comedy")
       );
    $respond = $client->__soapCall("getRekomendasi", $param);
    var_dump($respond);
    //$arr = $respond->buku;
    //var_dump(array_slice($arr, 0, 3));

    //Cari buku
    $param = array(
        "book_id" => "22",
        "author" => "Erma"
    );
    //$respond = $client->__soapCall("getBookByID", $param);
    //var_dump($respond->buku[0]->rating);
?>