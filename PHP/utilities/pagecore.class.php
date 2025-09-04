<?php
class pageCore{
	public $include_file;
	public $request;
	public $response;
   	public $merchant;
	
	function __construct(Utility $utility){
				
		$this->getConstant();
	}
	
	function getConstant(){
		$url  = $_SERVER['REQUEST_URI'];
		#split the path by '/'
		$params  = explode("/", $url);
		$this->request = array();
        $host = $_SERVER["HTTP_HOST"];
		$pieces = explode(".", $host);
        $this->merchant = $pieces['0']; 
		if($_SERVER['SERVER_NAME']=='localhost'){
		   array_shift($params);//echo $params[0]; exit;
		}
	
		   // var_dump($params);
		  // echo count($params);exit;
	
        if(count($params) == 2){
			for($i=1; $i < count($params); $i++){
				if(is_numeric($params[$i]) || ($i > 2))	{
				   $this->request[] = $params[$i];
				 }else	{
					 $this->include_file = $params[$i];
				 }
			}
        } else{
              $this->include_file = $params[1];
        }
		if($this->_isHome($params)){
		   $this->include_file = 'home';
		 }
		$this->include_file .= ".php";
	}
	function _isHome($params){
		$last = array_pop($params);
		//var_dump($params);
		if(count($params) == 0)
		return true;
		elseif (($last == "")&&(count($params)<2))
		return true;
		else 
		return false;
	}
	
}

?>
