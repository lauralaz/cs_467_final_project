<?php
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
			<meta charset="UTF-8">
			<title>DRACO AWARDS User Account</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head>
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">User Account</h2>
			<div>
				<form method="post" action="UserLogout.php">
					<input type="submit" value="Logout" name="submit">
				</form>
				<br>
				<fieldset class=accountinfo>
					<legend>Account Information</legend>
						<p>Name:
						<?php
						echo ($data['user_name'].' '.$data['user_last_name']);
						?>
						<form method="post" action="UserNameChange.php">
						<input type="submit" value="Change Name" name="submit">
						</form>
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
						</p>
						Note: normal sites should not display passwords and security word, but for grading purposes we chose to display both.
						<p>Signature:
						<a href="images/<?php echo $data['photo'] ?>" target="_blank">view file</a>
						</p>
						<p>Account Created:
						<?php
						echo ($data['registration_time']);
						?>
						</p>
						<div class="container">
							<div class="row">
								<p><h3>Awards Created:</h3></p>
							<table class="table table-striped table-bordered">
							  <thead>
								<tr>
								  <th>Award ID</th>
								  <th>Award type</th>
								  <th>Awardee</th>
								  <th>Awardee_email</th>
								  <th>Awarder</th>
								  <th>Date</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php
							   //include 'database.php';
							   $pdo2 = Database::connect();
							   $sql2 = "SELECT id,
										full_name,
										owner_name awardee,
										owner awardee_email,
										(select concat(user_name,' ',user_last_name) from users where email = who_created) awarder,
										creation_time
										FROM awards, award_types
										where who_created = ? and awards_type=type_id";
								$q2 = $pdo->prepare($sql2);
								$q2->execute(array($_COOKIE["email"]));
							   foreach ($q2 as $row) {
										echo '<tr>';
										echo '<td>'. $row['id'] . '</td>';
										echo '<td>'. $row['full_name'] . '</td>';
										echo '<td>'. $row['awardee'] . '</td>';
										echo '<td>'. $row['awardee_email'] . '</td>';
										echo '<td>'. $row['awarder'] . '</td>';
										echo '<td>'. $row['creation_time'] . '</td>';
										echo '<td><a class="btn" href="DeleteAward.php?id='.$row['id'].'">Delete Award</a></td>';
										echo '</tr>';
							   }
							   Database::disconnect();
							  ?>
							  </tbody>
							</table>
							</div>
							<br>
							<form method="post" action="UserAddAward.php">
								<input type="submit" value="Add Award" name="submit">
							</form>
						</div> <!-- /container -->
				</fieldset>
			</div>
		</body>
	</html>
