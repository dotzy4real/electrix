<?php


class Authenticate {

	/**
	 * The user object
	 */
	private $user;
	
	private $utility;
	
	/**
	 * Boolean variable indicating if user is logged in
	 */
	private $loggedIn = false;
	
	/**
	 * Boolean for the confirmation of authentication
	 */
	 private $authenticated = false;
	
	/**
	 * Indicates if login has just been processed or not
	 */
	private $justProcessed = false;
	
	/**
	 * Authentication constructor
	 */
    public function __construct( Utility $utility ) 
    {
		$this->utility = $utility;
    }
    
    public function checkForAuthentication()
    {
    	    	
    	if( isset( $_SESSION['sn_auth_session_uid'] ) && intval( $_SESSION['sn_auth_session_uid'] ) > 0 )
    	{
			//check for possible session hijacking
			if($_SESSION['sn_auth_USER_AGENT'] === md5($_SERVER['HTTP_USER_AGENT'])){
				$this->sessionAuthenticate( intval( $_SESSION['sn_auth_session_uid'] ) );
				
				if( $this->loggedIn == true )
				{
					$this->authenticated = true;
				
				}else{
					Throw new Exception('You need to login to access the resource you are trying to view');	
				}
			}else{
				//throw new exception for possible session hijacking
				throw new Exception('Possible security threat suspected, Please login again.');
				$this->authenticated = false;
			}
    	}
    	elseif( isset(  $_POST['email'] ) &&  $_POST['email'] != '' && isset( $_POST['password'] ) && $_POST['password'] != '')
    	{
    		$this->postAuthenticate( $_POST['email'] , $_POST['password'] );
    		if( $this->loggedIn == true )
	    	{
	    		$this->authenticated = true;
	    	
	    	}
	    	else
	    	{
	    		throw new Exception('Email or password entered is incorrect');	
	    	}
    	}
    	elseif( isset( $_POST['admin']) )
    	{
    		throw new Exception('Please fill in all fields in astericks');
			$this->authenticated = false;
    	}

    }
    
    private function sessionAuthenticate( $uid )
    {
		require_once(FRAMEWORK_PATH.'utilities/user.class.php');
		    
    	$this->user = new User( $this->utility, intval( $_SESSION['sn_auth_session_uid'] ), '', '' );
    	
    	if( $this->user->isValid() )
    	{
    		if( $this->user->isActive() == false )
    		{
    			$this->loggedIn = false;
    			$this->loginFailureReason = 'inactive';
    		}
    		elseif( $this->user->isBanned() == true )
    		{
    			$this->loggedIn = false;
    			$this->loginFailureReason = 'banned';
    		}
    		else
    		{
    			$this->loggedIn = true;
    		}
    		
    	}
    	else
    	{
    		$this->loggedIn = false;
    		$this->loginFailureReason = 'nouser';
    	}
    	if( $this->loggedIn == false )
    	{
    		$this->logout();
    	}

    }
    
    private function postAuthenticate( $u, $p )
    {
    	$this->justProcessed = true;
		
		require(FRAMEWORK_PATH.'utilities/user.class.php');
		
    	$this->user = new User( $this->utility, 0, $u, $p );
    	
    	if( $this->user->isValid() )
    	{
    		if( $this->user->isActive() == false )
    		{
    			$this->loggedIn = false;
    			$this->loginFailureReason = 'inactive';
    		}
    		elseif( $this->user->isBanned() == true )
    		{
    			$this->loggedIn = false;
    			$this->loginFailureReason = 'banned';
    		}
    		else
    		{
    			$this->loggedIn = true;
				//session_regenerate_id();
    			$_SESSION['sn_auth_session_uid'] = $this->user->getUserID();
				$_SESSION['sn_auth_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
    		}
    		
    	}
    	else
    	{
    		$this->loggedIn = false;
    		$this->loginFailureReason = 'invalidcredentials';
    	}
    }
	
	function isAdmin()
	{
		if (isset($_SESSION['user'])){
			if ($_SESSION['user']=='admin'){
			return true;
			}
		} 
	}
    
    function logout($redirect=true) 
	{
		$_SESSION = array();
		$_SESSION['sn_auth_session_uid'] = '';
		setcookie(session_name(),'',time() - 7800);
		session_destroy();
		$this->loggedIn = false;
		$this->user = null;
    	unset($_COOKIE['userid']); 
    	setcookie('userid', null, -1, '/'); 
    	unset($_COOKIE['fullname']); 
    	setcookie('fullname', null, -1, '/'); 
    	unset($_COOKIE['useremail']); 
    	setcookie('useremail', null, -1, '/'); 
    	unset($_COOKIE['rememberme']); 
    	setcookie('rememberme', null, -1, '/'); 
    	unset($_COOKIE['user_session']); 
    	setcookie('user_session', null, -1, '/');
		if ($redirect)
			header ("Location: ".$this->utility->site_url);		
	}
	
	public function forceLogin( $username, $password )
	{
		$this->postAuthenticate( $username, $password );
	}
    
    public function isLoggedIn()
    {
	    return $this->loggedIn;
    }
    
    public function isJustProcessed()
    {
    	return $this->justProcessed;
    }
    
    public function getUser()
    {
    	return $this->user;
    }
	
	public function isAuthenticated()
    {
    	return $this->authenticated;
    }
    
}
?>