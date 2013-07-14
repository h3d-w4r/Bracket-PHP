<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<meta name="author" content="Tyler" />
	<!-- Date: 2013-06-18 -->
</head>
<body onload="checkCookie();">
	<script src="sha256.js"></script>
	<script src="core.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	
	<script type="text/javascript">
		function checkCookie(){
			if(times>1){
				document.getElementById('captcha').style.display = "block";
				var needed = 'true';
			}
			else{
				var times = 0;
				var needed = 'false';
			}
		}
		
		function DoSubmit(){
			document.info.password.value = CryptoJS.SHA256(document.info.password.value);
			document.info.passwordconfirm.value = CryptoJS.SHA256(document.info.passwordconfirm.value);
		}
		
		function checkUser(){
			
			var uname = document.info.Username.value;
			var pass = CryptoJS.SHA256(document.info.password.value);
			
			var correct = $.ajax({
				url: "login.php",
				async: false,
				type: 'POST',
				data: 'username='+uname+'&password='+pass+"&recaptcha_challenge_field=" + document.info.recaptcha_challenge_field.value+"&recaptcha_response_field=" + document.info.recaptcha_response_field.value + "&recap="+needed + "&times=" + times,
			}).responseText;
			
			//alert(correct);
			
			if(correct == "true"){
				document.getElementById('uname').innerHTML = "Password correct, redirecting...";
			}
			else if(correct == "wrong"){
				document.getElementById('uname').innerHTML = "Captcha is wrong, please try again.";
			}
			else{
				times=times+1;
				if(times=8){
					document.getElementById('captcha').style.display = "block";
				}
				document.getElementById('uname').innerHTML = "Password incorrect";
			}
		}
	</script>
	<form name="info" method="post">
		
		Username: <input type="text" name="Username" maxlength="20"><br />
		
		Password: <input type="password" name="password" maxlength="20"><br />
		<?php
          require_once('recaptchalib.php');
          $publickey = "6LdkBeMSAAAAALI2VIegPyck3l89xZD_essvzVcp";
          echo '<div id="captcha" style="display: none;">' .  recaptcha_get_html($publickey)  . '</div>';
          
        ?>
        
		<b id="uname">asdfasdf</b>
				
		<input type="button" name="submit" value="submit" onclick="checkUser();"/>
		<?php
		if(isset($_COOKIE['Times'])){
			$times = $_COOKIE['Times'];
		}
		else
			$times=0;
		if(isset($_COOKIE['Captcha'])){
          	echo "<script type='text/javascript'>document.getElementById('captcha').style.display = 'block'; var needed=true;</script>";
          	echo "<br />You have failed to get your password correct within 7 tries within the past hour, for security reasons, you must respond with a captcha as well for the next hour.";
          	echo "<script type='text/javascript'>var times = " . $times . ";</script>";
		}
		else {
			echo "<script type='text/javascript'>var times = " . $times . "; var needed=false;</script>";
		}
	?>
	</form>
</body>
</html>

