<?php

date_default_timezone_set('Asia/Tokyo');

const MEMBER_JSON_PATH = "./member_data.json";
const SLACK_JSON_PATH  = "./slack_bot/slack.json";

$id = $_POST["id"];

$member_json = json_decode(file_get_contents(MEMBER_JSON_PATH));
$slack_json  = json_decode(file_get_contents(SLACK_JSON_PATH));

$member = $member_json->member->$id;

// メンバー画像がクリックされた場合
if( isset($_POST['submit_x']) & isset($_POST['submit_y']) ) {
	if( check_status($member, "home") ) {
		change_status($member, $slack_json, "lab");
	} else {
		change_status($member, $slack_json, "home");
	}
}
// メンバーの一言メモがクリックされた場合
else if ( check_status($member, "campus") ) {
	change_status($member, $slack_json, "lab");
} else {
	change_status($member, $slack_json, "campus");
}

$member->modified_date = date("Y/m/d H:i:s");

file_put_contents(MEMBER_JSON_PATH, json_encode($member_json)); 

$uri = $_SERVER['HTTP_REFERER'];
header("Location: ".$uri, true, 303);

/**
 * $idのメンバーのステータスが$statusと同じかチェック 
 */
function check_status($member, $status) 
{
	return $member->status == $status;
}

/**
 * $idのメンバーのステータスを$statusに変更
 */
function change_status($member, $slack_json, $status) 
{
	$member->status = $status;

	// 最終更新日と違う日付であれば、countを1増やす
	$modified_day = date("Ymd", strtotime($member->modified_date));
	if( $modified_day != date("Ymd") ){
		$member->count += 1;
	}

	// slackに通知。enableがfalseなら何もしない。
	post2slack($member, $slack_json);
}

/**
 * slack_botの設定していれば、botによる通知を行う
 */
function post2slack($member, $slack_json) 
{
	if( $slack_json->slack_bot->enable ) 
	{
		$name 	= $member->name;
		$status = $member->status;

		$cmd = "php ./slack_bot/post2slack.php ".$name." ".$status;
		exec($cmd);
	}
}

?>



