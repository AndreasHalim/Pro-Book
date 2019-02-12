<?php
  $URL = 'http://localhost:3000/nasabah';
  $data = array(
    'no_kartu' => $_POST['no_kartu']
  );
  $options = array(
    'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded\r\n",
      'method' => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($URL, false, $context);
  if ($result) {
    $Hasil = json_decode($result)->values->not_found;
    echo $Hasil;
  } else {
    echo "false";
  }
?>