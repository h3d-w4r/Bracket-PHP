<?php
	//Connect to the server
	require_once('connection.php');
	$con = connectToDB();
	
	//Gets an array of all of the users, and thus proceeds to check if the Username
	//or email is unique, depending upon which is being checked
	$results = mysqli_query($con,"SELECT * FROM Users");
	$bool = false;
	if($_GET['username']!="f"){
		while(($row = mysqli_fetch_array($results))&&$bool!=true){
			if(strtolower($row['Username'])==strtolower($_GET['username'])){
				
				$bool = true;
			}
		}
	}
	
	if($_GET['email']!="f"){
		while(($row = mysqli_fetch_array($results))&&$bool!=true){
			if($row['Email']==$_GET['email']){
				$bool = true;
			}
		}
	}
	
	//The return value | false means username or email wasn't found
	if($bool==true){
		echo "true";
	}
	else{
		echo "false";
	}
?>