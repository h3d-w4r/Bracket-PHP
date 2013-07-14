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
		document.question.password.value = CryptoJS.SHA256(document.question.password.value);
		document.question.passwordconfirm.value = CryptoJS.SHA256(document.question.passwordconfirm.value);
	}
		
	</script>
	
	<form name="question" method="post" action="change_password.php">		
		Enter your new password: <input type="password" name="password" maxlength="20"><br />
		Confirm password: <input type="password" name="confirm" maxlength="20"><br />
		<input type="submit" name="submit" value="submit" onclick="onSubmit();"/>
		<input type='hidden' name='q' value='<?php echo $_GET["q"]; ?>'>
		<b id="reset"></b>
	</form>
</body>
</html>

