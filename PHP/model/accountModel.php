<?php
class accountModel extends Utility{
	
	private $utility;
	public function __construct(Utility $utility)
	{
		$this->utility = $utility;
	}
	
	
	public function insertUser($rfname, $rlname, $remail, $rphone, $rpassword)
	{
		$query = "insert into users values (NULL, '$rfname', '$rlname', '$remail', '$rphone', '$rpassword', 'inactive')";
		$this->utility->querySql($query);
		
		$query = "select * from users where email = '$remail'";
		$userdetails = $this->utility->execute($query);
		$userid = $userdetails[0]['user_id'];
		
		/*
		$query = "insert into address_book values (NULL,$userid,'$raddress','active')";
		$this->utility->querySql($query);*/
		
		$authstr = $this->utility->generateRandStr(10);
		$time = time();
		$query = "insert into auth_token values (NULL, '$userid', '$authstr', $time,'active')";
		$this->utility->querySql($query);
		return $authstr;
	}
	
	public function validateUser($uemail, $upassword_hash, $authstr)
	{
		if (!empty($authstr))
			$aquery = "select a.*, b.auth_token from users as a, auth_token as b where a.email = '$uemail' and a.password = '$upassword_hash' and b.user_id = a.user_id and b.auth_token = '$authstr'";
		else
			$aquery = "select * from users as a where a.email = '$uemail' and a.password = '$upassword_hash'";
		$acctdetails = $this->utility->execute($aquery);
		
		if (count($acctdetails) > 0 && !empty($authstr))
		{
			$acctdetail = $acctdetails[0];
			$query = "update users set status = 'active' where user_id = $acctdetail[user_id]";
			$this->utility->querySql($query);
			$query = "update auth_token set status = 'inactive' where auth_token = '$authstr'";
			$this->utility->querySql($query);
			$acctdetails = $this->utility->execute($aquery);
		}
		return $acctdetails;
	}
	
	public function validateAdmin($uemail, $upassword_hash)
	{
		$query = "select * from admin_user where email = '$uemail' and password = '$upassword_hash'";
		$acctdetails = $this->utility->execute($query);
		return $acctdetails;
	}
	
	public function addAddressBook($userid, $address, $default, $editId)
	{
		
		if ($default == 'yes')
		{
			$query = "update address_book set is_default = 'inactive'";	
			$this->utility->querySql($query);
			if ($editId > 0)
				$query = "update address_book set residential_address = '$address', is_default = 'active' where address_book_id = $editId";
			else
				$query = "insert into address_book values (NULL, $userid, '$address', 'active')";
			//$this->utility->querySql($query);
			//$query = "update users set residential_address = '$address' where user_id = $userid";
		} else {
			if ($editId > 0)
				$query = "update address_book set residential_address = '$address', is_default = 'inactive' where address_book_id = $editId";
			else
				$query = "insert into address_book values (NULL, $userid, '$address', 'inactive')";
		}
		//print $query; exit;
		$this->utility->querySql($query);
	}
	
	public function editAccount($cfirstname, $clastname, $cphone, $userid)
	{
		$query = "update users set first_name = '$cfirstname', last_name = '$clastname', phone = '$cphone' where user_id = $userid";
		$this->utility->querySql($query);
	}
	
	public function insertRecoverAccount($userid, $randStr, $time)
	{
		$query = "select * from account_recovery where user_id = '$userid'";
		$outdatedRecovers = $this->utility->execute($query);
		if (count($outdatedRecovers) > 0)
		{
			foreach ($outdatedRecovers as $outdatedRecover)
			{
				$query = "update account_recovery set status = 'inactive' where account_recovery_id = $outdatedRecover[account_recovery_id] and recovery_rand = '$outdatedRecover[recovery_rand]'";
				$this->utility->querySql($query);
			}
		}
		$query = "insert into account_recovery values (NULL, $userid, '$randStr', $time, 'active')";
		$this->utility->querySql($query);
	}
	
	public function editAddress($cfname, $clname, $cemail, $cphone, $caddress, $userid)
	{
		$query = "update users set first_name = '$cfname', last_name = '$clname', email = '$cemail', phone = '$cphone', residential_address = '$caddress' where user_id = '$userid'";
		$this->utility->querySql($query);
		
		$query = "update address_book set residential_address = '$caddress' where user_id = $userid and is_default = 'active'";
		$this->utility->querySql($query);
	}
	
	public function changePassword($npassword, $userid,$randStr)
	{
		$query = "select * from account_recovery where user_id = '$userid' and recovery_rand = '$randStr' and status = 'active'";
		$outdatedRecovers = $this->utility->execute($query);
		if (count($outdatedRecovers) > 0)
		{
			$outdatedRecover = $outdatedRecovers[0];
			$query = "update account_recovery set status = 'inactive' where account_recovery_id = $outdatedRecover[account_recovery_id] and recovery_rand = '$outdatedRecover[recovery_rand]'";
			$this->utility->querySql($query);
		}
		$hash_password = md5($npassword);
		$query = "update users set password = '$hash_password', status = 'active' where user_id = $userid";	
		$this->utility->querySql($query);
	}
	
	public function saveNewsletterPreference($nletterpref, $name, $userid, $email)
	{
		$query = "select * from newsletter where user_id = $userid or (email = '$email' and user_id = 0)";	
		$results = $this->utility->execute($query);
		if(count($results) > 0)
		{
			$result = $results[0];	
			$nid = $result['newsletter_id'];
			$query = "update newsletter set subscription_type = $nletterpref, user_id = $userid, name = '$name' where newsletter_id = $nid";
		} else {
			$query = "insert into newsletter values (NULL, '$name', '$email', $nletterpref, $userid)";	
		}
		$this->utility->querySql($query);
	}
	
	public function subscribeNewsletter($email)
	{
		$query = "insert into newsletter values (NULL, '', '$email', 3, 0)";
		$this->utility->querySql($query);
	}
}



?>