<?php

$access_token = 'OS3ckApBsExdHU+lPbwqpN9joiqCF6Xkir7G8+3Odh3yoPU+b3eoZDmu0Yon7wd3xvEg8yA1Q+bBQruqlGC/iy+eUXV+ViUQ76dytwE7pLh8cOvvWj0Et+8bXNSDae/QcyFkeu6tqj6xdQFrtFndSAdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'dc4aa780d6557e4dc579fc51661eccbd';

include ('php/line-bot.php');

$bot = new BOT_API($channelSecret, $access_token);
    
if (!empty($bot->isEvents)) {
        
    $bot->replyMessageNew($bot->replyToken, json_encode($bot->message));

    if ($bot->isSuccess()) {
        echo 'Succeeded!';
        exit();
    }

    // Failed
    echo $bot->response->getHTTPStatus . ' ' . $bot->response->getRawBody(); 
    exit();

}

// // Get POST body content
// $content = file_get_contents('php://input');
// // Parse JSON
// $events = json_decode($content, true);
// // Validate parsed JSON data
// if (!is_null($events['events'])) {
//     // Loop through each event
//     foreach ($events['events'] as $event) {
//         // Reply only when message sent is in 'text' format
//         if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
//             // Get text sent
//             $text = $event['message']['text'];
//             // Get replyToken
//             $replyToken = $event['replyToken'];

//             // Build message to reply back
//             $messages = [
//                 'type' => 'text',
//                 'text' => $text
//             ];

//             // Make a POST Request to Messaging API to reply to sender
//             $url = 'https://api.line.me/v2/bot/message/reply';
//             $data = [
//                 'replyToken' => $replyToken,
//                 'messages' => [$messages],
//             ];
//             $post = json_encode($data);
//             $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

//             $ch = curl_init($url);
//             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//             curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//             $result = curl_exec($ch);
//             curl_close($ch);

//             echo $result . "\r\n";
//         }
//     }
// }
// echo "OK";