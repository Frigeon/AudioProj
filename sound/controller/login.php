<?php

include '../model/db.php';
$salt = "Loggin S@latz!";
$con = new DB();
$con->connect();

if(!isset($_POST['password']) || !isset($_POST['username']))
{
	echo json_encode(array("errors"=>"Something went wrong."));
	return;
}
$password = $_POST['password'];
$username = $_POST['username'];

if($con->getUserPass($username, $password))
{
	session_start();
	$_SESSION['userSession'] = hash('sha512', $username.$salt);

	echo json_encode(array("sucess"=>"Logged In"));
}
else 
{
	echo json_encode(array("errors"=>"Something went wrong."));
}