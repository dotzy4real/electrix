<?php

class User{
	
	private $id;
	private $username;
	private $email;
	private $utility;
	private $banned;
	private $admin = 0;
	private $active = 0;
	private $valid = false;
	
	public function __construct(Utility $utility, $id=0, $username='', $password='')
	{	
		$this->utility = $utility;
	/*	$this->utility->database->newConnection($utility->host, $utility->username, $utility->password, $utility->dbname);*/
			
		if( $id == 0 && $username != '' && $password != '' )
		{
			$user = $this->utility->database->sanitizeData($username);
			$pass = $this->utility->database->sanitizeData($password);
			//$user = $this->registry->getObject('db')->sanitizeData( $username );
			$hash = md5( $pass );
			$sql = "SELECT * FROM admin_user WHERE email='$user' AND password_hash='$hash'";
			//echo $sql;
		//	$this->registry->getObject('db')->executeQuery( $sql );
		try{
			$this->utility->database->executeQuery($sql);
		}
		catch (Exception $e){
			die(mysql_error());
		}
			//if( $this->registry->getObject('db')->numRows() == 1 )
			if ($this->utility->database->numRows()==1)
			{ 
				//$datas = $this->registry->getObject('db')->getRows();
				$datas = $this->utility->database->getRows();
				$data = $datas[0];
				
				$this->id = $data['admin_id'];
				$this->username = $data['email'];
				$this->active = $data['active'];
				$this->banned = $data['banned'];
				$this->admin = $data['admin'];
				$this->valid = true;
			}
		}
		elseif( $id > 0 )
		{
			$id = intval( $id );
			$sql = "SELECT * FROM admin_user WHERE admin_id='$id'";
			//$this->registry->getObject('db')->executeQuery( $sql );
			$this->utility->database->executeQuery($sql);
			$datas = $this->utility->database->getRows();
			//if( $this->registry->getObject('db')->numRows() == 1 )
			if ($this->utility->database->numRows() == 1)
			{
				//$datas = $this->registry->getObject('db')->getRows();
				$datas = $this->utility->database->getRows();
				$data = $datas[0];
				$this->id = $data['admin_id'];
				$this->username = $data['email'];
				$this->active = $data['active'];
				$this->banned = $data['banned'];
				$this->admin = $data['admin'];
				$this->valid = true;
			}
		}

	}
	
	public function getUserID()
	{
		return $this->id;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function resetPassword( $password )
	{
		
	}

	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function isActive()
	{
		return ( $this->active == 1 ) ? true : false;
	}
	
	public function isAdmin()
	{
				session_regenerate_id();
		return ( $this->admin == 1 ) ? true : false;
	}
	
	public function assignAdmin()
	{		
		if ($this->admin == 1){ 
			session_start();
			$_SESSION['user'] = 'admin';
			session_regenerate_id();
			setcookie("user", $_SESSION['user'], time()+60*60*24*30, "/");
			//echo $_SESSION['user']; exit;
			header("Location:index.php");
		}
	}
	public function isNewsEditor()
	{
		return ( $this->admin == 2) ? true : false;
	}
	
	public function isBanned()
	{
		return ( $this->banned == 1 ) ? true : false;
	}
	
	public function isValid()
	{
		return $this->valid;
	}
	
}

?>