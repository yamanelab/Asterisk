<?php

class LoginManager {
	function __construct() {
		session_start();
	}

	public function isLogined() {
		if(!isset($_SESSION["logged"]))
			return false;
		else
			return true;
	}

	public function login($id, $pass) {
		$hashed_id = "$2rcByx51ejoM"; // "test"
		$hashed_pass = "$2/xGWy6xTUIA"; // "pass"

		if(!$this->compareHash($id, $hashed_id))
			return false;

		if(!$this->compareHash($pass, $hashed_pass))
			return false;

		$_SESSION["logged"] = "logined";

		return true;
	}

	public function logout() {
		$_SESSION = array();
		session_destroy();
		session_start();
	}


	// ハッシュに関するプライベートメソッド群
	function getHash($raw) {
	    $chars = array_merge(range('a', 'z'), range('A', 'Z'), array('.', '/'));

	    // ソルト作成
	    $salt = '';
	    for ($i = 0; $i < 22; $i++) {
	        $salt .= $chars[mt_rand(0, count($chars) - 1)];
	    }

	    return crypt($raw, '$2y$' . '4' . '$' . $salt);
	}

	function compareHash($raw, $hash) {
		if(crypt($raw, $hash) == $hash)
			return true;
		else
			return false;
	}
}