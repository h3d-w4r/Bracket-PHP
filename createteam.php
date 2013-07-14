<?php
    require_once('recaptchalib.php');
    require_once('connection.php');
	$con = connectToDB();
	$results = mysqli_query($con,"SELECT * FROM Teams");
	$bool = false;
	$privatekey = "6LdkBeMSAAAAAOGiPwwYxNHddusm7PEMPXaJaoEJ";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	
	if($resp->is_valid){
		while(($row = mysqli_fetch_array($results))&&$bool!=true){
			if(strtolower($row['Name'])==strtolower($_POST['name'])){
				
				$bool = true;
			}
		}
		
		if($bool!=true){
			$stmt = $con->prepare("INSERT INTO Teams (Name, Captain) Values (?, ?)");
			$stmt->bind_param('ss', $_POST['name'], $_COOKIE['User']);
			$stmt->execute();
			$stmt->close();
		}
		
	}
?>