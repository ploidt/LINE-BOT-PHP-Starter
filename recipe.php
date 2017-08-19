<?php
$url =  "https://api.edamam.com/search?app_id=9d511b82&app_key=dfcce54f444d706e750cffb9e523c9d1&from=0&to=3&q=";
$test = 'chicken';

$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_URL, $url.$test);
$result1 = curl_exec($ch1);
curl_close($ch1);

$obj = json_decode($result1, true);

foreach($obj['hits'] as $key => $val){

    $result_text = $val['recipe']['label'];
    
}

echo json_encode($result_text);