<?php

class electrixController{
	
	private $utility;
	private $urlpassed;
	private $database;
	private $site_url;
	private $sndpassed;
	private $npage;
	private $paginate;
	private $cpage;
	private $metaKeys;
	private $relateUrl;
	
public function __construct(Utility $utility){
	
	$this->npage = "pageNum";
	$this->utility = $utility;
	$this->site_url = $utility->site_url;
	$this->url = $utility->getObject('url');
	$this->database = $utility->getObject('db');
	$this->paginate = $utility->getObject('paginate');
	$this->url->getURLData();	
	$this->urlpassed = $this->url->getURLBit(1); 
	$this->sndpassed = $this->url->getURLBit(2);
	$this->cpage = $this->paginate->pagenum($this->npage);
	$this->prodCount = 4;
	$this->productCount = 15;
	$this->curLink = parse_url($_SERVER['REQUEST_URI']);
	$this->fullPath = $this->utility->getAccurateURL($this->curLink);
	$urlSplit = explode('?',$this->fullPath);
	$this->relateUrl = $urlSplit[0];
	
	
	//print $this->urlpassed; exit;
	
	if (isset($this->urlpassed) && $this->urlpassed != '0' && $this->urlpassed != ''){
		switch($this->urlpassed){	
			case 'gethomebanners':
			$this->homeBanners();
			break;
			
			case 'getHomeServices':
			$this->getHomeServices();
			break;
			
			case 'getHomeAbout':
			$this->getHomeAbout();
			break;
			
			case 'getAccomplishment':
			$this->loadAccomplishment();
			break;
			
			case 'getProjectSection':
			$this->getProjectSection();
			break;
			
			case 'getProjects':
			$this->getProjects();
			break;
			
			case 'getOurValues':
			$this->getOurValues();
			break;
			
			case 'getFeature':
			$this->getFeature();
			break;
			
			case 'getFeatureLists':
			$this->getFeatureLists();
			break;
			
			case 'getBlogs':
			$this->getBlogs();
			break;
			
			case 'getBlog':
			$this->getBlog();
			break;
			
			case 'fetchBlogs':
			$this->fetchBlogs();
			break;
			
			case 'blogCategories':
			$this->blogCategories();
			break;
			
			case 'blogTags':
			$this->blogTags();
			break;
			
			case 'getBlogTag':
			$this->getBlogTag();
			break;

			case 'getBlogTagByBlogId':
			$this->blogTagsByBlogId();
			break;
			
			case 'getBlogCategory':
			$this->getBlogCategory();
			break;
			
			case 'blogCategory':
			$this->blogCategory();
			break;
			
			case 'recentBlogPosts':
			$this->recentBlogPosts();
			break;
			
			case 'getContactInfo':
			$this->getContactInfo();
			break;
			
			case 'getFooterProjects':
			$this->getFooterProjects();
			break;
			
			case 'getPage':
			$this->getPage();
			break;
			
			case 'ourEdge':
			$this->ourEdge();
			break;
			
			case 'ourOffer':
			$this->ourOffer();
			break;
			
			case 'getAboutBoardMember':
			$this->getAboutBoardMember();
			break;
			
			case 'getBoardMember':
			$this->getBoardMember();
			break;
			
			case 'fetchBoardMembers':
			$this->fetchBoardMembers();
			break;
			
			case 'getManagementTeam':
			$this->getManagementTeam();
			break;
			
			case 'fetchManagementTeam':
			$this->fetchManagementTeam();
			break;
			
			case 'getMissionVision':
			$this->getMissionVision();
			break;
			
			case 'fetchServices':
			$this->fetchServices();
			break;
			
			case 'getService':
			$this->getService();
			break;
			
			case 'getProject':
			$this->getProject();
			break;
			
			case 'getJobVacancySection':
			$this->getJobVacancySection();
			break;
			
			case 'getAvailableJobVacancies':
			$this->getAvailableJobVacancies();
			break;
			
			case 'submitJobPosition':
			$this->submitJobPosition();
			break;
			
			case 'sendRequestQuote':
			$this->sendRequestQuote();
			break;
			
			case 'sendContactMessage':
			$this->sendContactMessage();
			break;
			
			default:
			print $this->urlpassed; exit;
			$this->loadShop();
			break;
		
		}
	} else {
		$this->loadShop();
	}
		
}

function homeBanners()
{		
	$homeBanners = $this->utility->getHomeBanners();
	print json_encode($homeBanners); exit;
}

function getHomeServices()
{
	$homeServices = $this->utility->getServices(3);
	print json_encode($homeServices); exit;
}

function getHomeAbout()
{
	$homeAbout = $this->utility->getHomeAbout();
	print json_encode($homeAbout); exit;
}

function sendRequestQuote()
{

	$data = array();
	$data["error"] = "";
	$data["success"] = "";
	try
	{
		$firstName = $this->utility->sanitize(ucwords($_POST["first_name"]));
		$lastName = $this->utility->sanitize(ucwords($_POST["last_name"]));
		$email = $this->utility->sanitize($_POST["email"]);
		$phone = $this->utility->sanitize($_POST["phone"]);
		$company = $this->utility->sanitize($_POST["company"]);
		$address = $this->utility->sanitize($_POST["address"]);
		$message = $this->utility->sanitize($_POST["message"]);
		$this->utility->sendRequestQuote($firstName, $lastName, $email, $phone, $company, $address, $message);
		$data["success"] = "Form submission successful";
		$data["statusMessage"] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fa fa-check'></i> Your Quote Request Was Sent Successfully</button></div>";
	} catch (Exception $ex)
	{
		$data["error"] = $ex->getMessage();
		$data["statusMessage"] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Their was en error submitting your quote request</div>";
	}

	print json_encode($data); exit;
}

function sendContactMessage()
{

	$data = array();
	$data["error"] = "";
	$data["success"] = "";
	try
	{
		$fullName = $_POST["full_name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$subject = $_POST["subject"];
		$message = $_POST["message"];
		$this->utility->sendContactMessage($fullName, $email, $phone, $subject, $message);
		$data["success"] = "Form submission successful";
		$data["statusMessage"] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fa fa-check'></i> Your Message Was Sent Successfully</button></div>";
	} catch (Exception $ex)
	{
		$data["error"] = $ex->getMessage();
		$data["statusMessage"] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Their was en error submitting your message</div>";
	}

	print json_encode($data); exit;
}

function submitJobPosition()
{

	$data = array();
	$data["error"] = "";
	$data["success"] = "";
	try
	{
		$firstName = $_POST["first_name"];
		$lastName = $_POST["last_name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$position = $_POST["position"];
		$coverLetter = $_POST["cover_letter"];
		$fileNameExt = $_FILES['resume']['name'];
		$fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
		$filetype = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
		$time = time();
		$uploadName = $fileName."_".$time.".".$filetype;
		$uploadPath = "../src/assets/docs/resume/".$uploadName;
		move_uploaded_file($_FILES['resume']['tmp_name'],$uploadPath);
		$this->utility->submitJobPosition($firstName, $lastName, $email, $phone, $position, $coverLetter,$uploadName);
		$data["success"] = "Form submission successful";
		$data["statusMessage"] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fa fa-check'></i> Your Job Application Was Successful</button></div>";
	} catch (Exception $ex)
	{
		$data["error"] = $ex->getMessage();
		$data["statusMessage"] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Their was en error submitting your application</div>";
	}

	print json_encode($data); exit;
}

function loadAccomplishment()
{
	$accomplishments = $this->utility->loadAccomplishment();
	print json_encode($accomplishments); exit;
}

function getProjectSection()
{
	$projectSection = $this->utility->getProjectSection();
	print json_encode($projectSection); exit;
}

function getProjects()
{
	$projects = $this->utility->getProjects();
	print json_encode($projects); exit;
}

function getOurValues()
{
	$ourValues = $this->utility->getValues();
	print json_encode($ourValues); exit;
}

function getFeature()
{
	$feature = $this->utility->getFeature();
	print json_encode($feature); exit;
}

function getFeatureLists()
{
	$features = $this->utility->getFeatureLists();
	print json_encode($features); exit;
}

function getContactInfo()
{
	$contactInfo = $this->utility->getContactInfo();
	print json_encode($contactInfo); exit;
}

function getBlogs()
{
	$blogs = $this->utility->getBlog(3);
	print json_encode($blogs); exit;
}

function getBlog()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$blogId = $this->sndpassed;
		$blog = $this->utility->getBlogId($blogId);
		print json_encode($blog); exit;
	}
}

function fetchBlogs()
{
	$blogs = $this->utility->getBlog();
	print json_encode($blogs); exit;
}

function blogCategories()
{
	$categories = $this->utility->getBlogCategories();
	print json_encode($categories); exit;
}

function getBlogTag()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$blogTagId = $this->utility->sanitize($this->sndpassed);
		$blogsTag = $this->utility->getBlogTagsId($blogTagId);
		print json_encode($blogsTag); exit;
	} 
}

