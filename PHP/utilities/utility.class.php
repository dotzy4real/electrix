<?php

Class Utility extends Constants{


private $object;
public $result = '';

public $database;

public $site_url;
public $status;
public $error; 
public $recipientEmail;
private $timeout;
private $remembermeTimeout;

public $domain = "http://unlimitedresource.com.ng/electrix";

function __construct(){
	/*
	if ($_SERVER["SERVER_ADDR"] === "::1"){ 
		$this->site_url = "http://localhost:81/1751_tees/";
	} else {
		$this->site_url = "http://localhost:81/1751_tees/";	
	}*/
	$this->error = "error.php";
	$this->recipientEmail = "info@electrix.com";
	$this->timeout = 60*30;
	$this->remembermeTimeout = 60*60*24*30;
}

function sanitize($value)
{	
	$this->database = $this->getObject('db');
	return $value = mysqli_real_escape_string($this->database->returnActiveConnection(), $value);
}

public function createObject($object, $key)
{
	require_once($object.'.class.php');
	$this->objects[$key] = new $object( $this );
}

function apiError($msg)
{
	$data = array();
	$data["error"] = $msg;
	return $data;
}

function errorPage()
{
	$site_url = $this->site_url;
	$inner = 'inner';
	$page = 'error';
	$page_title = "404 Page NOT Found";
	$page_banner = "404banner1.png";
	$this->pagename = "error";
	$site_url = $this->site_url;
	$curr = $this->getDefaultCurrency();
	$wlist = count($this->getWishlistItems());
	$cartBag = $this->printCartItems($curr);
	$cartItems = $this->fetchNumCartItems();
	include_once(FRAMEWORK_PATH.$this->error);
	exit;
}

public function getObject($key)
{
	return $this->objects[$key];
}

function execute($query)
{	
	$this->database = $this->getObject('db');
	try {
		$this->database->executeQuery($query);
	} catch (Exception $e) {
		die (mysqli_error($this->database->returnActiveConnection()));
		$e->getMessage();
	}
	$this->result = $this->database->getRows();
	return $this->result;
}


function querySql($query)
{
	$this->database = $this->getObject('db');
	try {
		$this->database->executeQuery($query);
	} catch (Exception $e) {
		die (mysqli_error($this->database->returnActiveConnection()));
		$e->getMessage();
	}
}


function getAccurateURL($url)
{
	$accurateURL = $url["path"];
	if (isset($url["query"])){
		$accurateURL .= '?'.$url["query"];
	}
	$accurateURL = $this->removeQueryString($accurateURL, "pageNum");
	return $accurateURL;
}

function removeQueryString($url, $varname) 
{
    list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
    parse_str($qspart, $qsvars);
    unset($qsvars[$varname]);
    $newqs = http_build_query($qsvars);
    return $urlpart . '?' . $newqs;
}	


function deleteRecord($referer)
{
	$error = array();	
	$dbtable = $_GET['delete'];
	$id = $_GET['quid'];
	if ($dbtable=='homebanner'){
		$insquery = "select * from homebanner where homebanner_id = '$id'";
		$this->execute($insquery); 
		$result = $this->result;
		$lpic = $result[0]['homebanner_pic'];
		$lpath = "images/homebanners/$lpic";
		unlink($lpath);
		$query = "delete from homebanner where homebanner_id = '$id'";
	} else if ($dbtable=='gallerypages'){
		$query = "delete from gallerypages where gallerypage_id = '$id'";
	}else {
		$error[] = "Dear Admin, the operation requested is not valid";
	}	
	if (count($error)==0){
	try{
		$this->database->executeQuery($query);
	}
	catch (Exception $e) {
		die (mysql_error());
		$e->getMessage();
	}
	header("Location: $referer");
	} else { 
		return $error;
	}
}

function verifyEmail($email)
{
	return preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $email);	
}

function verifyPhone($phone)
{
	//return preg_match("/^[0-9]{7,15}$/", $phone);[\+\d]?
	return preg_match("/^[\+\d]?[0-9]{7,15}$/", $phone);
	//return preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone);
}

function emailExist($email, $userid='')
{
	if (empty($userid))
		$query = "select * from users where email = '$email'";
	else		
		$query = "select * from users where email = '$email' and user_id != $userid";
	$result = $this->execute($query);
	if (count($result) > 0)
		return true;
	else
		return false;
}


