<?php
    $client = new SoapClient("http://localhost:9000/bookservice?wsdl");
    $param = array(
        "input" => $_GET["search_text"]
    );
    $respond = $client->__soapCall("searchBooks", $param);
    echo json_encode($respond);
?>