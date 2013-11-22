<?php 

class DB{
	public $db;
	

	public function connect()
	{
		
		try {
			
			$this->db =  new PDO('mysql:host=birdeSounds.db.11745996.hostedresource.com;dbname=birdeSounds', 'birdeSounds', 'Bird1Sounds!');
			
		}catch(PDOException $e) {
			var_dump($e->getMessage());
		}
		
	}
	
	public function selectAll($table)
	{
		try {
			$sql = "SELECT * FROM $table";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		
		}catch(PDOException $e) {
			echo  $e->getMessage();
		}
	}
	
	public function insert($userName, $password, $salt)
	{
		$sql = "SELECT userName FROM user WHERE userName = :username";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':username'=>$userName));
		$count = $sth->fetchAll();
		
		if(count($count) == 0)
		{
			$sql = "INSERT INTO user (userID, userName, password, salt) VALUES (null, :userName, :password, :salt)";
			$query = $this->db->prepare($sql);
			$binds = array(":userName"=>(string)$userName,":password"=>(string)$password, ":salt"=>(string)$salt);
			return $query->execute($binds);	
		}
		else
		{
			return false;	
		}
			
	}
	
	public function getUserPass($username)
	{
		$sql ="SELECT password FROM user WHERE userName = :username";
		$query = $this->db->prepare($sql);
		$binds = array(":username"=>$username);
		
		$query->execute($binds);
		$result = $query->fetch();
		
		if(isset($result['password']))
		{
			return $result['password'];
		}
		
		return false;
	}
	
	public function getUserSalt($username)
	{
		$sql ="SELECT salt FROM user WHERE userName = :username";
		$query = $this->db->prepare($sql);
		$binds = array(":username"=>$username);
		
		$query->execute($binds);
		$result = $query->fetch();
		
		if(isset($result['salt']))
		{
			return $result['salt'];
		}
		
		return false;
	}
	
	public function getUserID($userSalt)
	{
		$sql = 'SELECT userID FROM user WHERE salt = :salt';
		$query = $this->db->prepare($sql);
		
		$query->execute(array(':salt'=> $userSalt));
		$result = $query->fetch();
		return $result['userID'];
	}
	
	
	
	public function getRulesByUsername($userSalt)
	{
		$userID = $this->getUserID($userSalt);
		
		$sets = $this->getRuleSetsByUserID($userID);
		
		$setsArr = array();
		
		
		foreach($sets AS $set)
		{
			$sql = "SELECT * FROM rules where ruleSetID = :ruleSetID AND userID = :userID";
			$query = $this->db->prepare($sql);
			$query->execute(array(':ruleSetID'=> $set['setID'], ':userID'=>$userID));
			
			
			$setsArr[$set['setName']] =  $query->fetchAll();;
		}
		
		
		
		return $setsArr;
		
	}
	
	public function getRuleSetsByUserID($userID)
	{
		$sql = "SELECT * FROM ruleSets WHERE userID = :userID";
		$query = $this->db->prepare($sql);
		$query->execute(array(':userID'=> $userID));
		
		return $query->fetchAll();
	}
	
public function getSetIDByName($setName, $userId)
{
		$sql = "SELECT setID
				FROM ruleSets
				WHERE userid =:userId
				AND setName =  :setName
				LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(array(':userId'=>$userId, ':setName'=>$setName));
		$count = $query->fetch();
		return $count['setID'];
}

/**
 * 
 * Add a rule to the DB
 * @param unknown_type $setName
 * @param unknown_type $userId
 * @param unknown_type $ruleName
 * @param unknown_type $description
 */
public function addRule($setName, $userId, $ruleName, $description)
	{
		$sql = "SELECT *
				FROM rules
				WHERE userid =:userId
				AND ruleSetName =  :setName
				AND ruleName = :ruleName
				LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(array(':userId'=>$userId, ':setName'=>(String)$setName, ':ruleName'=>(String)$ruleName));
		$count = $query->fetchAll();
		
		//var_dump($setName, $userId, $ruleName, $count);
		//GEt the setID to associate with
		$setID = $this->getSetIDByName($setName, $userId);
		
		if(count($count) == 0)
		{
			
			$sql = "INSERT INTO rules 
					(ruleId, ruleName, RuleDescription, ruleSetID, ruleSetName, UserID) 
					VALUES (null, :ruleName, :RuleDescription, :ruleSetID, :ruleSetName, :UserID)";
			$query = $this->db->prepare($sql);
			//Set the binds array;
			$binds = array(
				":ruleName"=>$ruleName, 
				":RuleDescription"=>$description, 
				":ruleSetID"=>$setID,
			 ":ruleSetName"=>$setName,
			 ":UserID"=>$userId);
			
			return $query->execute($binds);	
		}
		else
		{
			
			return false;	
		}
	}
	/**
	 * 
	 * Add A new Rule Set Id for a user
	 * @param String $setName
	 * @param Integer $userId
	 */
	public function addSet($setName, $userId)
	{
		$sql = "SELECT setName
				FROM ruleSets
				WHERE userid =:userId
				AND setName =  :setName
				LIMIT 1";
		$query = $this->db->prepare($sql);
		$query->execute(array(':userId'=>$userId, ':setName'=>$setName));
		$count = $query->fetchAll();

		if(count($count) == 0)
		{
			
			$sql = "INSERT INTO ruleSets (setID, userID, setName) VALUES (null, :userID, :setName)";
			$query = $this->db->prepare($sql);
			$binds = array(":userID"=>$userId,":setName"=>(string)$setName);
			return $query->execute($binds);	
		}
		else
		{
			
			return false;	
		}
	}
	
	
	public function removeSet($setName, $userId)
	{
		$sql = "DELETE FROM ruleSets
				WHERE userID=:userID
					AND setName=:setName
				LIMIT 1";
		$query = $this->db->prepare($sql);
		$binds = array(":userID"=>$userId,":setName"=>(string)$setName);
		return $query->execute($binds);
	}
	
	public function removeRule($setName, $userId, $ruleName)
	{
		$sql = "DELETE FROM rules
				WHERE UserID=:userID
					AND ruleSetName=:setName
					AND ruleName=:ruleName
				LIMIT 1";
		$query = $this->db->prepare($sql);
		$binds = array(":userID"=>$userId,":setName"=>(string)$setName, ":ruleName"=>(string)$ruleName);
		return $query->execute($binds);
	}
}
























