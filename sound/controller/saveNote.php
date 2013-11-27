<?php 

if(!isset($_POST['fileName']) || !isset($_POST['userRel']) || !isset($_POST['noteStart']) ||
!isset($_POST['noteEnd']) ||!isset($_POST['userFamilyID']) || !isset($_POST['userSpeciesID']) || !isset($_POST['note']))
{
	echo json_encode(array('errors'=>'Something went wrong'));
	return;
	
}


include '../model/db.php';
session_start();

$con = new DB();
$con->connect();

$fileID = $con->getFileID($_POST['fileName']);
$userID = $con->getUserID($_SESSION['userSalt']);

if($con->insertNote($userID, $fileID,$_POST['userRel'], $_POST['noteStart'], $_POST['noteEnd'], $_POST['note'], $_POST['userFamilyID'], $_POST['userSpeciesID'] ))
	echo json_encode(array('success'=>'Note inserted.'));
return;
