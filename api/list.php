<?php

/**
 *  一覧取得
 *	•HTTP: GET
 *	•URL: /api/list
 *	
 *	@param [null]
 *
 *	@return jsonデータ
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
 *      }
 *    			:  
 *	  }
 *  }
 */

const JSON_PATH = "../member_data.json";

$json = json_decode(file_get_contents(JSON_PATH));

echo json_encode($json);

?>