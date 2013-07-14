<?php
	require_once('connection.php');
	$con = connectToDB();
	$results = mysqli_query($con,"SELECT * FROM Users");
	$bool = false;
	$activ = 0;
	while(($row = mysqli_fetch_array($results))&&$bool!=true){
		if($row['Username']==$_POST['Username']){
			$bool = true;
		}
	}
	
	if($bool==true){
		echo "This username is unavailable, either that, or you accidentally resubmitted the registration form.";
	}
	else{
		$activation = "Bracket" . $_POST['Username'];
		$activation = hash(sha256, $activation);
		$stmt = $con->prepare("INSERT INTO Users (Username, Password, Email, Creation_Date, Activated, Activation, Question, Answer) Values (?, ?, ?, now(), 0, ?, ?, ? )");
		$stmt->bind_param('ssssss', $_POST['Username'], $_POST['password'], $_POST['email'], $activation, $_POST['question'], $_POST['answer']);
		$stmt->execute();
		$stmt->close();
		//mysqli_query($con, "INSERT INTO Users (Username, Password, Email, Creation_Date, Activated, Activation, Question, Answer) VALUES ('" . $_POST['Username'] . "', '" . $_POST['password'] . "', '" . $_POST['email'] . "', now(), 0, '" . $activation . "', '" . $_POST['question'] . "', '" . $_POST['answer'] . "')");
		mail($_POST['email'], "Bracket confirmation email", "Go to the following link to activate your account:\n http://devitdixon.com/Bracket/activation.php?q=" . $activation, "From: noreply@bracket.com");
		echo "Confirmation email sent to " . $_POST['email'] . ". Please open the email and click on the activation link to continue!";
	}
?>