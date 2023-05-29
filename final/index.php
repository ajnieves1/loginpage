<?php
	session_start();
	if (!isset($_SESSION["RegState"])) $_SESSION["RegState"] = 0;
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title>Andrew's Final</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
	<meta name="theme-color" content="#712cf9">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/sign-in.css" rel="stylesheet">
</head>
<body class="text-center">    
<main class="form-signin w-100 m-auto">
<?php
	if ($_SESSION["RegState"] <= 0) {
?>
	<form id="loginForm" action="php/login.php" method="POST">
		<img class="mb-4" src="images/bootstrap-logo.svg" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

		<div class="form-floating">
			<input type="email" class="form-control" name="loginEmail" id="floatingInput" placeholder="name@example.com">
			<label for="floatingInput">Email address</label>
		</div>
		<div class="form-floating">
			<input type="password" class="form-control" name="loginPassword" id="floatingPassword" placeholder="Password">
			<label for="floatingPassword">Password</label>
		</div>
		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" name="rememberMe" value="remember-me"> Remember me
			</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
		<div id="loginMessage" class="w-100 btn btn-warning btn-block">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<a href="php/registerView.php">Register </a>
		|
		<a href="php/forgetView.php">Forget?</a>
	</form>
<?php
	}
	if ($_SESSION["RegState"] == 1) {
?>
	<form id="registerForm" action="php/register.php" method="POST">
		<img class="mb-4" src="images/bootstrap-logo.svg" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please register</h1>
		<div class="form-floating">
			<input type="text" class="form-control" id="floatingFirstName" name="FirstName" placeholder="Please enter your first name..." required>
			<label for="floatingFirstName">First Name</label>
		</div>
		<div class="form-floating">
			<input type="text" class="form-control" id="floatingLastName" name="LastName" placeholder="Please enter your last name..." required>
			<label for="floatingLastName">Last Name</label>
		</div>
		<div class="form-floating">
			<input type="email" class="form-control" id="floatingInput" name="registerEmail" placeholder="Please enter your email address" required>
			<label for="floatingInput">Email address</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
		<div id="registerMessage" class="w-100 btn btn-warning btn-block">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<a href="php/returnView.php">
			<div id="returnBtn" class="w-50 btn btn-lg btn-info retBtn">
				Return
			</div>
		</a>
	</form>
<?php
	}
	if ($_SESSION["RegState"] == 2) {
?>
	<form id="authenticateForm" action="php/authenticate.php" method="POST">
		<img class="mb-4" src="images/bootstrap-logo.svg" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please enter authentication code</h1>
		<div class="form-floating">
			<input type="text" class="form-control" name="Acode" id="floatingAcode" placeholder="Please enter Acode from your email">
			<label for="floatingAcode">Authentication Code</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Authenticate</button>
		<div id="authenticateMessage" class="w-100 btn btn-warning btn-block">
		<?php
			print $_SESSION["Message"];
			$_SESSION["Message"] = "";
		?>
		</div>
		<a href="php/returnView.php">
			<div id="returnBtn" class="w-50 btn btn-lg btn-info retBtn">
				Return
			</div>
		</a>
	</form>
<?php
	}
	if ($_SESSION["RegState"] == 3) {
?>
	<form id="setPasswordForm" action="php/setPassword.php" method="POST"> 
		<img class="mb-4" src="images/bootstrap-logo.svg" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please set your password:</h1>
		<div class="form-floating">
			<input type="password" name="Password1" class="form-control" id="floatingPassword1" placeholder="Please enter password">
			<label for="floatingPassword1">Password</label>
		</div>
		<div class="form-floating">
			<input type="password" name="Password2" class="form-control" id="floatingPassword2" placeholder="Password again">
			<label for="floatingPassword2">Password again</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Set Password</button>
		<div id="setPasswordMessage" class="w-100 btn btn-warning btn-block">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<a href="php/returnView.php">
			<div  id="returnBtn" class="w-50 btn btn-lg btn-info retBtn">
				Return
			</div>
		</a>
	</form>
<?php
	}
	if ($_SESSION["RegState"] == 5) {
?>
	<form id="resetPasswordForm" action="php/resetPassword.php" method="POST">
		<img class="mb-4" src="images/bootstrap-logo.svg" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please enter your registered email:</h1>
		<div class="form-floating">
			<input type="email" class="form-control" name="resetPasswordEmail" id="floatingEmail" placeholder="Please enter your registered email address">
			<label for="floatingEmail">Registered Email address</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Authenticate Email</button>
		<div id="resetPasswordMessage" class="w-100 btn btn-warning btn-block">
		<?php
			print $_SESSION["Message"];
			$_SESSION["Message"] = "";
		?>
		</div>
		<a href="php/returnView.php">
			<div id="returnBtn" class="w-50 btn btn-lg btn-info retBtn">
				Return
			</div>
		</a>
	</form>
<?php
	}
?>
   
</body>
</html>
