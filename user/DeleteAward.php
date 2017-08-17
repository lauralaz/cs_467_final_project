<?php
require 'database.php';

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "delete from awards WHERE id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($_GET['id']));
Database::disconnect();
header("Location: UserAccount.php");
?>
