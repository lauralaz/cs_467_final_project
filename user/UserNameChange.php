<!DOCTYPE html>
	<html lang="en">
		<head>
			<link rel="stylesheet"type="text/css" href="cs_467_final_project.css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<meta charset="UTF-8">
			<title>Name Change</title>
		</head>
		<body>
			<h1>Employee Recognition User Site</h1>
			<img src="https://i.imgur.com/S2KpCun.jpg" class="img">
			<h3 class="headerClass">Name Change</h3>
			<div>
				<form class="userForm" method="post" action="UpdateName.php">
					<fieldset>
						<legend>Enter New Name</legend>
							<p>First Name: <input type="text" name="lastname" /></p>
							<p>Last Name: <input type="text" name="firstname" /></p>
						<input type="submit" name="submit" value="Change Name" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>