<?php

/**
 *  状態一覧取得
 *	•HTTP: GET
 *	•URL: /api/status_code
 *	
 *	@param  [null]
 *	@return {"status_code":"status_name", ... }
 */

$status = array(
	"home" => "home",
	"lab" => "lab",
	"campus" => "campus"
	);

header('Content-type: application/json');
echo json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>