function blogCategory()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$blogCategoryId = $this->utility->sanitize($this->sndpassed);
		$blogsCategory = $this->utility->getBlogCategory($blogCategoryId);
		print json_encode($blogsCategory); exit;
	} 
}

function getBlogCategory()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$blogCategoryId = $this->utility->sanitize($this->sndpassed);
		$blogsCategory = $this->utility->getBlogsByCategoryId($blogCategoryId);
		print json_encode($blogsCategory); exit;
	} 
}

function blogTagsByBlogId()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$blogId = $this->utility->sanitize($this->sndpassed);
		$tags = $this->utility->getBlogTags($blogId);
		print json_encode($tags); exit;
	}
}

function blogTags()
{
	$tags = $this->utility->getBlogTags();
	print json_encode($tags); exit;
}

function recentBlogPosts()
{
	$blogs = $this->utility->getBlog(5);
	print json_encode($blogs); exit;
}

function getFooterProjects()
{
	$projects = $this->utility->getFooterProjects();
	print json_encode($projects); exit;
}

function getPage()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$pname = $this->utility->sanitize($this->sndpassed);
		$page = $this->utility->getPage($pname);
		print json_encode($page); exit;
	} else
	{
		$error = $this->utility->apiError("Page does not exist");
		print json_encode($error); exit;
	}
}

