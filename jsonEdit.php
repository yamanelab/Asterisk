<?php
date_default_timezone_set('Asia/Tokyo');

const JSON_PATH = "member_data.json";

$id = $_POST["id"];

$json = json_decode(file_get_contents(JSON_PATH));

if( isset($_POST['submit_x']) & isset($_POST['submit_y']) ) {
	if( $json->member->$id->status == "campus" ) {
		$json->member->$id->status = "lab";
	} else {
		$json->member->$id->status = "campus";
	}
} else if ( $json->member->$id->status == "home" ) {
	$json->member->$id->status = "lab";
} else {
	$json->member->$id->status = "home";
}

$json->member->$id->modified_date = date("Y/m/d H:i:s");

file_put_contents(JSON_PATH, json_encode($json)); 

$uri = $_SERVER['HTTP_REFERER'];
header("Location: ".$uri, true, 303);

?>



