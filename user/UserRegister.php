<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>DRACO AWARDS User Registration</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head>
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">User Registration</h2>
			<div>
				<form class=firstrow method="post" action="Register.php">
					<fieldset>
						<legend>Enter User Information</legend>
							<p><?php echo($_COOKIE["register"]); ?></p>
							<p>Username (same as e-mail): <input type="text" name="username" /></p>
							<p>Password: <input type="password" name="password" /></p>
							<p>First Name: <input type="text" name="firstname" /></p>
							<p>Last Name: <input type="text" name="lastname" /></p>
							<p>Security word: <input type="text" name="security" /></p>
						<input type="submit" name="submit" value="Continue" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>
	
