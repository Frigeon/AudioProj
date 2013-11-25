<?php 
//define('SALT', 'Hey.This.!5,A,S@LTY #');
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
	
	
	public function createUser($userName, $password, $email)
	{
		$salt = hash('sha512', SALT.$email);
		$password = hash('sha512', $password);
		
		
		$sql = "SELECT userName FROM user WHERE username = :username";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':username'=>$userName));
		$count = $sth->fetchAll();
		
		if(count($count) == 0)
		{
			$sql = "INSERT INTO user (userID, username, password, salt, email) VALUES (null, :userName, :password, :salt, :email)";
			$query = $this->db->prepare($sql);
			$binds = array(":userName"=>(string)$userName,":password"=>(string)$password, ":salt"=>(string)$salt, ":email"=>$email);
			return $query->execute($binds);	
		}
		else
		{
			return false;	
		}
			
	}
	
	public function getUserPass($username, $password)
	{
		$sql ="SELECT password FROM user WHERE userName = :username";
		$query = $this->db->prepare($sql);
		$binds = array(":username"=>$username);
		
		$query->execute($binds);
		$result = $query->fetch();

		if(isset($result['password']))
		{
			if( $result['password']== hash('sha512', $password))
			{
				return true;
			}
			
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
	
	public function getSpeciesFamily()
	{
		$sql = 'SELECT * FROM familyList';
		$query = $this->db->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}
	
	public function getSpeciesList()
	{
		$sql = 'SELECT * FROM speciesList';
		$query = $this->db->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;
	}


}
























