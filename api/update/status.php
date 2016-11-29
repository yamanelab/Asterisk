<?php

/**
 *  状態更新
 *	•HTTP: GET
 *	•URL: /api/update/status
 *	
 *	@param  String	token	[トークン]
 *	@param  String	status	[状態]
 *	@return [成功：HTTPステータス202, 失敗：HTTPステータス406]
 */

date_default_timezone_set('Asia/Tokyo');

const JSON_PATH = "../../member_data.json";
$json = json_decode(file_get_contents(JSON_PATH));

$token	 = $_GET["token"];
$comment = $_GET["status"];
$result  = false;

// TODO : tokenからメンバーIDを発行し、$idに格納

if( isset($id) ) {
	$json->member->$id->status = $status;
	$json->member->$id->modified_date = date("Y/m/d H:i:s");
	$result = true;
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