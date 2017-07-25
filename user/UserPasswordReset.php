<?php
     
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
			<meta charset="UTF-8">
			<title>DRACO AWARDS Password Reset</title>
			<link rel="stylesheet" href="TableStyle.css" type="text/css">
		</head>
		<body>
			<h1 align="center">DRACO AWARDS</h1>
			<h2 align="center">Password Reset</h2>
			<div>
				<form class=firstrow method="post" action="ResetPassword.php">
					<fieldset>
						<legend>Reset Password</legend>
							<p>Enter New Password: <input type="password" name="password" /></p>
						<input type="submit" name="submit" value="Reset" />
					</fieldset>
				</form>
			</div>
		</body>
	</html>
	
