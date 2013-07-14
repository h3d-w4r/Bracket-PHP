<?php
	require_once('recaptchalib.php');
    require_once('connection.php');
	$con = connectToDB();
	$results = mysqli_query($con,"SELECT * FROM Users");
	$bool = false;
	if($_POST['times']=="8"){
		setcookie("Captcha", "true", time()+3600);
	}
	if($_POST['recap']=='false'){
		setcookie("Times", $_POST['times'], time()+3600);
		while(($row = mysqli_fetch_array($results))&&$bool!=true){
			if(strtolower($row['Username'])==strtolower($_POST['username'])){
				$bool = true;
				if($row['Password']==$_POST['password']){
					$random = rand(0,1000);
		
					$randomUser = $random . $_POST['username'] . $random;
					$randomUser = hash("SHA256", $randomUser);
					mysqli_query($con, "UPDATE Users SET CookieValue='" . $randomUser . "' WHERE Username='" . $_POST['username'] . "'");
					setcookie("CookieValue", $randomUser, time()+3600);
					setcookie("User", $_POST['username'], time()+3600);
					setcookie("Times", '', time()-3600);
					echo 'true';
					
				}
				
			}
		}
	}
	else{
		
		$privatekey = "6LdkBeMSAAAAAOGiPwwYxNHddusm7PEMPXaJaoEJ";
		$resp = recaptcha_check_answer ($privatekey,
	                                $_SERVER["REMOTE_ADDR"],
	                                $_POST["recaptcha_challenge_field"],
	                                $_POST["recaptcha_response_field"]);
		
		if(!$resp->is_valid){
			echo 'wrong';
		}		
							
		while(($row = mysqli_fetch_array($results))&&$bool!=true&&$resp->is_valid){
			if(strtolower($row['Username'])==strtolower($_POST['username'])){
				$bool = true;
				if($row['Password']==$_POST['password']){
					$random = rand(0,1000);
		
					$randomUser = $random . strtolower($_POST['username']) . $random;
					$randomUser = hash("SHA256", $randomUser);
					mysqli_query($con, "UPDATE Users SET CookieValue='" . $randomUser . "' WHERE Username='" . strtolower($_POST['username']) . "'");
					setcookie("CookieValue", $randomUser, time()+3600);
					setcookie("User", $_POST['username'], time()+3600);
					
					echo 'true';
					
				}
				
			}
		}
	}
	
?>