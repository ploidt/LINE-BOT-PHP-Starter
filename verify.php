<?php
$access_token = 'OS3ckApBsExdHU+lPbwqpN9joiqCF6Xkir7G8+3Odh3yoPU+b3eoZDmu0Yon7wd3xvEg8yA1Q+bBQruqlGC/iy+eUXV+ViUQ76dytwE7pLh8cOvvWj0Et+8bXNSDae/QcyFkeu6tqj6xdQFrtFndSAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;