<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        $error = null;
         
        $email = $_POST['username'];
        $security = $_POST['security'];
         
        $valid = true;
         
        if (empty($email)) {
            $error = $error.'Please enter Email Address.<br/>';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = $error.'Please enter a valid Email Address.<br/>';
            $valid = false;
        }
         
        if (empty($security)) {
            $error = $error.'Please enter security word.<br/>';
            $valid = false;
        }
        
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select email from users where email = ? and security_word = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($email,$security));
            if($q->rowCount() == 0)
			{
			  setcookie( "err", $error."Sorry! Your security word does not match the one you enter while registration.<br/>", time()+ 3600, "/","", 0);
			  header("Location: UserVerify.php");
			} else {
				setcookie( "err","", time()- 60, "/","", 0);
				$data = $q->fetch(PDO::FETCH_ASSOC);
				setcookie("email", $data['email'], time()+3600, "/","", 0);
			}
			Database::disconnect();
        }else {
			setcookie( "err", $error, time()+ 3600, "/","", 0);
			header("Location: UserVerify.php");
		}
    }
?>

<!DOCTYPE html>
	<html lang="en">
				<head>
			<link rel="stylesheet"type="text/css" href="cs_467_final_project.css">
			<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Vollkorn"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<meta charset="UTF-8">
			<title>Password Reset</title>
		</head>
		<body>
			<h1>Employee Awards User Site</h1>
			<img src="http://34.212.188.210:3000/cartoon_guy_trophy.jpg" class="img">
			<h3 class="headerClass">Password Reset</h3>
			<div>
				<form class="userForm" method="post" action="ResetPassword.php">
					<fieldset>
						<legend>Reset Password</legend>
							<p>Enter New Password: <input type="password" name="password" /></p>
						<input type="submit" name="submit" value="Reset" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>
	
