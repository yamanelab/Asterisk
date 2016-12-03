<?php

require_once('./login.php');
$manager = new LoginManager();
$manager->logout();

?>

<html>
<head><title>ログアウト</title></head>
<body>
ログアウトしました<br>

<a href="index.php">トップへ戻る</a>

</body>
</html>