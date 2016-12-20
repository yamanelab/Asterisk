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


	public function getHash($raw, $salt = "") {
	    $chars = array_merge(range('a', 'z'), range('A', 'Z'), array('.', '/'));

	    // ソルト作成
	    if($salt === "") {
	    	for ($i = 0; $i < 22; $i++) {
		        $salt .= $chars[mt_rand(0, count($chars) - 1)];
		    }
	    }

	    return crypt($raw, '$2y$' . '4' . '$' . $salt);
	}

	function compareHash($raw, $hash) {
		if(crypt($raw, $hash) == $hash)
			return true;
		else
			return false;
	}

	// 以下、トークン用メソッド

	/*
	 * IDとパスワードのトークン取得
	 * 
	 * @param string $id : ユーザーID
	 * @param string $pass : ユーザーPASS
	 * @return string ログイン成功ならトークン、ログイン失敗なら""を返す
	 *
	 */
	public function getToken($id, $pass) {
		if($this->login($id, $pass))
			return $this->getHash($id, HASHED_ID) . "|" . $this->getHash($pass, HASHED_PASS);
		else
			return "";
	}

	/*
	 * トークンによるログイン処理
	 * 
	 * @param string $token : トークン文字列
	 * @return bool 正しいトークンならtrue, そうでなければfalseを返す
	 *
	 */
	public function loginByToken($token) {
		$token_array = split("|", $token);

		if(HASHED_ID === $token_array[0] && HASHED_PASS === $token_array[1]) {
			$_SESSION["logged"] = "logined";
			return true;
		} else {
			return false;
		}
	}
}