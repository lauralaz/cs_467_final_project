<!DOCTYPE html>
	<html lang="en">
		<head>
			<link rel="stylesheet"type="text/css" href="cs_467_final_project.css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<meta charset="UTF-8">
			<title>Security Verification</title>
		</head>
		<body>
			<h1>Employee Awards User Site</h1>
			<img src="http://34.212.188.210:3000/cartoon_guy_trophy.jpg" class="img">
			<h3 class="headerClass">Security Verification</h3>
			<div>
				<form class="userForm" method="post" action="UserPasswordReset.php">
					<fieldset>
						<legend>User Verification</legend>
							<p>Username (same as e-mail): <input type="text" name="username" /></p>
							<p>Enter Security Word: <input type="text" name="security" /></p>
						<input type="submit" name="submit" value="Verify" />
					</fieldset>
				</form>
				<br>
				<form class="userForm" method="post" action="UserLogin.php">
						<input type="Submit" name="login" value="Go Back to Login Page"/>
				</form>
			</div>
		</body>
	</html>
	
