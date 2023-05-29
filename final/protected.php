<?php
	session_start();
	if ($_SESSION["RegState"] != 4) {
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Please login first! ";
		header("location:index.php");
		exit();
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/jumbotron.css">
	<link rel="stylesheet" href="css/lab6.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/lab6.js"></script>
</head>
<body>
    <table class="jumbotron text-center" id="demo">
		<tr>
			<td Welcome: colspan="5">Countdown Timer
			<?php print $_SESSION["Email"]; ?>
			<?php print $_SESSION["FirstName"]; ?>
			<?php print $_SESSION["LastName"]; ?>
			</td>
		</tr>
		<tr>
			<td colspan="5"> 
				<?php
					print "Welcome ";
					print $_SESSION["FirstName"];
					print " ";
					print $_SESSION["LastName"];
				?>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<input type="date" id="EventDate">
				<input type="time" id="EventTime">
				<button class="btn btn-primary" id="setEventDate">Set Event Date</button>
			</td>
		</tr>
		<tr>
			<td><input class="manual" id="Days" type="number" value="0" max="365" size="1"></td>
			<td><input class="manual" id="Hours" type="number" value="0" max="23" size="1"></td>
			<td><input class="manual" id="Minutes" type="number" value="0" max="59" size="1"></td>
			<td><input class="manual" id="Seconds" type="number" value="0" max="59" size="1"></td>
			<td><input class="manual" id="mSeconds" value="0" size="1"></td>
		</tr>
		<tr> 
			<td>Days</td>
			<td>Hours</td>
			<td>Minutes</td>
			<td>Seconds</td>
			<td>MilliSec.</td>
		</td>
		<tr>
			<td colspan="5">
				<button class="btn btn-info" id="Start">Start</button>
				<button class="btn btn-secondary" id="Snooze">Snooze</button>
				<a href="php/logout.php">
					<button class="btn btn-primary">
						Logout
					</button>
				</a>
			</td>
		</tr>
	</table>
</body>
</html>

