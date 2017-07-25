<?php
require 'database.php';

if(!empty($_POST))
{
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE users SET PASSWORD = ? WHERE EMAIL = ?";
$q = $pdo->prepare($sql);
$q->execute(array($_POST['password'],$_COOKIE["email"]));
setcookie( "email", "", time()- 60, "/","", 0);
setcookie( "welcome", "Password changed.", time()+ 3600, "/","", 0);
Database::disconnect();
header("Location: UserNewAccountLogin.php");
}
?>
