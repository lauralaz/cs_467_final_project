<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $error = null;
         
        // keep track post values
        $email = $_POST['username'];
        $password = $_POST['password'];
         
        // validate input
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
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (email,password,user_name,user_last_name,security_word) values(?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($email,$password,$_POST['firstname'],$_POST['lastname'],$_POST['security']));
            setcookie("email", $email, time()+3600, "/","", 0);
            Database::disconnect();
            setcookie( "register", "", time()-60, "/","", 0);
            header("Location: UserUploadSignature.php");
        }
        else {
			setcookie( "register", $error, time()+ 3600, "/","", 0);
			header("Location: UserRegister.php");
		}
    }
?>
