<?php

require_once '../twitter.php';

$twitter = new Twitter();

if($twitter->isLogined()) {
	$user = $twitter->getUserdata();
	echo "ようこそ！$user->name";
} else {
	echo "ログインしてください";
}