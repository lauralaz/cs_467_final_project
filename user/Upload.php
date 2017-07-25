<?php
require 'database.php';

if(isset($_POST['upload']) && $_FILES['file']['size'] > 0)
{
$file = rand(1000,100000)."-".$_FILES['file']['name'];
$file_loc = $_FILES['file']['tmp_name'];
$destination_path = getcwd().DIRECTORY_SEPARATOR;
$destination_path = $destination_path."images/";
$target_path = $destination_path.basename($file);
move_uploaded_file($file_loc,$target_path);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE users SET PHOTO = ? WHERE EMAIL = ?";
$q = $pdo->prepare($sql);
$q->execute(array($file,$_COOKIE["email"]));
setcookie( "email", "", time()- 60, "/","", 0);
setcookie( "welcome", "Registration successful.", time()+ 3600, "/","", 0);
Database::disconnect();
header("Location: UserNewAccountLogin.php");
}
?>
