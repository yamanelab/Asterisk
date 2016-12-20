<?php

/**
 *  NFCによる状態更新
 *	•HTTP: GET
 *	•URL: /api/update/nfc
 *	
 *	@param  String	id		[ID]
 *	@return [成功：HTTPステータス202, 失敗：HTTPステータス406]
 */

date_default_timezone_set('Asia/Tokyo');

const JSON_PATH = "../../data/member_data.json";
$json = json_decode(file_get_contents(JSON_PATH));

$result = false;

// idが入っているか
if(isset($_GET["id"])) {
	$id = $_GET["id"];

	// 存在するidか
	if(isset($json->member->$id)) {
		switch($json->member->$id->status) {
			case "campus":
				$json->member->$id->status = "lab";
				break;
			case "home":
				$json->member->$id->status = "lab";
				break;
			case "lab":
				$json->member->$id->status = "home";
				break;
		}
		$json->member->$id->modified_date = date("Y/m/d H:i:s");
		$result = true;
	}
}

file_put_contents(JSON_PATH, json_encode($json)); 

if( $result ) {
	header( "HTTP/1.1 202 Accepted" ); 

	/* php5.4以上の場合、以下で代用可
	 http_response_code( 202 );
	*/

	echo "202 Accepted";

}else{
	header( "HTTP/1.1 406 Not Acceptable" );

	// http_response_code( 406 );

	echo "406 Not Acceptable";
} 

?>