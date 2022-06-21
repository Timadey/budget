<?php
header('Content-Type: application/json');

        $join = array('`category`' => '`category_id`');
        $where = array ('`user_id`' => ':user_id');
        $value = array (':user_id' => 120);
        $data = array();
        $data = array_merge($join, $where, $value);
        

//var_dump($data)."<br>";
$json = json_encode($data, JSON_PRETTY_PRINT);
//echo $json;
// $res = curl_init();
// $url = "/curl-receive.php";
// $curl_opt = array (
//         CURLOPT_URL => $url,
//         CURLOPT_RETURNTRANSFER => TRUE,
//         CURLOPT_HTTPHEADER => array("content-type: application/json"),
//         CURLOPT_POST => TRUE,
//         CURLOPT_POSTFIELDS => $json
// );
// curl_setopt_array($res, $curl_opt);
// curl_exec($res);
curl_close($res);
echo $json;
?>