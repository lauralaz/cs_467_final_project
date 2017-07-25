<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

if(!empty($_POST))
{
	$error = null;
         
    $username = $_POST['username'];
    $name = $_POST['name'];
    $date = null;
    $valid = true;
     
    if (empty($username)) {
        $error = $error.'Please enter Email Address.<br/>';
        $valid = false;
    }
    
    if (empty($name)) {
        $error = $error.'Please enter awardee name.<br/>';
        $valid = false;
    }
     
    if (!checkdate ($_POST["day"],$_POST["month"],$_POST["year"])) {
        $error = $error.'Please enter the date.<br/>';
        $valid = false;
    }else {
		$date = $_POST["year"].'-'.$_POST["month"].'-'.$_POST["day"];
	}
    
    if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select type_id from award_types where full_name = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($_POST['awardType']));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$awardType = $data["type_id"];

		$sql = "INSERT INTO `zhaojing-db`.`awards` (`awards_type`, `owner`, `owner_name`, `who_created`, `creation_time`) VALUES (?,?,?,?,?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($awardType,$username,$name,$_COOKIE["email"],$date));
		Database::disconnect();
		setcookie( "newAward", "", time()- 3600, "/","", 0);
		header("Location: UserAccount.php");
	
	}else {
		setcookie( "newAward", $error, time()+ 3600, "/","", 0);
		header("Location: UserAddAward.php");
	}
}
?>
