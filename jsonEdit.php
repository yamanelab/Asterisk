<?php

const JSON_PATH = "member_data.json";

//指定したidのstatusのみ変更できるようにしたい
$id = $_POST["id"];

$json = json_decode(file_get_contents(JSON_PATH));

if( $json->member->status == "home") {
	$json->member->status = "lab";
} else {
	$json->member->status = "home";
}

file_put_contents(JSON_PATH, json_encode($json)); 

$uri = $_SERVER['HTTP_REFERER'];
header("Location: ".$uri, true, 303);

?>



