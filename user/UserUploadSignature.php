<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>DRACO AWARDS Upload Signature</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head>
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">Upload Signature</h2>
			<div>
				<form class=firstrow method="post" action="Upload.php" enctype="multipart/form-data">
					<fieldset>
						<legend>Please upload signature file to complete registration</legend>
							<p>Signature (upload image file):
								<!--reference: https://www.w3schools.com/php/php_file_upload.asp-->
								<input type="file" name="file">
								<input type="submit" value="Upload Image and Complete Registration" name="upload">
							</p>
					</fieldset>
				</form>
			</div>
		</body>
	</html>
	
	
