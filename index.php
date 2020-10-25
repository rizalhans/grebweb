<?php

//// start
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://officiumnobile.com/grebweb/src/hukumonline.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

//// start
$curl = curl_init();

echo $response;
?>