<?php
$res = curl_init();
$url = "http://localhost/first_project/Income-and-Expenditure/modules/curl-send.php";

// $curl_opt = array (
//         CURLOPT_URL => $url,
//         CURLOPT_RETURNTRANSFER => TRUE
// );
// curl_setopt_array($res, $curl_opt);
// $result = curl_exec($res);
// $resul = json_decode($result, JSON_PRETTY_PRINT);
// $code = curl_getinfo($res, CURLINFO_HTTP_CODE);
// echo $code;
// var_dump($resul);

$arr  = array (
        'new user' => "timothy",
        'age' => 16
);
$json = json_encode($arr);

$curl_opt = array (
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array("content-type: application/json"),
        CURLOPT_POST => TRUE,
        CURLOPT_POSTFIELDS => $json
);
curl_setopt_array($res, $curl_opt);
$result = curl_exec($res);
curl_close($res);
echo $result;
curl_close($res);
?>