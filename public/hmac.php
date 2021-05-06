<?php
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
$mt = microtime(true);
list($usec, $sec) = explode(' ', $mt);
$now = date('Y-m-d H:i:s');

$SignatureTime = intval($mt * 1000);

$m = 'POST\n'.md5('{"email":"andilevi@gmail.com"}').'\napplication/json\n'.$now.'\n/v1/test-new-employee';
// echo $m;die;
$sec = '879sdg78dsfg56sd4g7987eswg76';
$s = hash_hmac('sha256', 'POST\nklajflknfklanfklanlkfnlasflal\napplication/json\n2021-01-01 00:01:01\n/v1/test-new-employee', $sec, true);
$sig =  base64_encode($s);

$d = new DateTime();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://integrasi.delapancommerce.com/v1/test-new-employee',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "email":"andilevi@gmail.com"
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    'API-KEY: ojh545we4t5254sdgfsaefstg65478',
    'Signature: '.$sig,
    'Signature-Time: '.$SignatureTime,
    'Authorization: Basic bGluYy10ZXN0OjEyMzQ1Ng=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

