<?php

include_once __DIR__.'/SlackBot.php';
include_once __DIR__.'/SlackBotInfo.php';

// 引数チェック
if ($argc < 2) {
    exit('引数にポストしたいメッセージを指定してください');
}
$message = $argv[1];

// メッセージをポスト
$bot = new SlackBot();
print_r($bot->post_message(new SlackBotInfo($message)));

?>