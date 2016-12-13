<?php

require_once('login_config.php');

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
		if(!$this->compareHash($id, HASHED_ID))
			return false;

		if(!$this->compareHash($pass, HASHED_PASS))
			return false;

		$_SESSION["logged"] = "logined";

		return true;
	}

	public function logout() {
		$_SESSION = array();
		session_destroy();
		session_start();
	}


	public function getHash($raw) {
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