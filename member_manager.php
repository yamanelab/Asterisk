<?php
include "model.php";

// POST処理が来たときは更新処理
if(isset($_POST['id'])) {
	
	$model = new Model();

	if($_POST['type'] === "add") {
		$m = new Member();

		$m->id = $_POST['id'];
		$m->name = $_POST['name'];
		$m->image = $_POST['image'];
		$m->comment = $_POST['comment'];
		$m->status = $_POST['status'];
		$m->modified_date = $_POST['modified_date'];

		$model->addMember($m->id, $m);
	} elseif ($_POST['type'] === "delete") {
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
		<td>消す</td>
	</tr>

	<?php
	$model = new Model();
	$ids = $model->getMemberList();
	foreach($ids as $id) {
		$m = $model->getMemberDetail($id);
echo <<< EOT
		<tr>
		<td>$m->id</td>
		<td>$m->name</td>
		<td>$m->image</td>
		<td>$m->comment</td>
		<td>$m->status</td>
		<td>$m->modified_date</td>
		<td>
			<form action="member_manager.php", method="post">
				<input type="hidden" name="id" value="$m->id">
				<input type="hidden" name="type" value="delete">
				<input type="submit" value="消す">
			</form>
		</td>
		</tr>
EOT;
	}
	?>
</table>
<br>
<form action="member_manager.php", method="post">
<input type="hidden" name="type" value="add">
ID : <input type="text" name="id"><br>
名前 : <input type="text" name="name"><br>
画像URL : <input type="text" name="image"><br>
コメント : <input type="text" name="comment"><br>
状態 : <input type="text" name="status"><br>
変更日 : <input type="text" name="modified_date"><br>
<input type="submit" value="更新・追加">
</form>

</body>
</html>