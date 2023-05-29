<?php
	session_start();
	require_once("config.php");
	// Get webdata
	$Email = $_POST["loginEmail"];
	$Password = md5($_POST["loginPassword"]);
	print "Webdata ($Email) ($Password) <br>";
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = 0; // Redirect to loginForm
		$_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	// Build query
	$query = "Select * from Users where Email='$Email' and Password='$Password';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 0; // Redirect to loginform
		$_SESSION["Message"] = "Login query failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	// Check uniqueness
	if (mysqli_num_rows($result) != 1) {
		$_SESSION["RegState"] = 0; // Redirect to loginform
		$_SESSION["Message"] = "Login check failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Login success. ";
	// Remember to update LDatetime
	$rows = mysqli_fetch_assoc($result);
	$_SESSION["FirstName"] = $rows["FirstName"];
	$_SESSION["LastName"] = $rows["LastName"];
	$_SESSION["Email"] = $rows["Email"];
	$_SESSION["RegState"] = 4; // Logged in
	$_SESSION["Message"] = "Login success !!!";
	header("location:../protected.php");
	exit();
?>