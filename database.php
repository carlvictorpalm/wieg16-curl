<?php
$dbname ="wieg16";
$host ="localhost";
$username ="root";
$password ="root";
$dsn ="mysql:host=$host;dbname=$dbname";
    $options = [
    	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    	PDO::ATTR_EMULATE_PREPARES => false];
    $pdo = new PDO($dsn, $username, $password, $options);

if (isset($_POST["submit"])) {

	$sql= "INSERT INTO `Form`(`name`,`email`,`phone`)
	VALUES (:name, :email, :phone)";
	$stm_insert = $pdo ->prepare($sql);
	$stm_insert->execute(['name'=>$_POST['name'], 'email'=>$_POST['email'], 'phone'=>$_POST['phone']]);
	echo "la till en ny användare";
}
