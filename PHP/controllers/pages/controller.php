<?php
//echo $pagefile; exit;
class pagesController{
	
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
	
public function __construct(Utility $utility){
	
	$this->utility = $utility;
	$this->site_url = $utility->site_url;
	$this->url = $utility->getObject('url');
	//$this->homeAbout = $utility->getHomeAbout();
	$this->database = $utility->getObject('db');
	$this->authenticate = $utility->getObject('authenticate');
	$this->url->getURLData();	
	$this->urlpassed = $this->url->getURLBit(1); 
	//print $this->urlpassed; exit;
	if (isset($this->urlpassed) && $this->urlpassed !== 0){
		
		switch($this->urlpassed){
			
			case 'logout':
			$this->logout();
			break;
			
			case 'subscribe-email':
			$this->subscribeEmail();
			break;
			
			default:
			$this->initPages();
			break;			
			
		}	
		
	} else {
		$this->defaultPage();
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


function initPages()
{
	$this->pagefile = "pages.php";
	$page = $this->url->getURLBit(1);
	$query = "select * from pages where page_name = '$page'"; //print $query; exit;
	$results = $this->utility->execute($query);
	if (count($results)<1){
		$this->utility->errorPage();
	}
	$this->pagetitle = $results[0]['page_title'];
	$this->pagename = $results[0]['page_name'];
	$this->pagecontent = $results[0]['page_content'];
	$this->pagebanner = $results[0]['page_banner'];
	$about_side = $this->utility->getAboutUsSidePic();
	$inner = 'details';
	$pageBool = true;
	$contentPage = true;
	$site_url = $this->site_url;
	unset($params); //print $params['fname']; exit;
	
	include_once(FRAMEWORK_PATH.$this->pagefile);
	exit;
	
	
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