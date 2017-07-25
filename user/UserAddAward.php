<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>DRACO AWARDS Add Award</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head>
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">Add Award</h2>
			<div>
				<form class=firstrow method="post" action="CreateAward.php">
					<fieldset>
						<legend>Enter Award Information</legend>
							<p><?php echo($_COOKIE["newAward"]); ?></p>
							<p>Recipient E-mail: <input type="text" name="username" /></p>
							<p>Recipient Name (as displayed on the award): <input type="text" name="name" /></p>
							<p>Award Type: 
								<select name="awardType">
									<?php
								    include 'database.php';
								    $pdo = Database::connect();
								    $sql = 'select full_name from award_types';
								    foreach ($pdo->query($sql) as $row) {
									 		echo('<option>'.$row['full_name'].'</option>');
								    }
								    Database::disconnect();
								    ?>
								</select>
							</p>
							<p>Award Date: 
								<!--reference: https://gist.github.com/furkanmustafa/4648867-->
								<select name="month">
									<option value="">Month</option>
									<?php for ($month = 1; $month <= 12; $month++) { ?>
									<option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
									<?php } ?>
								</select>
								<select name="day">
								  <option value="">Day</option>
									<?php for ($day = 1; $day <= 31; $day++) { ?>
									<option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
									<?php } ?>
								</select>
								<select name="year">
									<option value="">Year</option>
									<?php for ($year = date('Y'); $year > date('Y')-100; $year--) { ?>
									<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
									<?php } ?>
								</select>
							</p>
						<input type="submit" name="submit" value="Add" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>
	
