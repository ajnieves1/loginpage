<?php
	session_start();
	require_once("config.php");
	print "After session_start() <br>";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	print "Registering....After session start <br>";
	require '../../PHPMailer-master/src/Exception.php';
	require '../../PHPMailer-master/src/PHPMailer.php';
	require '../../PHPMailer-master/src/SMTP.php';
	
	print "After PHPMailer includes <br>";
	// Get Webdata
	$FirstName = $_POST["FirstName"];
	$LastName = $_POST["LastName"];
	$Email = $_POST["registerEmail"];
	print "Web Data ($FirstName) ($LastName) ($Email) <br>";
	// Connect to mysql db 
	require_once("config.php");
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = 1; // Redirect to loginForm? or registerForm?
		$_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Database connected !! <br>";
	// Get random Acode, Rdatetime, send email to registered user_error
	$Acode = rand(100000, 999999);
	$Rdatetime = date("Y-m-d h:i:s");
	$query ="insert into Users (FirstName,LastName,Email,Acode,Rdatetime) values "
		."('$FirstName','$LastName','$Email','$Acode','$Rdatetime');";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Database insert failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Query worked ... <br>";

	if (mysqli_affected_rows($con) != 1) {
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Database insert failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Database insert worked !!! Ready to send auth email... <br>";

	// Build the PHPMailer object:
	$mail= new PHPMailer(true);
	try {
		$mail->SMTPDebug = 2; // Wants to see all errors
		$mail->IsSMTP();
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username="AN1052util@gmail.com";
		$mail->Password = "rpzkkntuuyohgrzr"; // Gmail password
		$mail->SMTPSecure = "ssl";
		$mail->Port=465;
		$mail->SMTPKeepAlive = true;
		$mail->Mailer = "smtp";
		$mail->setFrom("tun29995@temple.edu", "Andrew Nieves");
		$mail->addReplyTo("tun29995@temple.edu","Andrew Nieves");
		$msg = "Your person authentication code is: $Acode ";
		$mail->addAddress($Email,"$FirstName $LastName");
		$mail->Subject = "Welcome to Andrew's Lab 8!";
		$mail->Body = $msg;
		$mail->send();
		print "Email sent ($Email)... <br>";
		$_SESSION["RegState"] = 2; // To bring out authenticationForm
		$_SESSION["Message"] = "Email sent ($Email).";
		$_SESSION["Email"] = $Email; // Save email for authentication
	} catch (phpmailerException $e) {
			$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
			$_SESSION["RegState"] = 2; // Bring back registerForm until debugged
	}
	header("location:../index.php");
	exit();
?>