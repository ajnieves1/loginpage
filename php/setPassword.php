<?php
	session_start();
	require_once("config.php");
	//Get webdata
	$Password1 = md5($_POST["Password1"]);
	$Password2 = md5($_POST["Password2"]);
	if ($Password1 != $Password2) {
		$_SESSION["RegState"] = 3; // Redirect to setPasswordForm
		$_SESSION["Message"] = "Passwords don't match. Try again.";
		header("location:../index.php");
		exit();
	}
	$Email = $_SESSION["Email"];
	// password checking passed
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = 3; // dont switch view
		$_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Database Connected! <br>";
	//build query
	$Email = $_SESSION["Email"];
	$PasswordChangeDatetime = date("Y-m-d h:i:s");
	$query = "Update Users set Password='$Password1', LastPasswordChangeDatetime='$PasswordChangeDatetime', "."PasswordChangeCnt=PasswordChangeCnt+1 where Email='$Email';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 3; // dont switch view
		$_SESSION["Message"] = "Set password query failed".mysqli_error($con);
		header("location:../index.php");
		exit();		
	}
	print "Update execuded...., checking result.. <br>";
	//Check updates
	if (mysqli_affected_rows($con) != 1) {
		$_SESSION["RegState"] = 3; // dont switch view
		$_SESSION["Message"] = "Set password check failed:".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	// remember to add passwordChangeCnt and passwordChangeDatetime
	// Update Users Set passwordChangeCnt = passwordChangeCnt + 1, passwordChangeDatetime='$NewDatetime' where Email='$Email'
	print "Password set successfully..<br>";
	// PW set. Ready to login.
	$_SESSION["RegState"] = 0;
	$_SESSION["Message"] = "Password set. Please login";
	header("location:../index.php");
	exit();
?>