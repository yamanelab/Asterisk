<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link rel="stylesheet" href="index.css" />
	    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	    <script type="text/javascript">
			$(function(){
  				$('#get_json').click(function(){
    				var url = 'member_data.json';
    				$.getJSON(url, function(data){
      					for(var key in data){
        					$('#result').append($('<p>').html(key +': '+ JSON.stringify(data[key])));
      					}
    				});
  				});
			});
		</script>			
	    <?php
	    	include "index.php";
	    ?>
	</head>
	<body>
		<div id="header">
			<span><f1>CSL Members</f1></span>
		</div>
 		
        <div class="member-holder member-holder-top member-holder-left">
        	<div class="member-view member-choice-state-home-color">
				<div class="member-state">
					<span><?php getNameAndStatus($members[1]); ?></span>
				</div>
				<div class="member-field">
						<img width="80px" height="40px" border="0px" src=<?php getImage($members[1]); ?> />
					<div class="member-info">
						<span><?php getMemo($members[1]); ?></span>
					</div>
				</div>
				
				<br>
				<form method="post" action="jsonEdit.php">
					<input type="hidden" name="id" value="khattori">
					<input type="submit" value="change">
				</form>
				
				<br>
				<button id="get_json">JSON読み込み</button>
				<div id="result"></div>
			</div>
		</div>
		
		
	</body>
</html>
