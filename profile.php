<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Team Info</title>
	<meta name="author" content="Tyler" />
	
</head>
<body>
	<script src="sha256.js"></script>
	<script type="text/javascript">
		var letters = /^[0-9a-zA-Z\s]+$/; 
		
		function checkName(){
			if(document.info.NewName.value.match(letters)){
				
			}
		}
	</script>
	<form value='post' action='add_team.php'>
		<input name="NewName" />
	</form>
	<?php
		require_once("connection.php");
		$con = connectToDB();
		$results = mysqli_query($con,"SELECT * FROM Users WHERE Username='" . $_COOKIE['User'] . "'");
		$row = mysqli_fetch_array($results);
		$Names =  preg_split("/[|]/", $row['Game_Name']);
		if(count($Names)<10){
			foreach($Names as $Print){
				echo $Print;
			}
		}
		
	?>
</body>
</html>

