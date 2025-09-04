<?php

class armeseController{
	
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
			
			case 'getServices':
			$this->getArmeseServices();
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
			
			case 'getClientPartners':
			$this->getClientPartners();
			break;
			
			case 'getContactInfo':
			$this->getContactInfo();
			break;
			
			case 'getFooterProjects':
			$this->getFooterProjects();
			break;
			
			case 'getAboutBoardMember':
			$this->getAboutBoardMember();
			break;
			
			case 'getOpeningHours':
			$this->getOpeningHours();
			break;
			
			case 'getCapabilities':
			$this->getCapabilities();
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
	$homeBanners = $this->utility->getHomeBanners("armese_homebanners");
	print json_encode($homeBanners); exit;
}

function getArmeseServices()
{
	$homeServices = $this->utility->getArmeseServices();
	print json_encode($homeServices); exit;
}

function getHomeAbout()
{
	$homeAbout = $this->utility->getArmeseAbout();
	print json_encode($homeAbout); exit;
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
	$projects = $this->utility->getArmeseProjects();
	print json_encode($projects); exit;
}

function getFooterProjects()
{
	$projects = $this->utility->getArmeseProjects(6);
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
	$contactInfo = $this->utility->getContactInfo("armese_contact_info");
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

function getClientPartners()
{
	$clientPartners = $this->utility->getClientPartners("armese_client_partners");
	print json_encode($clientPartners); exit;
}

function getAboutBoardMember()
{	
	$boardMember = $this->utility->getAboutBoardMember();
	print json_encode($boardMember); exit;
}

function getOpeningHours()
{
	$openingHours = $this->utility->getArmeseOpeningHours();
	print json_encode($openingHours); exit;
}

function getCapabilities()
{
	$capabilities = $this->utility->getArmeseCapabilities();
	print json_encode($capabilities); exit;
}

function fetchManagementTeam()
{
	$managementTeams = $this->utility->getArmeseManagementTeam();
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