<?php

// Global variable for table object
$home_about = NULL;

//
// Table class for home_about
//
class chome_about extends cTable {
	var $home_about_id;
	var $home_about_pic;
	var $home_about_icon_title;
	var $home_about_title;
	var $home_about_subtitle;
	var $home_about_content;
	var $home_about_block1_title;
	var $home_about_block1_content;
	var $home_about_block2_title;
	var $home_about_block2_content;
	var $home_about_board_director_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'home_about';
		$this->TableName = 'home_about';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`home_about`";
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

		// home_about_id
		$this->home_about_id = new cField('home_about', 'home_about', 'x_home_about_id', 'home_about_id', '`home_about_id`', '`home_about_id`', 19, -1, FALSE, '`home_about_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->home_about_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['home_about_id'] = &$this->home_about_id;

		// home_about_pic
		$this->home_about_pic = new cField('home_about', 'home_about', 'x_home_about_pic', 'home_about_pic', '`home_about_pic`', '`home_about_pic`', 200, -1, TRUE, '`home_about_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['home_about_pic'] = &$this->home_about_pic;

		// home_about_icon_title
		$this->home_about_icon_title = new cField('home_about', 'home_about', 'x_home_about_icon_title', 'home_about_icon_title', '`home_about_icon_title`', '`home_about_icon_title`', 200, -1, FALSE, '`home_about_icon_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_icon_title'] = &$this->home_about_icon_title;

		// home_about_title
		$this->home_about_title = new cField('home_about', 'home_about', 'x_home_about_title', 'home_about_title', '`home_about_title`', '`home_about_title`', 200, -1, FALSE, '`home_about_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_title'] = &$this->home_about_title;

		// home_about_subtitle
		$this->home_about_subtitle = new cField('home_about', 'home_about', 'x_home_about_subtitle', 'home_about_subtitle', '`home_about_subtitle`', '`home_about_subtitle`', 200, -1, FALSE, '`home_about_subtitle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_subtitle'] = &$this->home_about_subtitle;

		// home_about_content
		$this->home_about_content = new cField('home_about', 'home_about', 'x_home_about_content', 'home_about_content', '`home_about_content`', '`home_about_content`', 201, -1, FALSE, '`home_about_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['home_about_content'] = &$this->home_about_content;

		// home_about_block1_title
		$this->home_about_block1_title = new cField('home_about', 'home_about', 'x_home_about_block1_title', 'home_about_block1_title', '`home_about_block1_title`', '`home_about_block1_title`', 200, -1, FALSE, '`home_about_block1_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_block1_title'] = &$this->home_about_block1_title;

		// home_about_block1_content
		$this->home_about_block1_content = new cField('home_about', 'home_about', 'x_home_about_block1_content', 'home_about_block1_content', '`home_about_block1_content`', '`home_about_block1_content`', 200, -1, FALSE, '`home_about_block1_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_block1_content'] = &$this->home_about_block1_content;

		// home_about_block2_title
		$this->home_about_block2_title = new cField('home_about', 'home_about', 'x_home_about_block2_title', 'home_about_block2_title', '`home_about_block2_title`', '`home_about_block2_title`', 200, -1, FALSE, '`home_about_block2_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_block2_title'] = &$this->home_about_block2_title;

		// home_about_block2_content
		$this->home_about_block2_content = new cField('home_about', 'home_about', 'x_home_about_block2_content', 'home_about_block2_content', '`home_about_block2_content`', '`home_about_block2_content`', 200, -1, FALSE, '`home_about_block2_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['home_about_block2_content'] = &$this->home_about_block2_content;

		// home_about_board_director_id
		$this->home_about_board_director_id = new cField('home_about', 'home_about', 'x_home_about_board_director_id', 'home_about_board_director_id', '`home_about_board_director_id`', '`home_about_board_director_id`', 3, -1, FALSE, '`home_about_board_director_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->home_about_board_director_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['home_about_board_director_id'] = &$this->home_about_board_director_id;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`home_about`";
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
			if (array_key_exists('home_about_id', $rs))
				ew_AddFilter($where, ew_QuotedName('home_about_id', $this->DBID) . '=' . ew_QuotedValue($rs['home_about_id'], $this->home_about_id->FldDataType, $this->DBID));
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
		return "`home_about_id` = @home_about_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->home_about_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@home_about_id@", ew_AdjustSql($this->home_about_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "home_aboutlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "home_aboutlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("home_aboutview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("home_aboutview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "home_aboutadd.php?" . $this->UrlParm($parm);
		else
			$url = "home_aboutadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("home_aboutedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("home_aboutadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("home_aboutdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "home_about_id:" . ew_VarToJson($this->home_about_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->home_about_id->CurrentValue)) {
			$sUrl .= "home_about_id=" . urlencode($this->home_about_id->CurrentValue);
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
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["home_about_id"]) : ew_StripSlashes(@$_GET["home_about_id"]); // home_about_id

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
			$this->home_about_id->CurrentValue = $key;
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
		$this->home_about_id->setDbValue($rs->fields('home_about_id'));
		$this->home_about_pic->Upload->DbValue = $rs->fields('home_about_pic');
		$this->home_about_icon_title->setDbValue($rs->fields('home_about_icon_title'));
		$this->home_about_title->setDbValue($rs->fields('home_about_title'));
		$this->home_about_subtitle->setDbValue($rs->fields('home_about_subtitle'));
		$this->home_about_content->setDbValue($rs->fields('home_about_content'));
		$this->home_about_block1_title->setDbValue($rs->fields('home_about_block1_title'));
		$this->home_about_block1_content->setDbValue($rs->fields('home_about_block1_content'));
		$this->home_about_block2_title->setDbValue($rs->fields('home_about_block2_title'));
		$this->home_about_block2_content->setDbValue($rs->fields('home_about_block2_content'));
		$this->home_about_board_director_id->setDbValue($rs->fields('home_about_board_director_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// home_about_id
		// home_about_pic
		// home_about_icon_title
		// home_about_title
		// home_about_subtitle
		// home_about_content
		// home_about_block1_title
		// home_about_block1_content
		// home_about_block2_title
		// home_about_block2_content
		// home_about_board_director_id
		// home_about_id

		$this->home_about_id->ViewValue = $this->home_about_id->CurrentValue;
		$this->home_about_id->ViewCustomAttributes = "";

		// home_about_pic
		$this->home_about_pic->UploadPath = '../src/assets/images/resource';
		if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
			$this->home_about_pic->ImageWidth = 105;
			$this->home_about_pic->ImageHeight = 120;
			$this->home_about_pic->ImageAlt = $this->home_about_pic->FldAlt();
			$this->home_about_pic->ViewValue = $this->home_about_pic->Upload->DbValue;
		} else {
			$this->home_about_pic->ViewValue = "";
		}
		$this->home_about_pic->ViewCustomAttributes = "";

		// home_about_icon_title
		$this->home_about_icon_title->ViewValue = $this->home_about_icon_title->CurrentValue;
		$this->home_about_icon_title->ViewCustomAttributes = "";

		// home_about_title
		$this->home_about_title->ViewValue = $this->home_about_title->CurrentValue;
		$this->home_about_title->ViewCustomAttributes = "";

		// home_about_subtitle
		$this->home_about_subtitle->ViewValue = $this->home_about_subtitle->CurrentValue;
		$this->home_about_subtitle->ViewCustomAttributes = "";

		// home_about_content
		$this->home_about_content->ViewValue = $this->home_about_content->CurrentValue;
		$this->home_about_content->ViewCustomAttributes = "";

		// home_about_block1_title
		$this->home_about_block1_title->ViewValue = $this->home_about_block1_title->CurrentValue;
		$this->home_about_block1_title->ViewCustomAttributes = "";

		// home_about_block1_content
		$this->home_about_block1_content->ViewValue = $this->home_about_block1_content->CurrentValue;
		$this->home_about_block1_content->ViewCustomAttributes = "";

		// home_about_block2_title
		$this->home_about_block2_title->ViewValue = $this->home_about_block2_title->CurrentValue;
		$this->home_about_block2_title->ViewCustomAttributes = "";

		// home_about_block2_content
		$this->home_about_block2_content->ViewValue = $this->home_about_block2_content->CurrentValue;
		$this->home_about_block2_content->ViewCustomAttributes = "";

		// home_about_board_director_id
		$this->home_about_board_director_id->ViewValue = $this->home_about_board_director_id->CurrentValue;
		$this->home_about_board_director_id->ViewCustomAttributes = "";

		// home_about_id
		$this->home_about_id->LinkCustomAttributes = "";
		$this->home_about_id->HrefValue = "";
		$this->home_about_id->TooltipValue = "";

		// home_about_pic
		$this->home_about_pic->LinkCustomAttributes = "";
		$this->home_about_pic->UploadPath = '../src/assets/images/resource';
		if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
			$this->home_about_pic->HrefValue = ew_GetFileUploadUrl($this->home_about_pic, $this->home_about_pic->Upload->DbValue); // Add prefix/suffix
			$this->home_about_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->home_about_pic->HrefValue = ew_ConvertFullUrl($this->home_about_pic->HrefValue);
		} else {
			$this->home_about_pic->HrefValue = "";
		}
		$this->home_about_pic->HrefValue2 = $this->home_about_pic->UploadPath . $this->home_about_pic->Upload->DbValue;
		$this->home_about_pic->TooltipValue = "";
		if ($this->home_about_pic->UseColorbox) {
			$this->home_about_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->home_about_pic->LinkAttrs["data-rel"] = "home_about_x_home_about_pic";

			//$this->home_about_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->home_about_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->home_about_pic->LinkAttrs["data-container"] = "body";

			$this->home_about_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// home_about_icon_title
		$this->home_about_icon_title->LinkCustomAttributes = "";
		$this->home_about_icon_title->HrefValue = "";
		$this->home_about_icon_title->TooltipValue = "";

		// home_about_title
		$this->home_about_title->LinkCustomAttributes = "";
		$this->home_about_title->HrefValue = "";
		$this->home_about_title->TooltipValue = "";

		// home_about_subtitle
		$this->home_about_subtitle->LinkCustomAttributes = "";
		$this->home_about_subtitle->HrefValue = "";
		$this->home_about_subtitle->TooltipValue = "";

		// home_about_content
		$this->home_about_content->LinkCustomAttributes = "";
		$this->home_about_content->HrefValue = "";
		$this->home_about_content->TooltipValue = "";

		// home_about_block1_title
		$this->home_about_block1_title->LinkCustomAttributes = "";
		$this->home_about_block1_title->HrefValue = "";
		$this->home_about_block1_title->TooltipValue = "";

		// home_about_block1_content
		$this->home_about_block1_content->LinkCustomAttributes = "";
		$this->home_about_block1_content->HrefValue = "";
		$this->home_about_block1_content->TooltipValue = "";

		// home_about_block2_title
		$this->home_about_block2_title->LinkCustomAttributes = "";
		$this->home_about_block2_title->HrefValue = "";
		$this->home_about_block2_title->TooltipValue = "";

		// home_about_block2_content
		$this->home_about_block2_content->LinkCustomAttributes = "";
		$this->home_about_block2_content->HrefValue = "";
		$this->home_about_block2_content->TooltipValue = "";

		// home_about_board_director_id
		$this->home_about_board_director_id->LinkCustomAttributes = "";
		$this->home_about_board_director_id->HrefValue = "";
		$this->home_about_board_director_id->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// home_about_id
		$this->home_about_id->EditAttrs["class"] = "form-control";
		$this->home_about_id->EditCustomAttributes = "";
		$this->home_about_id->EditValue = $this->home_about_id->CurrentValue;
		$this->home_about_id->ViewCustomAttributes = "";

		// home_about_pic
		$this->home_about_pic->EditAttrs["class"] = "form-control";
		$this->home_about_pic->EditCustomAttributes = "";
		$this->home_about_pic->UploadPath = '../src/assets/images/resource';
		if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
			$this->home_about_pic->ImageWidth = 105;
			$this->home_about_pic->ImageHeight = 120;
			$this->home_about_pic->ImageAlt = $this->home_about_pic->FldAlt();
			$this->home_about_pic->EditValue = $this->home_about_pic->Upload->DbValue;
		} else {
			$this->home_about_pic->EditValue = "";
		}
		if (!ew_Empty($this->home_about_pic->CurrentValue))
			$this->home_about_pic->Upload->FileName = $this->home_about_pic->CurrentValue;

		// home_about_icon_title
		$this->home_about_icon_title->EditAttrs["class"] = "form-control";
		$this->home_about_icon_title->EditCustomAttributes = "";
		$this->home_about_icon_title->EditValue = $this->home_about_icon_title->CurrentValue;
		$this->home_about_icon_title->PlaceHolder = ew_RemoveHtml($this->home_about_icon_title->FldCaption());

		// home_about_title
		$this->home_about_title->EditAttrs["class"] = "form-control";
		$this->home_about_title->EditCustomAttributes = "";
		$this->home_about_title->EditValue = $this->home_about_title->CurrentValue;
		$this->home_about_title->PlaceHolder = ew_RemoveHtml($this->home_about_title->FldCaption());

		// home_about_subtitle
		$this->home_about_subtitle->EditAttrs["class"] = "form-control";
		$this->home_about_subtitle->EditCustomAttributes = "";
		$this->home_about_subtitle->EditValue = $this->home_about_subtitle->CurrentValue;
		$this->home_about_subtitle->PlaceHolder = ew_RemoveHtml($this->home_about_subtitle->FldCaption());

		// home_about_content
		$this->home_about_content->EditAttrs["class"] = "form-control";
		$this->home_about_content->EditCustomAttributes = "";
		$this->home_about_content->EditValue = $this->home_about_content->CurrentValue;
		$this->home_about_content->PlaceHolder = ew_RemoveHtml($this->home_about_content->FldCaption());

		// home_about_block1_title
		$this->home_about_block1_title->EditAttrs["class"] = "form-control";
		$this->home_about_block1_title->EditCustomAttributes = "";
		$this->home_about_block1_title->EditValue = $this->home_about_block1_title->CurrentValue;
		$this->home_about_block1_title->PlaceHolder = ew_RemoveHtml($this->home_about_block1_title->FldCaption());

		// home_about_block1_content
		$this->home_about_block1_content->EditAttrs["class"] = "form-control";
		$this->home_about_block1_content->EditCustomAttributes = "";
		$this->home_about_block1_content->EditValue = $this->home_about_block1_content->CurrentValue;
		$this->home_about_block1_content->PlaceHolder = ew_RemoveHtml($this->home_about_block1_content->FldCaption());

		// home_about_block2_title
		$this->home_about_block2_title->EditAttrs["class"] = "form-control";
		$this->home_about_block2_title->EditCustomAttributes = "";
		$this->home_about_block2_title->EditValue = $this->home_about_block2_title->CurrentValue;
		$this->home_about_block2_title->PlaceHolder = ew_RemoveHtml($this->home_about_block2_title->FldCaption());

		// home_about_block2_content
		$this->home_about_block2_content->EditAttrs["class"] = "form-control";
		$this->home_about_block2_content->EditCustomAttributes = "";
		$this->home_about_block2_content->EditValue = $this->home_about_block2_content->CurrentValue;
		$this->home_about_block2_content->PlaceHolder = ew_RemoveHtml($this->home_about_block2_content->FldCaption());

		// home_about_board_director_id
		$this->home_about_board_director_id->EditAttrs["class"] = "form-control";
		$this->home_about_board_director_id->EditCustomAttributes = "";
		$this->home_about_board_director_id->EditValue = $this->home_about_board_director_id->CurrentValue;
		$this->home_about_board_director_id->PlaceHolder = ew_RemoveHtml($this->home_about_board_director_id->FldCaption());

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
					if ($this->home_about_id->Exportable) $Doc->ExportCaption($this->home_about_id);
					if ($this->home_about_pic->Exportable) $Doc->ExportCaption($this->home_about_pic);
					if ($this->home_about_icon_title->Exportable) $Doc->ExportCaption($this->home_about_icon_title);
					if ($this->home_about_title->Exportable) $Doc->ExportCaption($this->home_about_title);
					if ($this->home_about_subtitle->Exportable) $Doc->ExportCaption($this->home_about_subtitle);
					if ($this->home_about_content->Exportable) $Doc->ExportCaption($this->home_about_content);
					if ($this->home_about_block1_title->Exportable) $Doc->ExportCaption($this->home_about_block1_title);
					if ($this->home_about_block1_content->Exportable) $Doc->ExportCaption($this->home_about_block1_content);
					if ($this->home_about_block2_title->Exportable) $Doc->ExportCaption($this->home_about_block2_title);
					if ($this->home_about_block2_content->Exportable) $Doc->ExportCaption($this->home_about_block2_content);
					if ($this->home_about_board_director_id->Exportable) $Doc->ExportCaption($this->home_about_board_director_id);
				} else {
					if ($this->home_about_id->Exportable) $Doc->ExportCaption($this->home_about_id);
					if ($this->home_about_pic->Exportable) $Doc->ExportCaption($this->home_about_pic);
					if ($this->home_about_icon_title->Exportable) $Doc->ExportCaption($this->home_about_icon_title);
					if ($this->home_about_title->Exportable) $Doc->ExportCaption($this->home_about_title);
					if ($this->home_about_subtitle->Exportable) $Doc->ExportCaption($this->home_about_subtitle);
					if ($this->home_about_block1_title->Exportable) $Doc->ExportCaption($this->home_about_block1_title);
					if ($this->home_about_block1_content->Exportable) $Doc->ExportCaption($this->home_about_block1_content);
					if ($this->home_about_block2_title->Exportable) $Doc->ExportCaption($this->home_about_block2_title);
					if ($this->home_about_block2_content->Exportable) $Doc->ExportCaption($this->home_about_block2_content);
					if ($this->home_about_board_director_id->Exportable) $Doc->ExportCaption($this->home_about_board_director_id);
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
						if ($this->home_about_id->Exportable) $Doc->ExportField($this->home_about_id);
						if ($this->home_about_pic->Exportable) $Doc->ExportField($this->home_about_pic);
						if ($this->home_about_icon_title->Exportable) $Doc->ExportField($this->home_about_icon_title);
						if ($this->home_about_title->Exportable) $Doc->ExportField($this->home_about_title);
						if ($this->home_about_subtitle->Exportable) $Doc->ExportField($this->home_about_subtitle);
						if ($this->home_about_content->Exportable) $Doc->ExportField($this->home_about_content);
						if ($this->home_about_block1_title->Exportable) $Doc->ExportField($this->home_about_block1_title);
						if ($this->home_about_block1_content->Exportable) $Doc->ExportField($this->home_about_block1_content);
						if ($this->home_about_block2_title->Exportable) $Doc->ExportField($this->home_about_block2_title);
						if ($this->home_about_block2_content->Exportable) $Doc->ExportField($this->home_about_block2_content);
						if ($this->home_about_board_director_id->Exportable) $Doc->ExportField($this->home_about_board_director_id);
					} else {
						if ($this->home_about_id->Exportable) $Doc->ExportField($this->home_about_id);
						if ($this->home_about_pic->Exportable) $Doc->ExportField($this->home_about_pic);
						if ($this->home_about_icon_title->Exportable) $Doc->ExportField($this->home_about_icon_title);
						if ($this->home_about_title->Exportable) $Doc->ExportField($this->home_about_title);
						if ($this->home_about_subtitle->Exportable) $Doc->ExportField($this->home_about_subtitle);
						if ($this->home_about_block1_title->Exportable) $Doc->ExportField($this->home_about_block1_title);
						if ($this->home_about_block1_content->Exportable) $Doc->ExportField($this->home_about_block1_content);
						if ($this->home_about_block2_title->Exportable) $Doc->ExportField($this->home_about_block2_title);
						if ($this->home_about_block2_content->Exportable) $Doc->ExportField($this->home_about_block2_content);
						if ($this->home_about_board_director_id->Exportable) $Doc->ExportField($this->home_about_board_director_id);
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
