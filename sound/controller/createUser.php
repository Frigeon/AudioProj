<?php

include '../model/db.php';

$con = new DB();
$con->connect();

if(!isset($_POST['password']) || !isset($_POST['username']) || !isset($_POST['email']))
{
	echo json_encode(array("errors"=>"Something went wrong."));
	return;
}
$password = $_POST['password'];
$username = $_POST['username'];
$email = $_POST['email'];

if($con->createUser($username, $password, $email))
{
	echo json_encode(array("sucess"=>"test!"));
}
else 
{
	echo json_encode(array("errors"=>"Something went wrong."));
}