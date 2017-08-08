<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        $error = null;
         
        $email = $_POST['username'];
        $password = $_POST['password'];
         
        $valid = true;
         
        if (empty($email)) {
            $error = $error.'Please enter Email Address.<br/>';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = $error.'Please enter a valid Email Address.<br/>';
            $valid = false;
        }
         
        if (empty($password)) {
            $error = $error.'Please enter password.<br/>';
            $valid = false;
        }
        
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from users where email = ? and password = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($email,$password));
            if($q->rowCount() == 0)
			{
			  setcookie( "welcome", $error."Wrong password.<br/>", time()+ 3600, "/","", 0);
			  header("Location: UserNewAccountLogin.php");
			} else {
				setcookie( "welcome","", time()- 60, "/","", 0);
				setcookie("email", $email, time()+31536000, "/","", 0);
				header("Location: UserAccount.php");
			}
			Database::disconnect();
        }else {
			setcookie( "welcome", $error, time()+ 3600, "/","", 0);
			header("Location: UserNewAccountLogin.php");
		}
    }
?>
