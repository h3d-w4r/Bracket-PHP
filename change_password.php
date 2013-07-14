<?php
	require_once('connection.php');
	$con = connectToDB();
	
	$results = mysqli_query($con,"SELECT * FROM Users;");
	$bool = false;
	
	while(($row = mysqli_fetch_array($results))&&$bool!=true){
		if($row['Activation']==$_POST['q']){
			$bool = true;
			$user = $row['Username'];
		}
	}
	if($bool==true){
		echo 'Your password has been changed, login <a href="http://devitdixon.com/Bracket/loginpage.php">here</a>. ';
		$stmt = $con->prepare("UPDATE Users SET Password = ? WHERE Activation = ?");
		$stmt->bind_param('ss', $_POST['password'], $_POST['q']);
		$stmt->execute();
		$stmt->close();
		$stmt = $con->prepare("UPDATE Users SET Activation = 'ff' WHERE Username = ?");
		$stmt->bind_param('s', $user);
		$stmt->execute();
		$stmt->close();
	}
	else
		echo 'Password didn\'t change.';
?>