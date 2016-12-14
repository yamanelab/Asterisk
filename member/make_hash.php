<?php

require_once('./login_manager.php');
$manager = new LoginManager();

$result = "";

if(isset($_POST['id'])) {

	$id = $_POST['id'];
	$pass = $_POST['pass'];

	$id_h = $manager->getHash($id);
	$pass_h = $manager->getHash($pass);

	$result = "ID : " . $id_h . "<br>PASS : " . $pass_h;


}

?>

<html>
<head>
<title>ハッシュ作成サイト</title>
</head>
<body>

<?php echo "$result"; ?>

<form action="make_hash.php", method="post">
	  ID <input type="text" name="id"><br>
	PASS <input type="password" name="pass"><br>
	<input type="submit" value="ハッシュ作成！">
</form>

</body>
</html>