<?php

require_once('./login_manager.php');
$manager = new LoginManager();

$msg = "";

// POST処理が来たときはログイン処理
if(isset($_POST['id'])) {

	$id = $_POST['id'];
	$pass = $_POST['pass'];

	$result = $manager->login($id, $pass);
	if(!$result) {
		$msg = "ログインに失敗しました";
	}
}

if($manager->isLogined()) {
	$url = './manager.php';
	header("Location: $url");
}

?>

<html>
<head>
<title>ログイン処理</title>
<style>
.login-box {
    border: 2px solid #da4033;
    border-radius: 4px;
    padding: 2em;
    position: relative;
    width: 300px;
    margin: 10em auto;
    text-align: center;
}
.login-box::before {
    background-color: #fff;
    color: #da4033;
    content: "LOGIN";
    font-weight: bold;
    left: 1em;
    padding: 0 .5em;
    position: absolute;
    top: -1em;
}
</style>
</head>
<body>


<div class="login-box">
<?php echo $msg . '<br>'; ?>
<form action="login.php", method="post">
	  ID <input type="text" name="id"><br>
	PASS <input type="password" name="pass"><br>
	<input type="submit" value="ログイン">
</form>
<a href="../index.php">トップへ戻る</a>
</div>



</body>
</html>