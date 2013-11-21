<?php 

function connect()
{
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=COMP3540_gcoyne', 'gcoyne3540', 'gavin');

		return $dbh;
	    
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}

function insertSegment($dataComments, $sampleRate, $channelCount, $fileID, $curTime, $userID)
{
	
	/*try {
		$dbh = connect();
		$sql = "INSERT INTO 'COMP3540_gcoyne'.'sound_data' ('dataID', 'dataComments', 'sampleRate', 'channelCount', 'fileID', 'curTime', 'userID') VALUES (NULL, :data, :rate, :channels, :file, :time, :userID)";
	   //$sql = ("INSERT INTO sound_data (dataComments, sampleRate, channelCount, fileID, curTime, userID) VALUES ()");
	    $result = $dbh->prepare($sql);
	    $result->execute(array(':data'=>$dataComments, ':rate'=>$sampleRate, ':channels'=>$channelCount, ':file'=>$fileID, ':time'=>$curTime, ':userID'=>$userID));
	    return true;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    return false;
	}*/
    
}

function getSegment($fileID, $curTime, $userID)
{
	try{
	$dbh = connect();
	    $results = $dbh->query'SELCT * FROM sound_segment WHERE fileID="'.$fileID.'" and curTime="'.$curTime.'" and userID ="'.$userID.'"');
	    
	     echo json_encode(array('comments' => $results['dataComments']));
	}catch(PDOException){
		print "Error!: " . $e->getMessage() . "<br/>";
	    return false;
	}
	}
}





	
