<?php

$fileID = $_POST['fileID'];
$curTime = $_POST['curTime'];
$userID= $_POST['userID'];
$comments = getComments($fileID, $curTime, $userID);


echo json_encode(array('comments' => $comments));


function connect()
{
	try {
		$dbh = new PDO('mysql:host=gavincoyne.db.11745996.hostedresource.com;dbname=gavincoyne', 'gavincoyne', '');
		return $dbh;  
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}

function getComments($fileID, $curTime, $userID)
{
	try{
		$dbh = connect();
		
	    $results = $dbh->prepare("SELECT dataComments FROM sound_data WHERE fileID=:fileID and curTime=:curTime and userID =:userID");
	    $results->execute(array(':fileID'=>$fileID,':curTime'=>$curTime,':userID'=>$userID));
	    $row = $results->fetch();
	   
	     
	     return $row['dataComments'];
	}catch(PDOException $e){
		
		return "Error!: " . $e->getMessage() . "<br/>";
	    
	}
	
}