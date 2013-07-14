<?php
    require_once('connection.php');
	$con = connectToDB();
	
	$results = mysqli_query($con,"SELECT * FROM Users WHERE Email= '" . $_POST['email'] . "';");
	$bool = false;
	$activ = 0;
	while(($row = mysqli_fetch_array($results))&&$bool!=true&&$activ==0){
		if($row['Activated']==1){
			$bool = true;
		}
		
	}
	if($bool==true){
		$activation = rand(0,1000) . $_POST['email'];
		$activation = hash(sha256, $activation);
		echo 'sent';
		$stmt = $con->prepare("UPDATE Users SET Activation = ? WHERE Email = ?");
		$stmt->bind_param('ss', $activation, $_POST['email']);
		$stmt->execute();
		$stmt->close();
		mail($_POST['email'], "Password Recovery", "Email for recovery:\n http://devitdixon.com/Bracket/recover.php?q=" . $activation, "From: Bracket");
	}
	else {
		echo'noact';
	}
	
?>