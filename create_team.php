<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Create Team</title>
  <meta name="description" content="" />
  <meta name="author" content="Tyler" />

  <meta name="viewport" content="width=device-width; initial-scale=1.0" />

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
</head>

<body>
	<?php
		if(isset($_COOKIE['User'])){
	          require_once('recaptchalib.php');
	          $publickey = "6LdkBeMSAAAAALI2VIegPyck3l89xZD_essvzVcp";
	          echo '<form action="createteam.php" method="post">
					Team Name: <input type="text" name="name">
					<div id="captcha">' .  recaptcha_get_html($publickey)  . '</div> <input type="submit" value="Submit" />
				</form>
				';
		}
		else {
			echo 'You are not logged in at the moment.';
		}
	?>
	
</body>
</html>
