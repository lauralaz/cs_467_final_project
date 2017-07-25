<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>DRACO AWARDS User Login</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">User Login</h2>
			<div>
				<form class=firstrow method="post" action = "Login.php">
					<fieldset>
						<legend>Enter Username and Password</legend>
							<p>Username: <input type="text" name="username" id="Username"/></p>
							<p>Password: <input type="password" name="password" id="Password"/></p>
						<input type="Submit" name="Login" value="Login"/>
					</fieldset>
				</form>
				<br>
				<br>
				<form class=firstrow method="post" action="UserVerify.php">
					<fieldset>
						<legend>Forgot Password?</legend>
						<input type="Submit" name="recover" value="Reset Password" />
					</fieldset>
				</form>
				<br>
				<br>
				<form class=firstrow method="post" action="UserRegister.php">
					<fieldset>
						<legend>Don't Have an Account Yet?</legend>
						<input type="Submit" name="register" value="Register New User" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>