function checkLogin($authenticate, $redirect=true)
{	
	if (!isset($_COOKIE['user_session']) && isset($_SESSION['user_id']))
	{
		$authenticate->logout($redirect);
	}
	else if (isset($_COOKIE['user_session']) && ($_COOKIE['rememberme'] == "false"))
		$this->setCookieLogin();
	else if (isset($_COOKIE['user_session']) && ($_COOKIE['rememberme'] == "true"))
		$this->setCookieLoginRememberMe();
}

function setCookieLoginRememberMe($justLogin=false)
{
	setcookie('rememberme', 'true', time()+$this->remembermeTimeout, "/");
	setcookie('user_session', time()+$this->remembermeTimeout, time()+$this->remembermeTimeout, "/");
	if ($justLogin)
	{
		setcookie('userid', $_SESSION["user_id"], time()+$this->remembermeTimeout, "/");
		setcookie('fullname', $_SESSION["full_name"], time()+$this->remembermeTimeout, "/");
		setcookie('useremail', $_SESSION["user_email"], time()+$this->remembermeTimeout, "/");
	}
	else
	{
		setcookie('userid', $_COOKIE["userid"], time()+$this->remembermeTimeout, "/");
		setcookie('fullname', $_COOKIE["fullname"], time()+$this->remembermeTimeout, "/");
		setcookie('useremail', $_COOKIE["useremail"], time()+$this->remembermeTimeout, "/");
		$_SESSION["user_id"] = $_COOKIE["userid"];
		$_SESSION["full_name"] = $_COOKIE["fullname"];
		$_SESSION["user_email"] = $_COOKIE["useremail"];
	}	
	
	if (is_numeric($_SESSION["user_id"]))
	{
		/*
		setcookie('SuperAdmin', $this->validateSuperAdmin($_SESSION["user_id"]), time()+$this->remembermeTimeout, "/");
		if (isset($_COOKIE['SuperAdmin']) && $_COOKIE['SuperAdmin'] && !$justLogin)
			$_SESSION["SuperAdmin"] = $_COOKIE["SuperAdmin"];	

		setcookie('EditorUser', $this->validateEditorUser($_SESSION["user_id"]), time()+$this->remembermeTimeout, "/");
		if (isset($_COOKIE['EditorUser']) && $_COOKIE['EditorUser'] && !$justLogin)
			$_SESSION["EditorUser"] = $_COOKIE["EditorUser"];		*/	
		
		$this->updateUserLastActivity($_SESSION["user_id"]);
	}	
}

function setCookieLogin($justLogin=false)
{	
	setcookie('rememberme', 'false', time()+$this->timeout, "/");
	setcookie('user_session', time()+$this->timeout, time()+$this->timeout, "/");
	if ($justLogin)
	{
		setcookie('userid', $_SESSION["user_id"], time()+$this->timeout, "/");
		setcookie('fullname', $_SESSION["full_name"], time()+$this->timeout, "/");
		setcookie('useremail', $_SESSION["user_email"], time()+$this->timeout, "/");
	}
	else
	{
		setcookie('userid', $_COOKIE["userid"], time()+$this->timeout, "/");
		setcookie('fullname', $_COOKIE["fullname"], time()+$this->timeout, "/");
		setcookie('useremail', $_COOKIE["useremail"], time()+$this->timeout, "/");
		$_SESSION["user_id"] = $_COOKIE["userid"];
		$_SESSION["full_name"] = $_COOKIE["fullname"];
		$_SESSION["user_email"] = $_COOKIE["useremail"];
	}
	
	if (is_numeric($_SESSION["user_id"]))
	{
		/*
		setcookie('SuperAdmin', $this->validateSuperAdmin($_SESSION["user_id"]), time()+$this->timeout, "/");
		if (isset($_COOKIE['SuperAdmin']) && $_COOKIE['SuperAdmin'] && !$justLogin)
			$_SESSION["SuperAdmin"] = $_COOKIE["SuperAdmin"];	
			
		setcookie('EditorUser', $this->validateEditorUser($_SESSION["user_id"]), time()+$this->timeout, "/");
		if (isset($_COOKIE['EditorUser']) && $_COOKIE['EditorUser'] && !$justLogin)
			$_SESSION["EditorUser"] = $_COOKIE["EditorUser"];	*/
		$this->updateUserLastActivity($_SESSION["user_id"]);
	}
}

