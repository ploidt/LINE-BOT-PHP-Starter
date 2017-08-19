<?php

define("LINE_MESSAGING_API_CHANNEL_SECRET", 'dc4aa780d6557e4dc579fc51661eccbd');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'OS3ckApBsExdHU+lPbwqpN9joiqCF6Xkir7G8+3Odh3yoPU+b3eoZDmu0Yon7wd3xvEg8yA1Q+bBQruqlGC/iy+eUXV+ViUQ76dytwE7pLh8cOvvWj0Et+8bXNSDae/QcyFkeu6tqj6xdQFrtFndSAdB04t89/1O/w1cDnyilFU=');

require __DIR__."/vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";