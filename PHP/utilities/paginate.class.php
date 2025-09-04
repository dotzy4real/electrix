<?php 
Class paginate
{

private $utility;
private $npage = ''; //no of pagenum
private $l = ''; //next page to current
private $k = ''; //last page
private $j = ''; //total no of records

public $cpage = ''; //current page
public $prepage = ''; //

public function __construct (Utility $utility){
	$this->utility = $utility;
}


function pagenum ($npage, $pagenum="")
{
	if (!isset($_GET[$npage]) || (isset($_GET[$npage])&&$_GET[$npage]==0)){
		$this->cpage = 1;
	} else {
		$this->cpage = $_GET[$npage];
	}	
	$this->npage = $npage; 
	
	if (!empty($pagenum))
		$this->cpage = $pagenum;
		
	return $this->cpage;
}
	
function numpages($int, $total)
{
	$num = ceil(($total)/$int);
	return $num;
}

function paginate($j, $numpage=6)
{
	$this->l = $this->cpage + 1;
	$this->k = $this->numpages($numpage, $j);
	//if ($this->k<$this->l){
		$this->l=$this->k;	
	//}
	$this->prepage = ceil(7/2);
	$this->j = $j;
}

function printpage($pagelink, $print=true)
{  
	$toPrint = "";
	$onpage = 'http://'.$_SERVER['HTTP_HOST'];
	$pcurrent = '';
	$k = $this->k;
	$l = $this->l;
	$j = $this->j;
	$npage = $this->npage;
	if(strpos($pagelink,"?")==false){ $pagelink = $pagelink."?";}else{ $pagelink = $pagelink."&";}
	if ($this->cpage>1){ 
	$lpage = $this->cpage-1;
	$toPrint .= "<a class='item-pagination flex-c-m trans-0-4' href='$onpage$pagelink$npage=1'>First</a><a class='item-pagination flex-c-m trans-0-4' title='previous page' href='$onpage$pagelink$npage=$lpage'>&lt;&lt;</a>"; 
	} 
	$c=1; 
	$curr=$this->cpage;  //print $this->cpage; exit;
	if ($this->cpage<=$k&&$this->cpage>1){
		$j=$this->cpage-1;
	}else if ($this->cpage>$this->prepage){
		$j=$this->cpage-$k;
		}else{
		$j=0;
		} //print $j; exit;
		if ($this->cpage>$this->prepage){
			for ($i=$j;$i<=$l;$i++){
				if ($i==$this->cpage){
					$sndprev = $i-1;
					$rdprev = $i-2;
					$nexttwo = "";
					if ($i < $k-1){
					$ndpast = $i+1;
					$rdpast = $i+2;
					$nexttwo = "<a class='item-pagination flex-c-m trans-0-4' href='$onpage$pagelink$npage=$ndpast'>$ndpast</a><a href='$onpage$pagelink$npage=$rdpast' class='item-pagination flex-c-m trans-0-4'>$rdpast</a>";
					} else if ($i < $k)
					{
					$ndpast = $i+1;
					$nexttwo = "<a class='item-pagination flex-c-m trans-0-4' href='$onpage$pagelink$npage=$ndpast'>$ndpast</a>";
						
					}
					
					$pcurrent = "active-pagination";
					$toPrint .= "<a class='item-pagination flex-c-m trans-0-4' href='$onpage$pagelink$npage=$rdprev'>$rdprev</a><a href='$onpage$pagelink$npage=$sndprev' class='item-pagination flex-c-m trans-0-4'>$sndprev</a><a class='item-pagination flex-c-m trans-0-4 $pcurrent' href='$onpage$pagelink$npage=$i'>$i</a>$nexttwo
					";
				} else {$pcurrent = '';}
				if ($c==3&&$i<=$k-2){  
					$sndlast = $k-1;
					$rdlast = $k-2;
					$hellip = "";
					if ($i<$k-2)
						$hellip = "<div style='float:left; margin-right:10px;'>&hellip;</div>";
					$toPrint .= "$hellip<a class='item-pagination flex-c-m trans-0-4' href='$onpage$pagelink$npage=$k'>$k</a>"; 
					break; 
				} 
				$c++;
			} 
		} else {
			for ($i=$this->cpage-$j;$i<=$l;$i++){
				if ($i==$this->cpage){
					$pcurrent = "active-pagination";
				}  else {$pcurrent = '';}
				$toPrint .= "<a class='item-pagination flex-c-m trans-0-4 $pcurrent' href='$onpage$pagelink$npage=$i'>$i</a>";
				if ($c==7&&$i<$k){  
					$toPrint .= "<div style='float:left; margin-right:10px;'>&hellip;</div><a class='item-pagination flex-c-m trans-0-4' href='$onpage$pagelink$npage=$k'>$k</a>"; 
					break; 
				} 
				$c++;  
			}		
		}
	if ($this->cpage<$k){ 
		$fpage = $this->cpage+1; 
		$toPrint .= "<a class='item-pagination flex-c-m trans-0-4' title='next page' href='$onpage$pagelink$npage=$fpage'>&gt;&gt;</a><a href='$onpage$pagelink$npage=$k' class='item-pagination flex-c-m trans-0-4 $pcurrent'>Last</a>
"; } 
	if ($print)
		print $toPrint;
	else
		return $toPrint;
}

function displayProjectGallery($start,$int)
{
	$starting = $start-1;
	$startrow = $starting * $int;
	$query = "select * from project_pix limit $startrow, $int";	
	try{
		$this->utility->database->executeQuery($query);
	}
	catch (Exception $e) {
	}	
	$this->utility->result = $this->utility->database->getRows();
	return $this->utility->result;	
}

function displayUploadedCVs($start,$int)
{
	$starting = $start-1;
	$startrow = $starting * $int;
	$query = "select * from career limit $startrow, $int";	
	try{
		$this->utility->database->executeQuery($query);
	}
	catch (Exception $e) {
	}	
	$this->utility->result = $this->utility->database->getRows();
	return $this->utility->result;	
}

function fetchJobs($start,$int)
{
	$starting = $start-1;
	$startrow = $starting * $int;
	$query = "SELECT * FROM latest_jobs where status='active' ORDER BY job_id DESC limit $startrow, $int";	
	try{
		$this->utility->database->executeQuery($query);
	}
	catch (Exception $e) {
	}	
	$this->utility->result = $this->utility->database->getRows();
	return $this->utility->result;
}



}



?>