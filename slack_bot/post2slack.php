<?php

include_once __DIR__.'/SlackBot.php';
include_once __DIR__.'/SlackBotInfo.php';

if ($argc < 4) {
    exit('argument error');
}
$name   = $argv[1];
$status = $argv[2];
$count  = $argv[3];

switch ($status) {
	case 'home':
		$message = $name."は帰宅しました";
		break;

	case 'lab':
		$message = $name."が入室しました";
		if( $count == 20 ) {
			$message = $message."\r\nおめでとうございます! ".$name."は来月Goldクラスです!";
		} elseif( $count == 10 ) {
			$message = $message."\r\nおめでとうございます! ".$name."は来月Silverクラスです!";
		}
		break;

	case 'campus':
		$message = $name."が席を外しましたが、大学内にいるそうです";
		break;
}


// メッセージをポスト
$bot = new SlackBot();
print_r($bot->post_message(new SlackBotInfo($message)));

?>