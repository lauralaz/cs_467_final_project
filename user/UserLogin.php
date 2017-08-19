<!DOCTYPE html>
	<html lang="en">
		<head>
			<link rel="stylesheet"type="text/css" href="cs_467_final_project.css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<meta charset="UTF-8">
			<title>User Login</title>
		</head>
		<body>
			<h1>Employee Recognition User Site</h1>
			<img src="http://34.212.188.210:3004/cartoon_guy_trophy.jpg" class="img">
			<h3 class="headerClass">User Login</h3>
			<div>
				<form class="userForm" method="post" action = "Login.php">
					<fieldset>
						<legend>Enter Username and Password</legend>
							<p>Username: <input type="text" name="username" id="Username"/></p>
							<p>Password: <input type="password" name="password" id="Password"/></p>
						<input type="Submit" name="Login" value="Login"/>
					</fieldset>
				</form>
				<br>
				<form class="userForm" method="post" action="UserVerify.php">
					<fieldset>
						<legend>Forgot Password?</legend>
						<input type="Submit" name="recover" value="Reset Password" />
					</fieldset>
				</form>
				<br>
				<form class="userForm" method="post" action="UserRegister.php">
					<fieldset>
						<legend>Don't Have an Account Yet?</legend>
						<input type="Submit" name="register" value="Register New User" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>
