<?php

// 参考
// http://qiita.com/sofpyon/items/982fe3a9ccebd8702867

define( 'CONSUMER_KEY', 'YSEycMlFQj48uHmhOS5NIkbYp' );
define( 'CONSUMER_SECRET', '8TlOF29YmzE5GGGqnmDvuW1qSGHnEMtcOI96gVEMkmC648LOYw' );
define( 'OAUTH_CALLBACK', 'http://localhost/Asterisk/twitter_callback.php' );

require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
	function __construct() {
        session_start();
    }

    public function isLogined()
    {
        return isset($_SESSION['access_token']);
    }

    public function login($redirect_url) {
    	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		$_SESSION['redirect_url'] = $redirect_url;
		$url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));
		header( 'location: '. $url );
    }

    public function logout() {
    	$_SESSION = array();
		if (isset($_COOKIE["PHPSESSID"])) {
		    setcookie("PHPSESSID", '', time() - 1800, '/');
		}
		session_destroy();
		session_start();
    }

    public function getUserdata() {
    	if(!$this->isLogined())
    		return null;

    	$access_token = $_SESSION['access_token'];
    	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		return $connection->get("account/verify_credentials");
    }
}
