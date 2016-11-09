<html>
<head><title>model.phpテスト</title></head>
<body>

<?php

include "model.php";

// モデルを取得して全メンバー情報抜き出し
$model = new Model();
$ids = $model->getMemberList();
foreach($ids as $id) {
    $m = $model->getMemberDetail($id);
    echo $m;
    echo "<br>";
}

echo "<hr>";

// 新要素追加
$m = new Member("hmy", "やまは", "画像", "個目", "しゅっせき", "今日");
$m->comment = "コメント変更した";
$model->addMember($m->id, $m);

$model = new Model();
$ids = $model->getMemberList();
foreach($ids as $id) {
    $m = $model->getMemberDetail($id);
    echo $m;
    echo "<br>";
}

echo "<hr>";

// メンバー削除
$model->removeMember($m->id);

$model = new Model();
$ids = $model->getMemberList();
foreach($ids as $id) {
    $m = $model->getMemberDetail($id);
    echo $m;
    echo "<br>";
}

?>

</body>
</html>

