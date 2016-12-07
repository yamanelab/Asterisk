<?php

include_once __DIR__.'/SlackBot.php';
include_once __DIR__.'/SlackBotInfo.php';

if ($argc < 3) {
    exit('引数にポストしたいメッセージを指定してください');
}
$name   = $argv[1];
$status = $argv[2];

$message = $name."の状態が".$status."に変更されました";

// メッセージをポスト
$bot = new SlackBot();
print_r($bot->post_message(new SlackBotInfo($message)));

?>