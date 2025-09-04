<?php
//echo $pagefile; exit;
class accountController{
	
	private $pagetitle;
	private $pagebanner;
	private $pagecontent;
	private $utility;
	private $urlpassed;
	private $database;
	private $authenticate;
	private $site_url;
	private $url;
	private $pgroups;
	private $prop_type_name;
	private $homeAbout;
	private $sndpassed;
	
public function __construct(Utility $utility){
	
	$this->utility = $utility;
	$this->site_url = $utility->site_url;
	require_once ('model/accountModel.php');
	$this->pagefile = "account.php";
	$this->accountModel = new accountModel($utility);
	$this->url = $utility->getObject('url');
	$this->database = $utility->getObject('db');
	$this->authenticate = $utility->getObject('authenticate');
	$this->url->getURLData();	
	$this->urlpassed = $this->url->getURLBit(1); 
	$this->sndpassed = $this->url->getURLBit(2); 
	if (isset($this->urlpassed)){ //print "here?????"; exit;
		if (isset($_SESSION['user_id']))
		{
		switch($this->urlpassed){
			
			case 'dashboard':
			$this->userDashboard();
			break;
			
			case 'register':
			case 'login':
			$this->redirectToDashboard();
			
			case 'editAccount':
			$this->editAccount();
			break;
			
			case 'editAddress':
			$this->editAddress();
			break;
			
			case 'newsletterPreference':
			$this->newsletterPreference();
			break;
			
			case 'addAddressBook':
			$this->addAddressBook();
			break;
			
			case 'changePassword':
			$this->changePassword();
			break;
			
			case 'logout':
			$this->logout();
			break;
			
			default:			
			$this->defaultPage();
			break;			
			
		}	
		} else if($this->urlpassed == 'forgot-password')
			$this->forgotPassword();
		else if ($this->urlpassed == 'change-password')
			$this->changePassword();
		 else  if ($this->urlpassed == 'login' || $this->urlpassed == 'register')
			$this->initPages();
		else if ($this->urlpassed == 'activate')
			$this->activateAccount();
		else if ($this->urlpassed == 'activate-account')
			$this->accountActivate();
		else if($this->urlpassed == 'recovery')
			$this->recovery();
		else
			$this->utility->loginPage();
		
	} else {
		$this->initPages();
	}
	
}


function subscribeEmail()
{	
	if (isset($_POST['nletter_email']))
	{
		$nemail = $this->utility->sanitize($_POST['nletter_email']);
		$nname = $this->utility->sanitize($_POST['nletter_name']);
		$error = "";
		$success = "";
		$data = array();
		if (empty($nemail) || empty($nname))
		{
			$error = "Please fill in all fields";
		}
		
		if (!$this->utility->verifyEmail($nemail) && !empty($nemail))
		{
			$error = "Email address entered is incorrect";
		}
		
		if ($this->utility->newsletterExists($nemail) && !empty($nemail))
		{
			$error = "Email address already exist in our system";
		}
		
		if (empty($error))
		{
			$this->utility->insertNewsletterEmail($nname, $nemail);
			$success = "Newsletter Subscription Successful";
		}
		//var_dump($_POST);
		$data["error"] = $error;
		$data["success"] = $success;
		print json_encode($data); exit;
	}
}



function tokenExpired($token_date)
{
	$token_expiry = time() - $token_date;
	if ($token_expiry > $this->utility->tokenExpiryTime())
		return true;
	else
		return false;
}

function accountActivate()
{
	$authstr = $_POST['authstr']; //print $authstr; exit;
	$uemail = $this->utility->sanitize($_POST['uemail']);
	$upassword = $this->utility->sanitize($_POST['upassword']);
	$this->loginProcess($uemail, $upassword, $authstr);
}

function activateAccount()
{
	$authstr = $this->url->getURLBit(2);
	//print "here"; exit;
	$authdetails = $this->utility->getAuthDetails($authstr);
	if (count($authdetails) < 1 || $this->tokenExpired($authdetails[0]['token_date']))
		$this->utility->errorPage();
	else
	{
		$account_page = true;
		$page_title = "Activate Account";
		$authdetail = $authdetails[0];
		$page = "acivate_account";
		$site_url = $this->site_url;		
		include_once(FRAMEWORK_PATH.$this->pagefile);
		exit;	
	}
}

function initPages()
{
	if (isset($_POST['rfname']))
	{
		$rfname = $this->utility->sanitize($_POST['rfname']);
		$rlname = $this->utility->sanitize($_POST['rlname']);
		$remail = $this->utility->sanitize($_POST['remail']);
		$rphone = $this->utility->sanitize($_POST['rphone']);
		$rpassword = $this->utility->sanitize($_POST['rpassword']);
		$cpassword = $this->utility->sanitize($_POST['cpassword']);
		$error = "";
		$success = "";
		$notification = "";
		$account_type_text = "";
		$allFilled = false;
		
		if (empty($rfname) || empty($rlname) || empty($remail) || empty($rphone) || empty($rpassword) || empty($cpassword))
		{
			$error .= "*Please fill in all fields<br/>";	
		} else {
			$allFilled = true;	
		}
		
		if (!$this->utility->verifyPhone($rphone) && !empty($rphone))
		{
			$error .= "*Phone number entered is not correct<br/>";
		}
		
		if (!$this->utility->verifyEmail($remail) && !empty($remail))
		{
			$error .= "*Emaill address entered is not correct<br/>";	
		}
		
		if ($rpassword != $cpassword)
		{
			$error .= "*Passwords entered do not match<br/>";	
		}
		
		if ($this->utility->emailExist($remail))
		{
			$error .= "*Email already exists on our system<br/>";
		}
		
		if (empty($error))
		{			
			$authstr = $this->accountModel->insertUser($rfname, $rlname, $remail, $rphone, md5($rpassword));
			$activelink = $this->site_url."account/activate/$authstr";
			
			$subject = "Activate your registration on 1751";		
			$message = "Dear $rfname $rlname, <br/><br/>Kindly click on the link below to activate your registration on 1751: <a href='$activelink' target='_blank'>$activelink</a><br/><br/>
			<b>Note:</b> Link expires within the next 48 hours.
			<br/><br/>
			Best Regards,<br/><br/>Sasibi Team";	
			$this->utility->sendEmail($subject, $message, $remail);
			
			
			
			$success = "<span style='color:#0a0'>Your Registration Was Successful, Check Your Email To Activate Your Account</span>";
			$notification = "<span style='color:#0a0'>Registration is Successful. Enter your new login details</span>";
		}
		
		$data = array();
		$data["error"] = "";
		if (!empty($error))
			$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
		$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
		$data["notification"] = $notification;
		print json_encode($data); exit;
		
	} else if (isset($_POST['uemail'])){
		$uemail = $this->utility->sanitize($_POST['uemail']);
		$upassword = $this->utility->sanitize($_POST['upassword']);
		$rememberme = false;
		if (isset($_POST['rememberme']))
			$rememberme = true;
		$this->loginProcess($uemail, $upassword, '', $rememberme);
		
	} else {
		$page = str_replace("-", "_", $this->url->getURLBit(1));
		$query = "select * from pages as a where a.page_name = '$page'";
		
		$results = $this->utility->execute($query);
		$site_url = $this->site_url;
		if (count($results)<1){
			$this->utility->errorPage();
		}
		$this->pagetitle = $results[0]['page_title'];
		$this->pagename = $results[0]['page_name'];
		$inner = 'inner';
		$pageBool = true;
		include_once(FRAMEWORK_PATH.$this->pagefile);
		exit;	
	}
}

function loginProcess($uemail, $upassword, $authstr = '', $rememberme = false)
{
	
		$error = "";
		$success = "";
		$response = "";
		if (empty($uemail) || empty($upassword))
		{
			$error .= "*Please fill in all fields<br/>";
		}
		
		if (empty($error)){
			$users = $this->accountModel->validateUser($uemail, md5($upassword), $authstr);
			if (count($users) > 0)
			{
				if ($users[0]["status"] == 'inactive')
					$error .= "*Your account is currently inactive<br/>";
				else
				{
					//session_start();
					$_SESSION["user_id"] = $users[0]["user_id"];
					$_SESSION["full_name"] = $users[0]["first_name"]." ".$users[0]["last_name"]; //print $_SESSION["full_name"]; exit;
					$_SESSION["user_email"] = $users[0]["email"];
					session_regenerate_id();
					if ($rememberme)
					{
						$_SESSION['rememberme'] = "true";
						$this->utility->setCookieLoginRememberMe(true);
					}
					else
					{
						$_SESSION['rememberme'] = "false";
						$this->utility->setCookieLogin(true);
					}
					$success = "Login Successful";
					if (!empty($authstr))
					{
						$rfname = $users[0]["first_name"];
						$rlname = $users[0]["last_name"];
						$subject = "Your accout is now active on 1751";		
		
						$message = "Hi, 
<br />
<br />

Thanks for coming on board, we look forward to you having a great shopping experience where you cloth based on your expressions, feelings and emotions. Do let us know if there's anything we can assist you with. You can reach us on ask@1751.com.
<br />
<br />


You can refer 1751 to your friends and family and also follow us on all Social Media platforms @1751.
<br />
<br />

Thank you.";
		
						$this->utility->sendEmail($subject, $message, $uemail);
						
						$success = "Account Activated, Login Successful";
						
					}
				}
			} else {
				$error .= "*Either email address or password is incorrect<br/>";
			}
		}
		
		$data = array();
		$data["error"] = "";
		if (!empty($error))
			$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
		$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
		$data["response"] = $response;
		print json_encode($data); exit;
	
}

function recovery()
{
	$page = "change_password";
	$site_url = $this->site_url;
	$randStr = $this->utility->sanitize($this->url->getURLBit(2));
	$recovery_details = $this->utility->getRecoveryDetails($randStr); //var_dump($recovery_details); exit;
	if (count($recovery_details) == 0)
		$this->utility->errorPage();
	else
	{
		$recov_time = $recovery_details[0]['recovery_time'];
		$time = time();
		$recovery_expire_time = $this->utility->accountRecoveryExpireTime();
		if (($time - $recov_time) > $recovery_expire_time)
		{
			$notice = "This recovery link has expired.";
		}
		$account_page = true;
		$page_title = "Change Password";
		include_once(FRAMEWORK_PATH.$this->pagefile);
		exit;	
	}
}

function changePassword()
{
	$data = array();
	$error = "";
	$success = "";
	$npassword = $this->utility->sanitize($_POST['npassword']);
	$cnpassword = $this->utility->sanitize($_POST['cnpassword']);
	$randStr = "";
	if (isset($_SESSION['user_id']))
	{
		$cpassword = $this->utility->sanitize($_POST['cpassword']);
		$userid = $_SESSION['user_id'];
	}
	else
	{
		$randStr = $_POST['randhash'];
		$userid = $this->utility->getRandomStringUserId($randStr);
	}
	
	if (isset($_SESSION['user_id']))
	{
		if (empty($cpassword) || empty($npassword) || empty($cnpassword))
		{
			$error .= "*Please fill in all fields<br/>";	
		}
	
		if (!($this->utility->verifyPasswordIsCorrect($cpassword, $userid)) && !empty($cpassword))
		{
			$error .= "*Your current password entered is not correct<br/>";
		}
	} else {
		if (empty($npassword) || empty($cnpassword))
		{
			$error .= "*Please fill in all fields<br/>";	
		}
	}
	
	if (strlen($npassword) < 6)
	{
		$error .= "*Password minimum lenght must 6 or above<br/>";	
	}
	
	if ($npassword != $cnpassword && (!empty($npassword) && !empty($cnpassword)))
	{
		$error .= "*New passwords entered do not match<br/>";	
	}
	
	if (empty($error))
	{
		$this->accountModel->changePassword($npassword,$userid,$randStr);
		$success = "<span style='color:#0a0'>Your Password Has Been Updated Successful</span>";
	}
	
	$data = array();
	$data["error"] = "";
	if (!empty($error))
		$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
	$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
	print json_encode($data); exit;
}

function forgotPassword()
{
	$site_url = $this->site_url;
	if (isset($_POST['remail']))
	{
		$remail = $this->utility->sanitize($_POST['remail']);
		$data = array();
		$error = "";
		$success = "";
		if (empty($remail))
			$error = "*Please fill in your email address";
			
		if (!$this->utility->verifyEmail($remail) && !empty($remail))
			$error = "*Email address entered is invalid";
			
		if (!$this->utility->emailExist($remail) && !empty($remail))
			$error = "*Email address does not exist on our system";
			
		if (empty($error))
		{
			$userDetails = $this->utility->getUserDetails(0,$remail);
			$userid = $userDetails[0]['user_id'];
			$randStr = $this->utility->generateRandStr(25);
			$this->accountModel->insertRecoverAccount($userid,$randStr,time());
			$subject = "Password Recovery for your 1751 Account";
			$link = $this->utility->site_url."account/recovery/$randStr";
			$message = "To recover your password, kindly click or copy this link and paste on your browser new tab: <a href='$link' target='_blank'>$link</a> Please this link is only valid for the next 24 hours.";
			$success = "<span style='color:#0a0'>Recovery instructions has been sent to your email</span>";
			//$this->utility->sendEmail($subject, $message, $remail);
		}
			
		$data["error"] = "";
		if (!empty($error))
			$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
		$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
		print json_encode($data); exit;
	}
	$page = "forgot_password";
	include_once(FRAMEWORK_PATH.$this->pagefile);
	exit;	
}


function newsletterPreference()
{
	$data = array();
	$error = "";
	$success = "";
	$nletterpref = "";
	if (isset($_POST['nletter']))
		$nletterpref = $_POST['nletter'];	
	$userid = $_SESSION['user_id'];
	$name = $_SESSION['full_name'];
	$userDetails = $this->utility->getUserDetails($userid);
	$userDetail = $userDetails[0];
	if (empty($nletterpref))	
	{
		$error .= "*Please select a newsletter preference";
	}
	
	if (empty($error))
	{
		$this->accountModel->saveNewsletterPreference($nletterpref,$name,$userid,$userDetail['email']);
		$success = "<span style='color:#0a0'>Your Newsletter Preference Has Been Saved</span>";
	}
	$data["error"] = "";
	$data["isEdit"] = true;
	if (!empty($error))
		$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
	$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
	print json_encode($data); exit;
}

function editAccount()
{
	$data = array();
	$error = "";
	$success = "";
	$cfirstname = $this->utility->sanitize($_POST['cfirstname']);
	$clastname = $this->utility->sanitize($_POST['clastname']);
	$cphone = $this->utility->sanitize($_POST['cphone']);
	$userid = $_SESSION['user_id'];
	
	if (empty($cfirstname) || empty($clastname) || empty($cphone))
	{
		$error .= "*Please fill in all fields<br/>";	
	}
		
		
	if (empty($error))
	{			
		$this->accountModel->editAccount($cfirstname, $clastname, $cphone, $userid);
		$success = "<span style='color:#0a0'>Your Account Has Been Updated Successfully</span>";
	}
		
	$data = array();
	$data["error"] = "";
	$data["isEdit"] = true;
	if (!empty($error))
		$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
	$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
	print json_encode($data); exit;
}

function addAddressBook()
{
	$data = array();
	$error = "";
	$success = "";
	$userid = $_SESSION['user_id'];
	$address = $_POST['addressname'];
	$isEdit = false;
	if (isset($_POST['isdefault']))
		$default = $_POST['isdefault'];
	$editId = 0;
	if (isset($_POST['editAddressBookForm']))
	{
		$editId = $_POST['editAddressBookForm'];
	}
	if (empty($address) || !isset($default))
	{
		$error = "*Please fill in all fields in astericks";	
	}
	
	if (empty($error))
	{
		$this->accountModel->addAddressBook($userid,$address,$default,$editId);
		if ($editId > 0)		
		{
			$isEdit = true;
			$success = "<span style='color:#0a0;'>Address Book Has Been Updated Successfully</span>";
		}
		else
			$success = "<span style='color:#0a0;'>Address Book Has Been Added Successfully</span>";
	}
	
	$data["error"] = "";
	$data["isEdit"] = $isEdit;
	if (!empty($error))
		$data["error"] = "<div class='alert alert-danger'>".$error."</div>";
	$data["success"] = "<div class='alert alert-success'><i class='fa fa-check'></i> ".$success."</div>";
	print json_encode($data); exit;
}


function userDashboard()
{
	if (!isset($_SESSION['user_id']))
		$this->utility->loginPage();
	else {
		$user_dashboard = true;
		$page = "orders";
		$sndset = false;
		if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
		{
			$sndset = true;
			$page = $this->utility->urlTitle($this->utility->sanitize($this->sndpassed));
		}
		//print $page; exit;
		if (($page != "orders" && $page != "wishlist" && $page != "address-book" && $page != "add-addressbook" && $page != "edit-addressbook" && $page != "newsletter-preference" && $page != "edit-newsletter-preference" && $page != "account-profile" && $page != "change-password") && $sndset)
			$this->defaultPage();
		$site_url = $this->site_url;
		$userid = $_SESSION["user_id"];
		$userDetails = $this->utility->getUserDetails($userid);
		$user = $userDetails[0];		
		$subtypes = $this->utility->getNewsletterSubType($userid);
		$subscribed = false;
		$newsletter_subject = "You are currently not subscribed to our newsletter";
		if (count($subtypes) > 0)
			$subtype = $subtypes[0];
		if (isset($subtype) && $subtype['subscription_type_identifier'] != 'none')
		{
			$newsletter_subject = $subtype['subscription_type_name'];
			$subscribed = true;
		}
		$nletter_sub_types = $this->utility->getNewsletterSubscriptionTypes();/**/
		$orders = $this->utility->getUserOrders($userid);
		$wishlists = $this->utility->fetchWishlistItems();
		$addressbooks = $this->utility->getAddressBooks($userid);
		
		if(isset($_GET["addid"]))
		{
			$addid = $_GET['addid'];
			if (is_numeric($addid))
			{
				$adds = $this->utility->getAddressBook($addid);
				if (count($adds)> 0 && $_SESSION['user_id'] == $adds[0]['user_id'])
					$add = $adds[0];
				else if ($page == "edit-addressbook")
					$this->defaultPage();
			}
		}
		
		$fullname = $user['first_name'].' '.$user['last_name'];
		include_once(FRAMEWORK_PATH.$this->pagefile);
		exit;	
	}
}

function redirectToDashboard()
{
	header("Location: dashboard");
}


function logout()
{
	$this->authenticate->logout();
}

function display($pagefile)
{
	include_once(FRAMEWORK_PATH.$pagefile);
	exit;
}


function defaultPage()
{
	$this->utility->errorPage();

}



}

?>