<?php
	require_once('connection.php');
	$con = connectToDB();

	$results = mysqli_query("SELECT * from Users WHERE Username = '" . $_COOKIE['User'] . "');
	$row = mysqli_fetch_array($results);

	echo $row['Password'];
?>