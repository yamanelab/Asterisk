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
	</head>
	<body>
		<div id="header">
			<span><f1>CSL Members</f1></span>
		</div>

	    <table id="member" class="member-table">
    	<?php
    		include "index.php";
    		getAllMembersTable($members, 4);
    	?>      					
		</table>
		
		<br><br>
		<div id="footer">
			<span><button id="get_json">JSON読み込み</button></span>
			<div id="result"></div>
		</div>
		
	</body>
</html>
