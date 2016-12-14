<?php

require_once('../model.php');
require_once('./login_manager.php');


$manager = new LoginManager();
if(!$manager->isLogined()) {
	$url = './login.php';
	header("Location: $url");
}


// POST処理が来たときは更新処理
if(isset($_POST['id'])) {
	
	$model = new Model();

	if(isset($_POST['add'])) {
		$m = new Member();

		$m->id = $_POST['id'];
		$m->name = $_POST['name'];
		$m->image = $_POST['image'];
		$m->comment = $_POST['comment'];
		$m->status = $_POST['status'];
		$m->modified_date = date('Y/m/d H:i:s');
		$m->class = 'normal';
		$m->count = 0;

		$model->addMember($m->id, $m);
	} elseif (isset($_POST['del'])) {
		$model->removeMember($_POST['id']);
	}
}
?>

<html>
<head><title>メンバー管理</title></head>
<body>

<table border="1">
	<tr>
		<td>ID</td>
		<td>名前</td>
		<td>画像URL</td>
		<td>コメント</td>
		<td>状態</td>
		<td>変更日</td>
		<td>クラス</td>
		<td>今月出勤数</td>
		<td>消す</td>
	</tr>

	<?php
	$model = new Model();
	$ids = $model->getMemberList();
	foreach($ids as $id) {
		$m = $model->getMemberDetail($id);
echo <<< EOT
		<tr> <form action="manager.php", method="post">
		<td>$m->id</td>
		<td><input type="text" name="name" value="$m->name"></td>
		<td><input type="text" name="image" value="$m->image"></td>
		<td><input type="text" name="comment" value="$m->comment"></td>
		<td><select name="status">
EOT;
		$labels = array();
		$labels[] = "home";
		$labels[] = "campus";
		$labels[] = "lab";
		foreach($labels as $label) {
			if($label === $m->status) {
				echo '<option selected="selected">';
				echo $label;
				echo "</option>";
			} else {
				echo "<option>$label</option>";
			}
		}

echo <<< EOT
		</select></td>
		<td>$m->modified_date</td>
		<td>$m->class</td>
		<td>$m->count</td>
		<td>
			<input type="submit" value="変更" name="add">
			<input type="submit" value="消す" name="del">
			
		</td>
		</form> </tr>
EOT;
	}
	?>
</table>
<br>
<form action="manager.php", method="post">
	<input type="hidden" name="type" value="add">
	ID : <input type="text" name="id"><br>
	名前 : <input type="text" name="name"><br>
	画像URL : <input type="text" name="image"><br>
	コメント : <input type="text" name="comment"><br>
	状態 : 
	<select name="status">
		<option>home</option>
		<option>campus</option>
	    <option>lab</option>
	</select><br>
	<input type="submit" value="追加" name="add">
</form>

<a href="logout.php">ログアウトする</a><br>
<a href="../index.php">トップへ戻る</a>

</body>
</html>