function getJobVacancySection()
{
	$jobVacancies = $this->utility->getJobVacancySection();
	print json_encode($jobVacancies); exit;
}

function getAvailableJobVacancies()
{
	$jobVacancies = $this->utility->getAvailableJobVacancies();
	print json_encode($jobVacancies); exit;
}

function ourEdge()
{
	$edge = $this->utility->getEdge();
	print json_encode($edge); exit;
}

function ourOffer()
{
	$offer = $this->utility->getOffer();
	print json_encode($offer); exit;
}

function getAboutBoardMember()
{	
	$boardMember = $this->utility->getAboutBoardMember();
	print json_encode($boardMember); exit;
}

function getBoardMember()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$boardId = $this->utility->sanitize($this->sndpassed);
		$boardMember = $this->utility->getBoardMemberById($boardId);
		print json_encode($boardMember); exit;
	} 
}

function fetchBoardMembers()
{
	$boardMembers = $this->utility->fetchBoardMembers();
	print json_encode($boardMembers); exit;
}

function getManagementTeam()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$managementId = $this->utility->sanitize($this->sndpassed);
		$managementTeam = $this->utility->getManagementTeamById($managementId);
		print json_encode($managementTeam); exit;
	} 
}

function fetchManagementTeam()
{
	$managementTeams = $this->utility->fetchManagementTeam();
	print json_encode($managementTeams); exit;
}

function getMissionVision()
{
	$missionVision = $this->utility->getMissionVision();
	print json_encode($missionVision); exit;
}

function fetchServices()
{
	$services = $this->utility->getServices();
	print json_encode($services); exit;
}

function getService()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$serviceId = $this->utility->sanitize($this->sndpassed);
		$service = $this->utility->getService($serviceId);
		print json_encode($service); exit;
	}
}

function getProject()
{
	if (isset($this->sndpassed) && $this->sndpassed != '0' && $this->sndpassed != '')
	{
		$projectId = $this->utility->sanitize($this->sndpassed);
		$projects = $this->utility->getProject($projectId);
		print json_encode($projects); exit;
	}
}

function loadShop()
{		
	print "nope"; exit;
	$site_url = $this->site_url;
	$catId = 0;
	$productCount = $this->utility->getProductCount();
	$initialPage = $this->cpage;
	$countPage = ($initialPage * $this->prodCount) > $productCount ? $productCount : $initialPage * $this->prodCount;
	$starting = $this->cpage-1;
	$startPage = ($starting * $this->prodCount) + 1;
	$startrow = $starting * $this->prodCount;
	$products = $this->utility->getProducts($startrow,$this->prodCount);
	include_once(FRAMEWORK_PATH.$this->pagefile);
}


function defaultPage()
{
	$this->utility->errorPage();

}
	
	
}?>