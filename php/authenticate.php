<?php
	session_start();
	require_once("config.php");
	// Get webdata
	$ACode = $_POST["Acode"];
	$Email = $_SESSION["Email"]; // Retrieve saved email address from register.php
	print "webdata ($ACode) ($Email) <br>";

	//Connect to db 
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = 2; // dont switch view
		$_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Database connected! <br>";
	// build query
	$query = "select * from Users where Email='$Email' and Acode='$ACode';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 2; // Redirect to authenticateform
		$_SESSION["Message"] = "Select query failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Query worked ... <br>";

	if (mysqli_num_rows($result) != 1) {
		$_SESSION["RegState"] = 2; // Redirect to authenticateForm
		$_SESSION["Message"] = "Email authentication failed. Hacking suspected.";
		header("location:../index.php");
		exit();
	}
	print "Query check succeeded <br>";

	// Email auth success. Ready to set password.
	$_SESSION["RegState"] = 3; 
	$_SESSION["Message"] = "Email authentication success. Set password.";
	header("location:../index.php");
	exit();
?>