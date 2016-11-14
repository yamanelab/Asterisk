<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link rel="stylesheet" href="index.css" />		
	</head>
	<body>
		<div id="header">
			<span><f1>CSL Members</f1></span>
		</div>

	    <table id="member" class="member-table">
    	<?php
    		include "member_box.php";
    		getAllMembersTable($members, 4);
    	?>      					
		</table>
		
		<br><br>		
		<div id="footer">
			<form method="post" action="member_manager.php">
				<input type="submit" value="メンバー管理画面"> 
			</form>
		</div>
		
	</body>
</html>
