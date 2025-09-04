<?php

class msmslController{
	
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
			
			case 'getClientPartners':
			$this->getClientPartners();
			break;
			
			case 'getHomeAbout':
			$this->getHomeAbout();
			break;
			
			case 'getEquipment':
			$this->getProjectSection();
			break;
			
			case 'getChooseUsSection':
			$this->getChooseUsSection();
			break;
			
			case 'getChooseUsItems':
			$this->getChooseUsItems();
			break;
			
			case 'getProjects':
			$this->getProjects();
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
			
			case 'getMissionEdge':
			$this->getMissionEdge();
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
	$homeBanners = $this->utility->getHomeBanners("msmsl_homebanners");
	print json_encode($homeBanners); exit;
}

function getChooseUsSection()
{
	$homeServices = $this->utility->getMsmslChooseUsSection();
	print json_encode($homeServices); exit;
}

function getHomeAbout()
{
	$homeAbout = $this->utility->getMsmslAbout();
	print json_encode($homeAbout); exit;
}

function getProjectSection()
{
	$projectSection = $this->utility->getEquipmentSection();
	print json_encode($projectSection); exit;
}

function getProjects()
{
	$projects = $this->utility->getMsmslProjects();
	print json_encode($projects); exit;
}

function getChooseUsItems()
{
	$chooseItems = $this->utility->getMsmslChooseUsItems();
	print json_encode($chooseItems); exit;
}

function getContactInfo()
{
	$contactInfo = $this->utility->getContactInfo("msmsl_contact_info");
	print json_encode($contactInfo); exit;
}

function getClientPartners()
{
	$clientPartners = $this->utility->getClientPartners("msmsl_client_partners");
	print json_encode($clientPartners); exit;
}

function getFooterProjects()
{
	$projects = $this->utility->getMsmslProjects(6);
	print json_encode($projects); exit;
}

function fetchManagementTeam()
{
	$managementTeams = $this->utility->fetchManagementTeam("msmsl_management_team");
	print json_encode($managementTeams); exit;
}

function getMissionEdge()
{
	$missionEdge = $this->utility->getMsmslMissionEdge();
	print json_encode($missionEdge); exit;
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

function defaultPage()
{
	$this->utility->errorPage();

}
	
	
}?>