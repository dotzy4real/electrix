<?php

// Global variable for table object
$projects = NULL;

//
// Table class for projects
//
class cprojects extends cTable {
	var $project_id;
	var $project_title;
	var $project_small_pic;
	var $project_pic;
	var $project_content;
	var $project_category_id;
	var $project_date;
	var $project_client;
	var $project_location;
	var $sort_order;
	var $status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'projects';
		$this->TableName = 'projects';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`projects`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// project_id
		$this->project_id = new cField('projects', 'projects', 'x_project_id', 'project_id', '`project_id`', '`project_id`', 19, -1, FALSE, '`project_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->project_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['project_id'] = &$this->project_id;

		// project_title
		$this->project_title = new cField('projects', 'projects', 'x_project_title', 'project_title', '`project_title`', '`project_title`', 200, -1, FALSE, '`project_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['project_title'] = &$this->project_title;

		// project_small_pic
		$this->project_small_pic = new cField('projects', 'projects', 'x_project_small_pic', 'project_small_pic', '`project_small_pic`', '`project_small_pic`', 200, -1, TRUE, '`project_small_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['project_small_pic'] = &$this->project_small_pic;

		// project_pic
		$this->project_pic = new cField('projects', 'projects', 'x_project_pic', 'project_pic', '`project_pic`', '`project_pic`', 200, -1, TRUE, '`project_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['project_pic'] = &$this->project_pic;

		// project_content
		$this->project_content = new cField('projects', 'projects', 'x_project_content', 'project_content', '`project_content`', '`project_content`', 201, -1, FALSE, '`project_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['project_content'] = &$this->project_content;

		// project_category_id
		$this->project_category_id = new cField('projects', 'projects', 'x_project_category_id', 'project_category_id', '`project_category_id`', '`project_category_id`', 3, -1, FALSE, '`project_category_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->project_category_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['project_category_id'] = &$this->project_category_id;

		// project_date
		$this->project_date = new cField('projects', 'projects', 'x_project_date', 'project_date', '`project_date`', '`project_date`', 200, -1, FALSE, '`project_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['project_date'] = &$this->project_date;

		// project_client
		$this->project_client = new cField('projects', 'projects', 'x_project_client', 'project_client', '`project_client`', '`project_client`', 200, -1, FALSE, '`project_client`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['project_client'] = &$this->project_client;

		// project_location
		$this->project_location = new cField('projects', 'projects', 'x_project_location', 'project_location', '`project_location`', '`project_location`', 200, -1, FALSE, '`project_location`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['project_location'] = &$this->project_location;

		// sort_order
		$this->sort_order = new cField('projects', 'projects', 'x_sort_order', 'sort_order', '`sort_order`', '`sort_order`', 3, -1, FALSE, '`sort_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sort_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sort_order'] = &$this->sort_order;

		// status
		$this->status = new cField('projects', 'projects', 'x_status', 'status', '`status`', '`status`', 202, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->status->OptionCount = 2;
		$this->fields['status'] = &$this->status;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`projects`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('project_id', $rs))
				ew_AddFilter($where, ew_QuotedName('project_id', $this->DBID) . '=' . ew_QuotedValue($rs['project_id'], $this->project_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`project_id` = @project_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->project_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@project_id@", ew_AdjustSql($this->project_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "projectslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "projectslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("projectsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("projectsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "projectsadd.php?" . $this->UrlParm($parm);
		else
			$url = "projectsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("projectsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("projectsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("projectsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "project_id:" . ew_VarToJson($this->project_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->project_id->CurrentValue)) {
			$sUrl .= "project_id=" . urlencode($this->project_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["project_id"]) : ew_StripSlashes(@$_GET["project_id"]); // project_id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->project_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->project_id->setDbValue($rs->fields('project_id'));
		$this->project_title->setDbValue($rs->fields('project_title'));
		$this->project_small_pic->Upload->DbValue = $rs->fields('project_small_pic');
		$this->project_pic->Upload->DbValue = $rs->fields('project_pic');
		$this->project_content->setDbValue($rs->fields('project_content'));
		$this->project_category_id->setDbValue($rs->fields('project_category_id'));
		$this->project_date->setDbValue($rs->fields('project_date'));
		$this->project_client->setDbValue($rs->fields('project_client'));
		$this->project_location->setDbValue($rs->fields('project_location'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// project_id
		// project_title
		// project_small_pic
		// project_pic
		// project_content
		// project_category_id
		// project_date
		// project_client
		// project_location
		// sort_order
		// status
		// project_id

		$this->project_id->ViewValue = $this->project_id->CurrentValue;
		$this->project_id->ViewCustomAttributes = "";

		// project_title
		$this->project_title->ViewValue = $this->project_title->CurrentValue;
		$this->project_title->ViewCustomAttributes = "";

		// project_small_pic
		$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
			$this->project_small_pic->ImageWidth = 100;
			$this->project_small_pic->ImageHeight = 120;
			$this->project_small_pic->ImageAlt = $this->project_small_pic->FldAlt();
			$this->project_small_pic->ViewValue = $this->project_small_pic->Upload->DbValue;
		} else {
			$this->project_small_pic->ViewValue = "";
		}
		$this->project_small_pic->CssStyle = "font-style: italic;";
		$this->project_small_pic->ViewCustomAttributes = "";

		// project_pic
		$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_pic->Upload->DbValue)) {
			$this->project_pic->ImageWidth = 120;
			$this->project_pic->ImageHeight = 45;
			$this->project_pic->ImageAlt = $this->project_pic->FldAlt();
			$this->project_pic->ViewValue = $this->project_pic->Upload->DbValue;
		} else {
			$this->project_pic->ViewValue = "";
		}
		$this->project_pic->ViewCustomAttributes = "";

		// project_content
		$this->project_content->ViewValue = $this->project_content->CurrentValue;
		$this->project_content->ViewCustomAttributes = "";

		// project_category_id
		if (strval($this->project_category_id->CurrentValue) <> "") {
			$sFilterWrk = "`project_category_id`" . ew_SearchString("=", $this->project_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `project_category_id`, `project_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `project_categories`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->project_category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->project_category_id->ViewValue = $this->project_category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->project_category_id->ViewValue = $this->project_category_id->CurrentValue;
			}
		} else {
			$this->project_category_id->ViewValue = NULL;
		}
		$this->project_category_id->ViewCustomAttributes = "";

		// project_date
		$this->project_date->ViewValue = $this->project_date->CurrentValue;
		$this->project_date->ViewCustomAttributes = "";

		// project_client
		$this->project_client->ViewValue = $this->project_client->CurrentValue;
		$this->project_client->ViewCustomAttributes = "";

		// project_location
		$this->project_location->ViewValue = $this->project_location->CurrentValue;
		$this->project_location->ViewCustomAttributes = "";

		// sort_order
		$this->sort_order->ViewValue = $this->sort_order->CurrentValue;
		$this->sort_order->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// project_id
		$this->project_id->LinkCustomAttributes = "";
		$this->project_id->HrefValue = "";
		$this->project_id->TooltipValue = "";

		// project_title
		$this->project_title->LinkCustomAttributes = "";
		$this->project_title->HrefValue = "";
		$this->project_title->TooltipValue = "";

		// project_small_pic
		$this->project_small_pic->LinkCustomAttributes = "";
		$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
			$this->project_small_pic->HrefValue = ew_GetFileUploadUrl($this->project_small_pic, $this->project_small_pic->Upload->DbValue); // Add prefix/suffix
			$this->project_small_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->project_small_pic->HrefValue = ew_ConvertFullUrl($this->project_small_pic->HrefValue);
		} else {
			$this->project_small_pic->HrefValue = "";
		}
		$this->project_small_pic->HrefValue2 = $this->project_small_pic->UploadPath . $this->project_small_pic->Upload->DbValue;
		$this->project_small_pic->TooltipValue = "";
		if ($this->project_small_pic->UseColorbox) {
			$this->project_small_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->project_small_pic->LinkAttrs["data-rel"] = "projects_x_project_small_pic";

			//$this->project_small_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->project_small_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->project_small_pic->LinkAttrs["data-container"] = "body";

			$this->project_small_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// project_pic
		$this->project_pic->LinkCustomAttributes = "";
		$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_pic->Upload->DbValue)) {
			$this->project_pic->HrefValue = ew_GetFileUploadUrl($this->project_pic, $this->project_pic->Upload->DbValue); // Add prefix/suffix
			$this->project_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->project_pic->HrefValue = ew_ConvertFullUrl($this->project_pic->HrefValue);
		} else {
			$this->project_pic->HrefValue = "";
		}
		$this->project_pic->HrefValue2 = $this->project_pic->UploadPath . $this->project_pic->Upload->DbValue;
		$this->project_pic->TooltipValue = "";
		if ($this->project_pic->UseColorbox) {
			$this->project_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->project_pic->LinkAttrs["data-rel"] = "projects_x_project_pic";

			//$this->project_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->project_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->project_pic->LinkAttrs["data-container"] = "body";

			$this->project_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// project_content
		$this->project_content->LinkCustomAttributes = "";
		$this->project_content->HrefValue = "";
		$this->project_content->TooltipValue = "";

		// project_category_id
		$this->project_category_id->LinkCustomAttributes = "";
		$this->project_category_id->HrefValue = "";
		$this->project_category_id->TooltipValue = "";

		// project_date
		$this->project_date->LinkCustomAttributes = "";
		$this->project_date->HrefValue = "";
		$this->project_date->TooltipValue = "";

		// project_client
		$this->project_client->LinkCustomAttributes = "";
		$this->project_client->HrefValue = "";
		$this->project_client->TooltipValue = "";

		// project_location
		$this->project_location->LinkCustomAttributes = "";
		$this->project_location->HrefValue = "";
		$this->project_location->TooltipValue = "";

		// sort_order
		$this->sort_order->LinkCustomAttributes = "";
		$this->sort_order->HrefValue = "";
		$this->sort_order->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// project_id
		$this->project_id->EditAttrs["class"] = "form-control";
		$this->project_id->EditCustomAttributes = "";
		$this->project_id->EditValue = $this->project_id->CurrentValue;
		$this->project_id->ViewCustomAttributes = "";

		// project_title
		$this->project_title->EditAttrs["class"] = "form-control";
		$this->project_title->EditCustomAttributes = "";
		$this->project_title->EditValue = $this->project_title->CurrentValue;
		$this->project_title->PlaceHolder = ew_RemoveHtml($this->project_title->FldCaption());

		// project_small_pic
		$this->project_small_pic->EditAttrs["class"] = "form-control";
		$this->project_small_pic->EditCustomAttributes = "";
		$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
			$this->project_small_pic->ImageWidth = 100;
			$this->project_small_pic->ImageHeight = 120;
			$this->project_small_pic->ImageAlt = $this->project_small_pic->FldAlt();
			$this->project_small_pic->EditValue = $this->project_small_pic->Upload->DbValue;
		} else {
			$this->project_small_pic->EditValue = "";
		}
		if (!ew_Empty($this->project_small_pic->CurrentValue))
			$this->project_small_pic->Upload->FileName = $this->project_small_pic->CurrentValue;

		// project_pic
		$this->project_pic->EditAttrs["class"] = "form-control";
		$this->project_pic->EditCustomAttributes = "";
		$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_pic->Upload->DbValue)) {
			$this->project_pic->ImageWidth = 120;
			$this->project_pic->ImageHeight = 45;
			$this->project_pic->ImageAlt = $this->project_pic->FldAlt();
			$this->project_pic->EditValue = $this->project_pic->Upload->DbValue;
		} else {
			$this->project_pic->EditValue = "";
		}
		if (!ew_Empty($this->project_pic->CurrentValue))
			$this->project_pic->Upload->FileName = $this->project_pic->CurrentValue;

		// project_content
		$this->project_content->EditAttrs["class"] = "form-control";
		$this->project_content->EditCustomAttributes = "";
		$this->project_content->EditValue = $this->project_content->CurrentValue;
		$this->project_content->PlaceHolder = ew_RemoveHtml($this->project_content->FldCaption());

		// project_category_id
		$this->project_category_id->EditAttrs["class"] = "form-control";
		$this->project_category_id->EditCustomAttributes = "";

		// project_date
		$this->project_date->EditAttrs["class"] = "form-control";
		$this->project_date->EditCustomAttributes = "";
		$this->project_date->EditValue = $this->project_date->CurrentValue;
		$this->project_date->PlaceHolder = ew_RemoveHtml($this->project_date->FldCaption());

		// project_client
		$this->project_client->EditAttrs["class"] = "form-control";
		$this->project_client->EditCustomAttributes = "";
		$this->project_client->EditValue = $this->project_client->CurrentValue;
		$this->project_client->PlaceHolder = ew_RemoveHtml($this->project_client->FldCaption());

		// project_location
		$this->project_location->EditAttrs["class"] = "form-control";
		$this->project_location->EditCustomAttributes = "";
		$this->project_location->EditValue = $this->project_location->CurrentValue;
		$this->project_location->PlaceHolder = ew_RemoveHtml($this->project_location->FldCaption());

		// sort_order
		$this->sort_order->EditAttrs["class"] = "form-control";
		$this->sort_order->EditCustomAttributes = "";
		$this->sort_order->EditValue = $this->sort_order->CurrentValue;
		$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

		// status
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(FALSE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->project_id->Exportable) $Doc->ExportCaption($this->project_id);
					if ($this->project_title->Exportable) $Doc->ExportCaption($this->project_title);
					if ($this->project_small_pic->Exportable) $Doc->ExportCaption($this->project_small_pic);
					if ($this->project_pic->Exportable) $Doc->ExportCaption($this->project_pic);
					if ($this->project_content->Exportable) $Doc->ExportCaption($this->project_content);
					if ($this->project_category_id->Exportable) $Doc->ExportCaption($this->project_category_id);
					if ($this->project_date->Exportable) $Doc->ExportCaption($this->project_date);
					if ($this->project_client->Exportable) $Doc->ExportCaption($this->project_client);
					if ($this->project_location->Exportable) $Doc->ExportCaption($this->project_location);
					if ($this->sort_order->Exportable) $Doc->ExportCaption($this->sort_order);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
				} else {
					if ($this->project_id->Exportable) $Doc->ExportCaption($this->project_id);
					if ($this->project_title->Exportable) $Doc->ExportCaption($this->project_title);
					if ($this->project_small_pic->Exportable) $Doc->ExportCaption($this->project_small_pic);
					if ($this->project_pic->Exportable) $Doc->ExportCaption($this->project_pic);
					if ($this->project_category_id->Exportable) $Doc->ExportCaption($this->project_category_id);
					if ($this->project_date->Exportable) $Doc->ExportCaption($this->project_date);
					if ($this->project_client->Exportable) $Doc->ExportCaption($this->project_client);
					if ($this->project_location->Exportable) $Doc->ExportCaption($this->project_location);
					if ($this->sort_order->Exportable) $Doc->ExportCaption($this->sort_order);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->project_id->Exportable) $Doc->ExportField($this->project_id);
						if ($this->project_title->Exportable) $Doc->ExportField($this->project_title);
						if ($this->project_small_pic->Exportable) $Doc->ExportField($this->project_small_pic);
						if ($this->project_pic->Exportable) $Doc->ExportField($this->project_pic);
						if ($this->project_content->Exportable) $Doc->ExportField($this->project_content);
						if ($this->project_category_id->Exportable) $Doc->ExportField($this->project_category_id);
						if ($this->project_date->Exportable) $Doc->ExportField($this->project_date);
						if ($this->project_client->Exportable) $Doc->ExportField($this->project_client);
						if ($this->project_location->Exportable) $Doc->ExportField($this->project_location);
						if ($this->sort_order->Exportable) $Doc->ExportField($this->sort_order);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
					} else {
						if ($this->project_id->Exportable) $Doc->ExportField($this->project_id);
						if ($this->project_title->Exportable) $Doc->ExportField($this->project_title);
						if ($this->project_small_pic->Exportable) $Doc->ExportField($this->project_small_pic);
						if ($this->project_pic->Exportable) $Doc->ExportField($this->project_pic);
						if ($this->project_category_id->Exportable) $Doc->ExportField($this->project_category_id);
						if ($this->project_date->Exportable) $Doc->ExportField($this->project_date);
						if ($this->project_client->Exportable) $Doc->ExportField($this->project_client);
						if ($this->project_location->Exportable) $Doc->ExportField($this->project_location);
						if ($this->sort_order->Exportable) $Doc->ExportField($this->sort_order);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
