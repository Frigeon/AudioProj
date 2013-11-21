<?php
	$curTime = $_POST['curTime'];
	$duration = $_POST['Duration'];
	$channels = $_POST['channels'];
	$sampleRate = $_POST['sampleRate'];
	$userID = $_POST['userID'];
	$comments = $_POST['comments'];
	
	
	$msg = insertSegment($comments, $sampleRate, $channels, $duration, $curTime, $userID);

	echo json_encode(array('foo' => $msg));

	
function connect()
{
	try {
		$dbh = new PDO('mysql:host=gavincoyne.db.11745996.hostedresource.com;dbname=gavincoyne', 'gavincoyne', 'Corkey2000!');

		return $dbh;
	    
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}

function insertSegment($dataComments, $sampleRate, $channelCount, $fileID, $curTime, $userID)
{
	
	try {
		$dbh = connect();
		$delete = "DELETE FROM sound_data WHERE fileID=:fileID AND curTime=:curTime AND userID=:userID LIMIT 1";
		$delResult = $dbh->prepare($delete);
		$delResult->execute(array(':fileID'=>$fileID, ':curTime'=>$curTime, ':userID'=>$userID));
		
		$sql = "INSERT INTO sound_data (dataComments, sampleRate, channelCount, fileID, curTime, userID) VALUES (:data, :rate, :channels, :file, :time, :userID)";
	    $result = $dbh->prepare($sql);
	    return $result->execute(array(':data'=>$dataComments, ':rate'=>$sampleRate, ':channels'=>$channelCount, ':file'=>$fileID, ':time'=>$curTime, ':userID'=>$userID));
	    
	} catch (PDOException $e) {
	    return "Error!: " . $e->getMessage() . "<br/>";
	     
	}
    
}







	
	