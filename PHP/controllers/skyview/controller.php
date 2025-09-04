<?php

class skyviewController{
	
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
			
			case 'getHomeAbout':
			$this->getHomeAbout();
			break;

			case 'getContactInfo':
			$this->getContactInfo();
			break;
			
			case 'getFooterProjects':
			$this->getFooterProjects();
			break;
			
			case 'fetchManagementTeam':
			$this->fetchManagementTeam();
			break;
			
			case 'fetchServices':
			$this->fetchServices();
			break;
			
			case 'getService':
			$this->getService();
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
	$homeBanners = $this->utility->getHomeBanners("skyview_homebanners");
	print json_encode($homeBanners); exit;
}

function getHomeAbout()
{
	$homeAbout = $this->utility->getHomeAbout("skyview_about");
	print json_encode($homeAbout); exit;
}

function fetchServices()
{
	$services = $this->utility->getSkyviewServices();
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

function getContactInfo()
{
	$contactInfo = $this->utility->getContactInfo("skyview_contact_info");
	print json_encode($contactInfo); exit;
}

function getFooterProjects()
{
	$projects = $this->utility->getFooterProjects();
	print json_encode($projects); exit;
}

function fetchManagementTeam()
{
	$managementTeams = $this->utility->fetchManagementTeam("skyview_management_team");
	print json_encode($managementTeams); exit;
}


function defaultPage()
{
	$this->utility->errorPage();

}
	
	
}?>