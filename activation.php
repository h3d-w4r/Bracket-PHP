<?php
    require_once('connection.php');
	$con = connectToDB();
    $activate = $_GET['q'];
	
	mysqli_query($con, "UPDATE Users SET Activated=1 WHERE Activation='" . $activate . "'");
	
	echo 'Your account has been activated! You may now use this account.';
?>