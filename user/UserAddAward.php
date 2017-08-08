<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Add Award</title>
			<link rel="stylesheet" href="cs_467_final_project.css" type="text/css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		</head>
		<body>
			<h1>Employee Awards User Site</h1>
			<img src="http://34.212.188.210:3000/cartoon_guy_trophy.jpg" class="img">
			<h3 class="headerClass">Add Award</h3>
			<div>
				<form class="userForm" method="post" action="CreateAward.php">
					<fieldset>
						<legend>Enter Award Information</legend>
							<p><?php
								if (!empty($_COOKIE["newAward"])) {
									echo($_COOKIE["newAward"]);
								}
							?></p>
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
