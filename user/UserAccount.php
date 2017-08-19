<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

setcookie( "newAward", "", time()- 3600, "/","", 0);
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from users where email = ?";
$q = $pdo->prepare($sql);
$q->execute(array($_COOKIE["email"]));
$data = $q->fetch(PDO::FETCH_ASSOC);

Database::disconnect();
?>
<!DOCTYPE html>
	<html lang="en">
		<head>
			<link rel="stylesheet"type="text/css" href="cs_467_final_project.css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<meta charset="UTF-8">
			<title>User Account</title>
		</head>
		<body>
			<h1>Employee Awards User Site</h1>
			<img src="https://i.imgur.com/S2KpCun.jpg" class="img">
			<h3 class="headerClass">User Account</h3>
			<div>
				<form class="userForm" method="post" action="UserNameChange.php">
					<fieldset class=accountinfo>
					<legend>Account Information</legend>
						<p>Name:
						<?php
						echo ($data['user_name'].' '.$data['user_last_name']);
						?>
							<input type="submit" value="Change Name" name="submit">
						</p>
						<p>Password:
						<?php
						echo ($data['password']);
						?>
						</p>
						<p>Security word:
						<?php
						echo ($data['security_word']);
						?>
						<p>
						(Note: normal sites should not display passwords and security word, but for grading purposes we chose to display both.)</p>
						<p>Signature:
						<!--<a href="images/<?php echo $data['photo'] ?>" target="_blank">View Image</a>-->
						<img src="images/<?php echo $data['photo'] ?>">
						</p>
						<p>Account Created:
						<?php
						echo ($data['registration_time']);
						?>
						</p>
						<p>Awards Created:</p>
					</fieldset>
				</form>
			</div>
			<div>
				<fieldset>
					<table class="center">
						<thead>
							<tr>
								<th>Award type</th>
								<th>Awardee</th>
								<th>Awardee_email</th>
								<th>Awarder</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$date = null;
								//reference: https://stackoverflow.com/questions/15641610/extract-only-date-without-the-time-from-mysql-table
								$pdo2 = Database::connect();
								$sql2 = "SELECT id,
										full_name,
										owner_name awardee,
										owner awardee_email,
										(select concat(user_name,' ',user_last_name) from users where email = who_created) awarder,
										DATE(creation_time) AS creation_time
										FROM awards, award_types
										where who_created = ? and awards_type=type_id";
								$q2 = $pdo->prepare($sql2);
								$q2->execute(array($_COOKIE["email"]));
								$date = date('Y-m-d', strtotime($date));
								foreach ($q2 as $row) {
									echo '<tr>';
									//echo '<td>'. $row['id'] . '</td>';
									echo '<td>'. $row['full_name'] . '</td>';
									echo '<td>'. $row['awardee'] . '</td>';
									echo '<td>'. $row['awardee_email'] . '</td>';
									echo '<td>'. $row['awarder'] . '</td>';
									$creation_time = date('Y-m-d', strtotime($row['creation_time']));
									//echo '<td>'. $row['creation_time'] . '</td>';
									echo '<td>'. $creation_time . '</td>';
									echo '<td><a class="btn" href="DeleteAward.php?id='.$row['id'].'">Delete Award</a></td>';
									echo '</tr>';
							   }
							   Database::disconnect();
							  ?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<br>
			<div>
				<form class="userForm" method="post" action="UserAddAward.php">
					<input type="submit" value="Add Award" name="submit">
				</form>
			</div>
			<br>
			<div>
				<form class="userForm">
					<input type="button" value="Generate Award" onclick="window.location.href='https://evening-eyrie-73949.herokuapp.com'"/>
				</form>
			</div> <!-- /container -->
			<br>
			<div>
				<form class="userForm" method="post" action="UserLogout.php">
					<input type="submit" value="Logout" name="submit">
				</form>
			</div>
		</body>
	</html>
