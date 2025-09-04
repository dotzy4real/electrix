<?php session_start();

	ob_start();

	header('Access-Control-Allow-Origin: http://localhost:5173');

	//define the framework path for all the application

	DEFINE('FRAMEWORK_PATH', dirname(__FILE__).'/');
	
	require ('utilities/constants.php');
	
	require ('utilities/utility.class.php');
	
	$utility = new Utility();
	
	$utility->createObject('urlprocessor','url');

	$utility->createObject('database','db');

	$utility->createObject('authenticate','authenticate');

	$utility->createObject('pagecore','pagecore');
	
	$utility->createObject('paginate','paginate');
		
	$paginate = $utility->getObject('paginate');
	
	$url = $utility->getObject('url');
	
	$database = $utility->getObject('db');
	
	$authenticate = $utility->getObject('authenticate');
	
	$pagecore = $utility->getObject('pagecore');
//print 'index'; exit;
	try{

		$database->newConnection($utility->host, $utility->username, $utility->password, $utility->dbname);

	}catch (Exception $e){

		$error[] = $e->getMessage();

	}
	
	$utility->checkLogin($authenticate, (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? false : true);
	
		
	$site_url = $utility->site_url;
		
	$url->getURLData();	
	
	$urlpassed = $url->getURLBit(0); 
	
	$incontrollers = array('electrix','armese','kilowatt','skyview','msmsl','account');
	
	if ($urlpassed==='' || $urlpassed===0 || $urlpassed==='home'){	
	
		/*$homebanners = $utility->getHomebanners();
	
		$recentProperties = $utility->getRecentProperties(6); // the parameter here is rows fetched limit
		*/
		$pagefile = "home.php";
		
		include(FRAMEWORK_PATH.$pagefile);
		
		exit;
		
	} else {
		
		$control = $urlpassed;
		
		if (in_array($urlpassed,$incontrollers)){ 
			
			require_once (FRAMEWORK_PATH."controllers/$control/controller.php");
			
			$controlClass = $control.'Controller';
			
			$control = new $controlClass($utility);
		} else {
			
			require_once (FRAMEWORK_PATH."controllers/pages/controller.php");
			
			$controlClass = 'pagesController';
			
			$control = new $controlClass($utility);
		}
			
	}
	
	
?>