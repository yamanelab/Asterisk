<?php

require_once '../twitter.php';

$twitter = new Twitter();
$twitter->logout();

echo 'ログアウトしました！';