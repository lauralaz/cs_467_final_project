<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>DRACO AWARDS User Login</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head>
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">User Login</h2>
			<div>
				<form class=firstrow method="post" action="Login.php">
					<fieldset>
						<legend>Enter Username and Password</legend>
							<p><?php echo($_COOKIE["welcome"]); ?></p>
							<p>User Name: <input type="text" name="username" /></p>
							<p>Password: <input type="password" name="password" /></p>
						<input type="Submit" name="login" value="Login" />
					</fieldset>
				</form>
				<br>
				<br>
				<form class=firstrow method="post" action="UserLogin.php">
						<input type="Submit" name="login" value="Back" />
				</form>
			</div>
		</body>
	</html>
	
	
