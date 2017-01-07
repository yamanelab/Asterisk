<?php

/**
 *  メンバー一覧取得
 *	•HTTP: GET
 *	•URL: /api/list
 *	
 *	@param 
 *	null 	: メンバー一覧
 *	id 		: 指定されたidに一致するメンバー
 *	status  : 指定されたstatusに一致するメンバー一覧
 *	class 	: 指定されたclassに一致するメンバー一覧
 *
 *	@return
 *	{
 *    "member":
 *    {
 *    	"member_id":
 *    	{
 *        "id":      	 	String: メンバーID ,
 *        "name": 		 	String: 名前 ,
 *        "image":       	String: 画像URL ,
 *        "comment":        String: 一言コメント ,
 *        "status":			String: 状態 ,
 *        "modified_date":	String: 最終更新日 ,
 *        "class":			String: クラス　,
 *        "count":			String: 出勤回数
 *      }
 *    			:  
 *	  }
 *  }
 */

const JSON_PATH = "../data/member_data.json";

$json = json_decode(file_get_contents(JSON_PATH));

$members = $json->member;

if( !empty($_GET) ) {
	$flag = sizeof($_GET);

	if( isset($_GET['id']) ) {
		$members = getArray($json, $members, 'id');
		$flag -= 1;
	}

	if( isset($_GET['status']) ) {
		$members = getArray($json, $members, 'status');
		$flag -= 1;
	}

	if( isset($_GET['class']) ) {
		$members = getArray($json, $members, 'class');
		$flag -= 1;
	}

	if( $flag > 0 ) {
		header( "HTTP/1.1 400 Bad Request" );
		exit("<p>400 Bad Request (Parameter is invalid)<p>");
	}
}

header('Content-type: application/json');
echo json_encode($members, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


/*-----------------------------------------------------------------------*/
 
function getArray($json, $members, $param) {
	$member_list = array();

	foreach ($members as $m) {
		if( $m->$param == $_GET[$param] ) {
			$member_list[] = $m;
		}
	}

	return $member_list;
}

?>