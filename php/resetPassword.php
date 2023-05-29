<?php
	session_start();
	require_once("config.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	print "Registering....After session start <br>";
	require '../../PHPMailer-master/src/Exception.php';
	require '../../PHPMailer-master/src/PHPMailer.php';
	require '../../PHPMailer-master/src/SMTP.php';
	
	//get web data
	$Email = $_POST["resetPasswordEmail"];
	print "resetPasswordEmail($Email) <br>";
	//check if email exists
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = 5; // Redirect to resetpasswordform
		$_SESSION["Message"] = "Database connection failed: " .mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Database connected !! <br>";
	// query build
	$query = "select * from Users where Email='$Email';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 5;
		$_SESSION["Message"] = "Email checking query failed: " .mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Query worked ... <br>";
	if (mysqli_num_rows($result) !=1) {
		$_SESSION["RegState"] = 5;
		$_SESSION["Message"] = "Email not registered. try again.";
		header("location:../index.php");
		exit();		
	}
		//Acode must be regenerated
	$Acode = rand(100000,999999);
	$Adatetime = date("Y-m-d h:i:s");
	$query = "update Users set Acode='$Acode', Adatetime='$Adatetime' where Email='$Email';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = 5;
		$_SESSION["Message"] = "Acode update query failed: " .mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Acode query update worked ... <br>";
	if (mysqli_affected_rows($con) != 1) {
		$_SESSION["RegState"] = 5;
		$_SESSION["Message"] = "Acode update query check failed: " .mysqli_error($con);
		header("location:../index.php");
		exit();				
	}
	print "email is found in DB. Send authentication message <br>";
	//email is found in db 
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
		$msg = "Your password reset code is: $Acode  ";
		$mail->addAddress($Email,"$FirstName $LastName");
		$mail->Subject = "Account change alert";
		$mail->Body = $msg;
		$mail->send();
		print "Email sent ($Email)... <br>";
		$_SESSION["RegState"] = 2; // correct redirection to bring out authenticationForm
		$_SESSION["Message"] = "Email sent ($Email).";
		$_SESSION["Email"] = $Email; // Save email for authentication
	} catch (phpmailerException $e) {
			$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
			$_SESSION["RegState"] = 5;
			print "Mail send failed: ".$e->errorMessage;
	}
	header("location:../index.php");
	exit();
?>