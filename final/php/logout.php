<?php
	session_start();
	// Must register logout time here ...
	require_once("config.php");
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = 4; 
		$_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
		header("location:protected.php");
		exit();
	}
	$LOdatetime = date("Y-m-d h:i:s");
	$Email = $_SESSION["Email"];
	$query = "Update Users set LOdatetime='$LOdatetime' where Email='$Email';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Database update failed: ".mysqli_error($con);
		header("location:protected.php");
		exit();
	}
	// check if update successful
	if (mysqli_affected_rows($con) !=1) {
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Database update check failed: ".mysqli_error($con);
		header("location:protected.php");
		exit();	
	}
	session_destroy();
	session_start();
	$_SESSION["RegState"] = 0;
	$_SESSION["Message"] = "Last logout time logged.";
	header("location:../index.php");
	exit();
?>