function getService($service_id)
{
	$query = "select * from services where status = 'active' and service_id = '$service_id'";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
	return $this->result;
}

function getServices($limit="")
{
	$limitQuery = empty($limit) ? "" : " limit $limit";
	$query = "select * from services where status = 'active' order by sort_order $limitQuery"; //print $query; exit;
	$this->execute($query);
	$services = array();
	$i = 0;
	foreach ($this->result as $service)
	{
		$services[] = $service;
		$services[$i]["service_snippet"] = strip_tags(stripslashes(substr($service['service_content'], 0, 80)));
		$services[$i]["service_urltitle"] = $this->urlTitle($service["service_title"]);
		$i++;
	}
	return $services;
	
	return $this->result;
}

function getArmeseServices()
{
	$query = "select * from armese_services where status = 'active' order by sort_order limit 4"; 
	$this->execute($query);
	return $this->result;
}

function getProject($projectId)
{
	$query = "select * from projects where status = 'active' and project_id = '$projectId'";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
	return $this->result;
}

function getHomeAbout($tableName="home_about")
{
	$ordcolumn = $tableName."_id";
	$query = "select * from $tableName order by $ordcolumn limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getArmeseAbout()
{
	$query = "select * from armese_about as a, armese_management_team as b where a.armese_about_management_team_id = b.armese_management_team_id and a.status = 'active' order by armese_about_id limit 1";
	$this->execute($query);
	return $this->result[0];
}

function loadAccomplishment()
{
	$query = "select * from accomplishments order by accomplishment_id limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getProjectSection()
{
	$query = "select * from project_section order by project_section_id limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getProjects()
{
	$query = "select * from projects as a, project_categories as b where a.project_category_id = b.project_category_id and status = 'active' order by sort_order";
	$this->execute($query);
	$projects = array();
	$i = 0;
	foreach ($this->result as $project)
	{
		$projects[] = $project;
		$projects[$i]["project_urltitle"] = $this->urlTitle($project["project_title"]);
		$i++;
	}
	return $projects;
	return $this->result;
}

function getArmeseProjects($limit='')
{
	$limitQuery = "";
	if (!empty($limit))
		$limitQuery = " limit $limit";
	$query = "select * from armese_projects as a, armese_project_categories as b where a.armese_project_category_id = b.armese_project_category_id and a.status = 'active' order by sort_order $limitQuery";
	$this->execute($query);
	return $this->result;
}

function getClientPartners($tableName="client_partners")
{
	$query = "select * from $tableName where status = 'active' order by sort_order";
	$this->execute($query);
	return $this->result;
}

function getArmeseManagementTeam()
{
	$query = "select * from armese_management_team where status = 'active' order by sort_order";
	$this->execute($query);
	return $this->result;
}

function getArmeseCapabilities()
{
	$query = "select * from armese_capabilities where status = 'active' order by sort_order";
	$this->execute($query);
	return $this->result;
}

function getArmeseOpeningHours()
{
	$query = "select * from armese_opening_hours order by sort_order";
	$this->execute($query);
	return $this->result;
}

/* kilowatt engineering */
function getKilowattServices()
{
	$query = "select * from kilowatt_services as a, kilowatt_service_category as b where a.kilowatt_service_category_id = b.kilowatt_service_category_id and a.status = 'active' order by a.sort_order";
	$this->execute($query);
	return $this->result;
}

function getKilowattBenefit()
{
	$query = "select * from kilowatt_benefits limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getKilowattProjects($limit='')
{
	$limitQuery = "";
	if (!empty($limit))
		$limitQuery = " limit $limit";
	$query = "select * from kilowatt_projects as a, kilowatt_service_category as b where a.kilowatt_service_category_id = b.kilowatt_service_category_id and a.status = 'active' order by a.sort_order $limitQuery";
	$this->execute($query);
	return $this->result;
}

function getKilowattHowWeWork()
{
	$query = "select * from kilowatt_work_how where status = 'active' order by status";
	$this->execute($query);
	return $this->result;
}

/* msmsl */

function getMsmslAbout()
{
	$query = "select * from msmsl_about as a, msmsl_management_team as b where a.msmsl_about_management_team_id = b.msmsl_management_team_id and b.status = 'active' order by msmsl_about_id limit 1";
	$this->execute($query);
	return $this->result[0];
}


function getEquipmentSection()
{
	$query = "select * from msmsl_equipments order by msmsl_equipment_id limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getMsmslProjects($limit='')
{
	$limitQuery = "";
	if (!empty($limit))
		$limitQuery = " limit $limit";
	$query = "select * from msmsl_projects as a, msmsl_project_categories as b where a.msmsl_project_category_id = b.msmsl_project_category_id and a.status = 'active' order by sort_order $limitQuery";
	$this->execute($query);
	return $this->result;
}

function getMsmslChooseUsSection()
{
	$query = "select * from msmsl_choose_us order by msmsl_choose_us_id limit 1"; 
	$this->execute($query);
	return $this->result[0];
}

function getMsmslChooseUsItems()
{
	$query = "select * from msmsl_choose_us_items where status = 'active' order by sort_order limit 3"; 
	$this->execute($query);
	return $this->result;
}

function getMsmslMissionEdge()
{
	$query = "select * from msmsl_mission_edge order by msmsl_mission_edge_id limit 1"; 
	$this->execute($query);
	return $this->result[0];
}

/* skyview */

function getSkyviewServices()
{
	$query = "select * from skyview_services where status = 'active' order by sort_order";
	$this->execute($query);
	return $this->result;
}



function getFooterProjects()
{
	$query = "select * from projects where status = 'active' order by sort_order limit 6";
	$this->execute($query);
	return $this->result;
}

function getValues()
{
	$query = "select * from our_values where status = 'active' order by sort_order limit 4";
	$this->execute($query);
	return $this->result;
}

function getFeature()
{
	$query = "select * from features order by feature_id limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getFeatureLists()
{
	$query = "select * from feature_lists where status = 'active' order by sort_order";
	$this->execute($query);
	return $this->result;
}

function getBlog($limit='')
{
	if (!empty($limit))
		$query = "select * from blog as a, blog_categories as b where a.blog_category_id = b.blog_category_id order by blog_id desc limit $limit";
	else
		$query = "select * from blog as a, blog_categories as b where a.blog_category_id = b.blog_category_id order by blog_id desc";
	$this->execute($query);
	$blogs = array();
	$i = 0;
	foreach ($this->result as $blog)
	{
		$blogs[] = $blog;
		$blogs[$i]["blog_urltitle"] = $this->urlTitle($blog['blog_title']);
		$i++;
	}
	return $blogs;
}

function getBlogCount()
{	
	$query = "select count(*) as total from blog";
	$this->execute($query);
	return $this->result[0]['total'];
}

function getBlogId($blogId)
{
	$query = "select * from blog as a, blog_categories as b where a.blog_category_id = b.blog_category_id and a.blog_id = '$blogId'";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
	return $this->result;
}

function getBlogs($startrow, $int)
{
	$query = "select * from blog as a, blog_categories as b where a.blog_category_id = b.blog_category_id order by a.blog_id desc limit $startrow, $int";
	$this->execute($query);
	return $this->result;
}

function getContactInfo($tableName="contact_info")
{
	$tableNameId = $tableName."_id";
	$query = "select * from $tableName order by $tableNameId limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getPage($page)
{
	$page_query = "select * from pages where page_name = '$page'";// print $page_query; exit;
	$this->execute($page_query);
	return $this->result[0];
}

function getEdge()
{
	$query = "select * from our_edge limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getOffer()
{
	$query = "select * from what_we_offer limit 1";
	$this->execute($query);
	return $this->result[0];
}

function getJobVacancySection()
{
	$query = "select * from job_vacancy_section order by job_vacancy_section_id limit 1";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
}

function getAvailableJobVacancies()
{
	$query = "select * from job_vacancies order by job_vacancy_date_posted desc";
	$this->execute($query);
	return $this->result;
}

function sendRequestQuote($firstName, $lastName, $email, $phone, $company, $address, $message)
{
	$query = "insert into request_quote (first_name, last_name, email, phone, company, address, message) values ('$firstName', '$lastName','$email', '$phone', '$company', '$address', '$message')";
	$this->querySql($query);
	$message = "A Quote request was submitted, below are the details:<br/><br/><br/>
	First Name: ".$firstName."<br/><br/>
	Last Name: ".$lastName."<br/><br/>
	Email: ".$email."<br/><br/>
	Phone: ".$phone."<br/><br/>
	Address: ".$address."<br/><br/>
	Message: ".$message."<br/><br/>";
	$toEmail = $this->recipientEmail;
	$this->sendEmail("Request Quote From ".$firstName." ".$lastName, $message, $toEmail, $firstName." ".$lastName, $email);
}

function sendContactMessage($fullName, $email, $phone, $subject, $message)
{
	$message = "A contact message was submitted, below are the details:<br/><br/><br/>
	Full Name: ".$fullName."<br/><br/>
	Email: ".$email."<br/><br/>
	Phone: ".$phone."<br/><br/>
	Subject: ".$subject."<br/><br/>
	Message: ".$message."<br/><br/>";
	$toEmail = $this->recipientEmail;
	$this->sendEmail("A Contact Message Was Submitted From ".$fullName, $message, $toEmail, $fullName, $email);
}

function submitJobPosition($firstName, $lastName, $email, $phone, $position, $coverLetter,$uploadName)
{
	$query = "insert into job_submissions (first_name, last_name, email, phone, position, resume, cover_letter) values ('$firstName', '$lastName','$email', '$phone', '$position', '$uploadName', '$coverLetter')";
	$this->querySql($query);
	$message = "Dear $firstName $lastName, <br/><br/>This is to inform you your job application was successful via our career website. If your qualification closely matches with the position we are looking for, we will contact you.<br/><br/><br/><br/>Electrix Career Team";
	$this->sendEmail("Your Job Application was Submitted Successfully", $message, $email, "Electrix Careers");
}

function getAboutBoardMember()
{
	$query = "select * from board_directors as a, home_about as b where a.board_director_id = b.home_about_board_director_id and a.status = 'active'";
	$this->execute($query);
	$this->result[0]["board_director_urltitle"] = $this->urlTitle($this->result[0]["board_director_name"]);
	return $this->result[0];
}

function getBoardMemberById($boardMemberId)
{
	$query = "select * from board_directors where board_director_id = $boardMemberId and status = 'active'";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
	else
		return $this->result;
}

function fetchBoardMembers()
{
	$query = "select * from board_directors where status = 'active' order by sort_order";
	$this->execute($query);
	$members = array();
	$i = 0;
	foreach ($this->result as $member)
	{
		$members[] = $member;
		$members[$i]["board_director_urltitle"] = $this->urlTitle("$member[board_director_name]");
		$i++;
	}
	return $members;
	return $this->result;
}

function getManagementTeamById($managementTeamId, $tableName="management_team")
{
	$tableNameId = $tableName."_id";
	$query = "select * from $tableName where $tableNameId = $managementTeamId and status = 'active'";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
	else
		return $this->result;
}

function getMissionVision()
{
	$query = "select * from mission_vision";
	$this->execute($query);
	return $this->result[0];
}

function fetchManagementTeam($tableName="management_team")
{
	$query = "select * from $tableName where status = 'active' order by sort_order";
	$this->execute($query);
	if ($tableName == "management_team")
	{
		$members = array();
		$i = 0;
		foreach ($this->result as $member)
		{
			$members[] = $member;
			$members[$i]["management_team_urltitle"] = $this->urlTitle("$member[management_team_name]");
			$i++;
		}
		return $members;
	}
	return $this->result;
}

function updateUserLastActivity($userid)
{
	$time = time();
	$query = "update users set last_activity = '$time' where user_id = '$userid'";
	$this->querySql($query);
}

function getRecoveryDetails($randStr)
{
	$query = "select * from account_recovery where recovery_rand = '$randStr' and status = 'active'"; //print $query; exit;
	$this->execute($query);
	return $this->result;
}

function getUserOrders($userid)
{
	$query = "select distinct a.invoice_number, a.invoice_date, a.pay_status, c.no_of_products, c.item_pay_price, d.* from invoice as a, cart as b, cart_items as c, products as d where a.user_id = $userid and a.cart_id = b.cart_id and b.cart_id = c.cart_id and c.product_id = d.product_id and c.status = 'active' order by a.invoice_date desc";	
	$this->execute($query);
	return $this->result;
}

function getAddressBooks($userid)
{
	$query = "select * from address_book where user_id = $userid";
	$this->execute($query);
	return $this->result;
}

function getAddressBook($addressid)
{	
	$query = "select * from address_book where address_book_id = $addressid";
	$this->execute($query);
	return $this->result;
}

function getUserDetails($userid, $email='')
{
	if (!empty($email))
		$query = "select * from users where email = '$email'";
	else
		$query = "select * from users where user_id = '$userid'";	
	$this->execute($query);
	return $this->result;
}

function getAuthDetails($authstr)
{
	$query = "select a.auth_token, a.token_date, b.* from auth_token as a, users as b where a.user_id = b.user_id and a.auth_token = '$authstr' and a.status = 'active'";
	//print $query; exit;	
	$this->execute($query);
	return $this->result;
}

function getRandomStringUserId($randStr)
{
	$query = "select * from account_recovery where recovery_rand = '$randStr'";	
	$details = $this->execute($query);
	return $details[0]['user_id'];
}

function login($email,$password_hash,$actstatus)
{	
	$query = "select * from users where email = '$email' and password_hash = '$password_hash' and activate_hash = '$actstatus'";	
	$this->execute($query);
	return $this->result;
}

function tokenExpiryTime()
{
	return 1 * 24 * 60 * 60; // 1 day
}

function accountRecoveryExpireTime()
{
	return 24*60*60; // 1 day
}

function loginPage()
{
	$link = $this->site_url."account/login";
	header("Location: $link"); exit;	
}


function getHomeBanners($tableName='homebanners', $limit='')
{
	if($limit==''){
		$query = "select * from $tableName where status = 'active' order by sort_order asc";
	} else {
		$query = "select * from $tableName where status = 'active' order by sort_order asc limit $limit";	
	}
	$this->execute($query);
	return $this->result;
       
}

function getFeaturesCount()
{	
	$query = "select count(*) as total from features where status = 'active'";
	$this->execute($query);
	return $this->result[0]['total'];
}

function getFeatures($startrow, $int)
{
	$query = "select * from features where status = 'active' order by sort_order limit $startrow, $int";
	$this->execute($query);
	return $this->result;
}

function getFeatureNames()
{
	$query = "select * from features where status = 'active' order by sort_order";
	$this->execute($query);
	return $this->result;
}

function getFeatureId($featureId)
{
	$query = "select * from features where feature_id = '$featureId'";
	$this->execute($query);
	return $this->result;
}

function getBlogCommentPerBlog($blogid)
{
	$query = "select b.* from  blog as a, blog_comment as b where a.blog_id = b.blog_id order by added_time desc";
	$this->execute($query);
	return $this->result;
}

function getBlogCategories()
{
	$query = "select * from blog_categories order by sort_order";
	$this->execute($query);
	$categories = array();
	$i = 0;
	foreach ($this->result as $category)
	{
		$categories[] = $category;
		$categories[$i]["blog_category_urltitle"] = $this->urlTitle($category['blog_category_name']);
		$i++;
	}
	return $categories;
}

function getBlogArchives()
{
	$query = "SELECT MONTHName(added_time) as month, YEAR(added_time) as year, count(blog_id) as total FROM `blog` group by MONTH(added_time)  order by month desc limit 15";
	$this->execute($query);
	return $this->result;
}

function getBlogTags($blogId='')
{
	$query = "select * from blog_tags order by sort_order";
	if (!empty($blogId))
		$query = "select a.*, b.* from blog as a, blog_tags as b, blog_tag_map as c where a.blog_id = c.blog_id and b.blog_tag_id = c.blog_tag_id and a.blog_id = '$blogId' order by sort_order"; //print $query; exit;
	$this->execute($query);
	$tags = array();
	$i = 0;
	foreach ($this->result as $tag)
	{
		$tags[] = $tag;
		$tags[$i]["blog_tag_urltitle"] = $this->urlTitle($tag['blog_tag_name']);
		$i++;
	}
	return $tags;
	return $this->result;
}

function getBlogCategory($catId)
{
	$query = "select * from blog_categories where blog_category_id = '$catId'";
	$this->execute($query);
	if (count($this->result) > 0)
		return $this->result[0];
	return $this->result;
}

function getBlogsByCategoryCount($catId)
{
	$query = "select count(*) as total from blog where blog_category_id = '$catId' and status = 'active'";
	$this->execute($query);
	return $this->result[0]['total'];
}

function getBlogsByCategoryId($catId)
{
	$query = "select * from blog as a, blog_categories as b where a.blog_category_id = b.blog_category_id and a.blog_category_id = '$catId' order by a.blog_id desc";
	$this->execute($query);
	return $this->result;
}

function getBlogsByCategory($start, $int, $catId)
{
	$query = "select * from blog as a, blog_categories as b where a.blog_category_id = b.blog_category_id and a.blog_category_id = '$catId' order by a.blog_id desc limit $start, $int";
	$this->execute($query);
	return $this->result;
}

function getBlogArchivesCount($month, $year)
{	
	$query = "select count(*) as total from blog as a, blog_categories as b where MONTHName(added_time) = '$month' and YEAR(added_time) = '$year' and a.blog_category_id = b.blog_category_id";
	$this->execute($query);
	return $this->result[0]['total'];
}

function getBlogArchivesPage($start, $int, $month, $year)
{
	$query = "select MONTHName(added_time) as month, YEAR(added_time) as year, a.*, b.* from blog as a, blog_categories as b where MONTHName(added_time) = '$month' and YEAR(added_time) = '$year' and a.blog_category_id = b.blog_category_id order by a.blog_id desc limit $start, $int";
	$this->execute($query);
	return $this->result;
}

function getBlogTagsCount($tagid)
{	
	$query = "select count(*) as total from blog as a, blog_tags as b, blog_tag_map as c, blog_categories as d where a.blog_id = c.blog_id and b.blog_tag_id = c.blog_tag_id and a.blog_category_id = d.blog_category_id and b.blog_tag_id = '$tagid'";
	$this->execute($query);
	return $this->result[0]['total'];
}

function getBlogTagsPage($start, $int, $tagid)
{	
	$query = "select a.*, b.*, d.* from blog as a, blog_tags as b, blog_tag_map as c, blog_categories as d where a.blog_id = c.blog_id and b.blog_tag_id = c.blog_tag_id and a.blog_category_id = d.blog_category_id and b.blog_tag_id = '$tagid' limit $start, $int";
	$this->execute($query);
	return $this->result;
}

function getBlogTagsId($tagid)
{	
	$query = "select a.*, b.*, d.* from blog as a, blog_tags as b, blog_tag_map as c, blog_categories as d where a.blog_id = c.blog_id and b.blog_tag_id = c.blog_tag_id and a.blog_category_id = d.blog_category_id and b.blog_tag_id = '$tagid'";
	$this->execute($query);
	return $this->result;
}

function getBlogTagById($tagid)
{
	$query = "select * from blog_tags where blog_tag_id = $tagid and status = 'active'";
	$this->execute($query);
	return $this->result[0];
}

function getBlogSearchCount($search)
{
	$query = "select  distinct a.*, b.* from blog as a, blog_categories as b, blog_tags as c, blog_tag_map as d where (a.blog_category_id = b.blog_category_id) and ((blog_title like '%$search%' or blog_content like '%$search%' or blog_category_name like '%$search%') or (a.blog_id = d.blog_id and c.blog_tag_id = d.blog_tag_id and c.blog_tag_name like '%$search%'))";// print $query; exit;
	$this->execute($query);
	return count($this->result);
}

function getBlogSearch($start, $int, $search)
{
	$query = "select distinct a.*, b.* from blog as a, blog_categories as b, blog_tags as c, blog_tag_map as d where (a.blog_category_id = b.blog_category_id) and ((blog_title like '%$search%' or blog_content like '%$search%' or blog_category_name like '%$search%') or (a.blog_id = d.blog_id and c.blog_tag_id = d.blog_tag_id and c.blog_tag_name like '%$search%')) order by a.blog_id desc limit $start, $int";
	$this->execute($query);
	return $this->result;
}

		
function generateRandStr($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
    	   $randstr .= chr($randnum+55);
        }else{
        $randstr .= chr($randnum+61);
      }
   }
   return $randstr;
} 


function getMoneyNumberFormat($amount, $curr)
{
	$amount = number_format($amount, 2);
	return $curr[0]['currency_symbol'].$amount;
}


function insertCartMail($cartid)
{
	$query = "insert into cart_mail values (NULL, $cartid)";
	$this->querySql($query);	
}

function cartMailed($cartid)
{
	$query = "select * from cart_mail where cart_id = '$cartid'";	
	$results = $this->execute($query);
	if (count($results) > 0)
		return true;
	else
		return false;
}


function verifyPasswordIsCorrect($cpassword, $userid)
{
	$password_hash = md5($cpassword);
	$query = "select * from users where password = '$password_hash' and user_id = $userid";
	$result = $this->execute($query);
	if (count($result) > 0)
		return true;
	else
		return false;
}

function getNewsletterSubscriptionTypes()
{
	$query = "select * from newsletter_subscription_type";
	$this->execute($query);
	return $this->result;		
}

function getNewsletterSubType($userid)
{
	$query = "select * from newsletter as a, newsletter_subscription_type as b  where a.subscription_type = b.subscription_type_id and a.user_id = $userid";	
	$this->execute($query);
	return $this->result;
}

function newsletterSubscriberExists($email)
{
	$query = "select * from newsletter where email = '$email'";	
	$result = $this->execute($query);
	if (count($result) > 0)
		return true;
	else
		return false;
}


function sendEmail($subject, $message, $toSendEmail, $fromName, $recipientEmail = ""){
	if (empty($recipientEmail))
		$recipientEmail = $this->recipientEmail;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $fromName <$recipientEmail>" . "\r\n";
    //mail($toSendEmail, $subject, $message, $headers);
    
}

function expiryTime()
{
	return 1*24*60*60; // 1 day
}

function returnAdminDate($time)
{
	return date('m',$time).'/'.date('d',$time).'/'.date('Y',$time);
}

function returnDate($time)
{
	return date('M',$time).' '.date('d',$time).', '.date('Y',$time);
}


function getDefaultCurrency()
{
	$query = "select * from currency where is_default = 'true'";	
	$this->execute($query);
	return $this->result;
}

function getPriceFilterRange()
{
	$query = "select * from price_filter_range";
	$this->execute($query);
	return $this->result[0];
}

/* users */

function getUserProfile($userid)
{
	$query = "select * from users where user_id = '$userid'";	
	$this->execute($query);
	return $this->result;
}


function actstatus($actstatus)
{
	$query = "select * from	users where activate_hash = '$actstatus'";
	$this->execute($query);
	return $this->result;
}

function urlTitle($title)
{
	$ntitle = strtolower(str_replace(" ", "-", $title));
	$ntitle = str_replace("'", "", $ntitle);
	$ntitle = str_replace("?", "", $ntitle);
	$ntitle = str_replace(",", "", $ntitle);
	$ntitle = str_replace("!", "", $ntitle);
	$ntitle = str_replace("@", "", $ntitle);
	$ntitle = str_replace("&", "", $ntitle);
	$ntitle = str_replace("(", "", $ntitle);
	$ntitle = str_replace(")", "", $ntitle);
	$ntitle = str_replace(":", "", $ntitle);
	$ntitle = str_replace("/", "-", $ntitle);
	$ntitle = str_replace("--", "-", $ntitle);
	return $ntitle;
}

function fetchFaqs()
{
	$query = "select * from faqs order by sort_order asc";
	$this->execute($query);
	return $this->result;
}

function isUsernameExist($username)
{
	$query = "select * from agent_sign_up where username = '$username'";
	$this->execute($query);
	if (count($this->result)>0)
		return true;
	else
		return false;
}

function isEmailExist($email)
{
	$query = "select * from agent_sign_up where email = '$email'";
	$this->execute($query);
	if (count($this->result)>0)
		return true;
	else
		return false;
}

function emailExistNewsletter($email)
{
	$query = "select * from newsletter where email = '$email'";
	$this->execute($query);
	if (count($this->result)>0)
		return true;
	else
		return false;
}

function getStates()
{
	$query = "select * from states order by name asc";
	$this->execute($query);
	return $this->result;
}

function getStateById($id)
{
	$query = "select * from states where state_id = $id";
	$this->execute($query);
	return $this->result;
}

function is_valid_email_address($email){

	$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';

	$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';

	$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.'\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';

	$quoted_pair = '\\x5c[\\x00-\\x7f]';

	$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";

	$quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";

	$domain_ref = $atom;

	$sub_domain = "($domain_ref|$domain_literal)";

	$word = "($atom|$quoted_string)";

	$domain = "$sub_domain(\\x2e$sub_domain)*";

	$local_part = "$word(\\x2e$word)*";

	$addr_spec = "$local_part\\x40$domain";

	return preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $email) ? 1 : 0;

}







function destroySession()

{

	$_SESSION = array();

	

	

	session_destroy();

}


}
?>