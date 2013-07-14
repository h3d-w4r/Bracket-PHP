<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Password Recovery</title>
	<meta name="author" content="Tyler" />
	
	<!-- Date: 2013-06-14 -->
</head>
<body>
	<script src="sha256.js"></script>
	<script src="core.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	
	function onSubmit(){
		var avail = $.ajax({
					url: "check_user.php?email=" + document.info.email.value + "&username=f",
					async: false,
					type: 'get'
				}).responseText;
				
		
		if(avail == "false"){
			document.getElementById('sent').innerHTML = 'An account at that email could not be found. Keep in mind: your email is case-sensitive';
		}
		else{
			document.getElementById('sent').innerHTML = 'Email Sent. Note: Email was not sent if you have not already activated your account.';
			var availa = $.ajax({
				url: "create_recovery.php",
				async: false,
				type: 'POST',
				data: 'email=' + document.info.email.value
			}).responseText;
			if(availa == 'sent'){
				document.getElementById('sent').innerHTML = 'Password reset email has been sent';
			}
			else
				document.getElementById('sent').innerHTML = 'This account has not yet been activated, and thus, you cannot change the password.';
		}
	}
		
	</script>
	
	<form name="info">		
		Enter your email: <input type="email" name="email"> <br />
		<input type="button" name="submit" value="submit" onclick="onSubmit();"/>
		<b id="sent"></b>
	</form>
</body>
</html>

