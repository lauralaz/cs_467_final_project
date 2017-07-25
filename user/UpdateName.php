<?php
require 'database.php';

if(!empty($_POST))
{
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE users SET user_name = ? ,  user_last_name = ? WHERE EMAIL = ?";
$q = $pdo->prepare($sql);
$q->execute(array($_POST['firstname'],$_POST['lastname'],$_COOKIE["email"]));
Database::disconnect();
header("Location: UserAccount.php");
}
?>
