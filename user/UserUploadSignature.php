<!DOCTYPE html>
	<html lang="en">
		<head>
			<link rel="stylesheet"type="text/css" href="cs_467_final_project.css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<meta charset="UTF-8">
			<title>Upload Signature</title>
		</head>
		<body>
			<h1>Employee Awards User Site</h1>
			<img src="http://34.212.188.210:3000/cartoon_guy_trophy.jpg" class="img">
			<h3 class="headerClass">Upload Signature</h3>
			<div>
				<form class="userForm" method="post" action="Upload.php" enctype="multipart/form-data">
					<fieldset>
						<legend>Please upload signature file to complete registration</legend>
							<p>Signature (upload image file):</p>
								<!--reference: https://www.w3schools.com/php/php_file_upload.asp-->
							<p><input type="file" name="file"></p>
							<p><input type="submit" value="Upload Image and Complete Registration" name="upload"></p>
					</fieldset>
				</form>
			</div>
		</body>
	</html>
	
	
