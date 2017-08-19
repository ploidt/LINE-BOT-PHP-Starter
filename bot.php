<?php
require __DIR__."/vendor/autoload.php";

$access_token = 'OS3ckApBsExdHU+lPbwqpN9joiqCF6Xkir7G8+3Odh3yoPU+b3eoZDmu0Yon7wd3xvEg8yA1Q+bBQruqlGC/iy+eUXV+ViUQ76dytwE7pLh8cOvvWj0Et+8bXNSDae/QcyFkeu6tqj6xdQFrtFndSAdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'dc4aa780d6557e4dc579fc51661eccbd';
$app_id = '9d511b82';
$app_key = 'dfcce54f444d706e750cffb9e523c9d1';

$url =  "https://api.edamam.com/search?app_id=9d511b82&app_key=dfcce54f444d706e750cffb9e523c9d1&from=0&to=5&q=";

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
$multipleMessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

// Get POST body content
$content = file_get_contents('php://input');

$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];
            // Get replyToken
            $replyToken = $event['replyToken'];

            $text_ex = explode(':', $text); //เอาข้อความมาแยก : ได้เป็น Array

            if($text_ex[0] === "menu" || $text_ex[0] === "Menu"){
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch1, CURLOPT_URL, $url.$text_ex[1]);
                $result1 = curl_exec($ch1);
                curl_close($ch1);
                
                $obj = json_decode($result1, true);
                
                $columns = array();
                foreach($obj['hits'] as $key => $val){

                    $result_text = $val['recipe']['label'];
                    $title = $val['recipe']['label'];
                    $total_calories = $val['recipe']['calories'];
                    $yield = $val['recipe']['yield'];
                    $calories = floor($calories / $yield)
                    $descritpiton = "Calories: ".$calories;
                    $img_url = $val['recipe']['image'];

                    $actions = array (
                        new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("View More", $val['recipe']['url'])
                    );
                    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder( $title, $descritpiton, $img_url, $actions);
                    $columns[] = $column;

                    // $multipleMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text));

                }
                    $carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
                    $outputText = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("Carousel Menu", $carousel);

                    $response = $bot->replyMessage($replyToken, $outputText);

                $templateMessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder($title, $text, $thumbnailImageUrl, $actions);
                $response = $bot->replyMessage($replyToken, $templateMessageBuilder);


                if(empty($result_text)){//ไม่พบข้อมูล ตอบกลับไป
                    $result_text = 'No data';
                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
                }

            }else{
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $response = $bot->replyMessage($replyToken, $textMessageBuilder);
            }

        }
    }
}
echo "OK";