<?php

// Global variable for table object
$skyview_about = NULL;

//
// Table class for skyview_about
//
class cskyview_about extends cTable {
	var $skyview_about_id;
	var $skyview_about_left_pic;
	var $skyview_about_right_pic;
	var $skyview_about_goal;
	var $skyview_about_icon_title;
	var $skyview_about_title;
	var $skyview_about_content;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'skyview_about';
		$this->TableName = 'skyview_about';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`skyview_about`";
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

		// skyview_about_id
		$this->skyview_about_id = new cField('skyview_about', 'skyview_about', 'x_skyview_about_id', 'skyview_about_id', '`skyview_about_id`', '`skyview_about_id`', 19, -1, FALSE, '`skyview_about_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->skyview_about_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['skyview_about_id'] = &$this->skyview_about_id;

		// skyview_about_left_pic
		$this->skyview_about_left_pic = new cField('skyview_about', 'skyview_about', 'x_skyview_about_left_pic', 'skyview_about_left_pic', '`skyview_about_left_pic`', '`skyview_about_left_pic`', 200, -1, TRUE, '`skyview_about_left_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['skyview_about_left_pic'] = &$this->skyview_about_left_pic;

		// skyview_about_right_pic
		$this->skyview_about_right_pic = new cField('skyview_about', 'skyview_about', 'x_skyview_about_right_pic', 'skyview_about_right_pic', '`skyview_about_right_pic`', '`skyview_about_right_pic`', 200, -1, TRUE, '`skyview_about_right_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['skyview_about_right_pic'] = &$this->skyview_about_right_pic;

		// skyview_about_goal
		$this->skyview_about_goal = new cField('skyview_about', 'skyview_about', 'x_skyview_about_goal', 'skyview_about_goal', '`skyview_about_goal`', '`skyview_about_goal`', 201, -1, FALSE, '`skyview_about_goal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['skyview_about_goal'] = &$this->skyview_about_goal;

		// skyview_about_icon_title
		$this->skyview_about_icon_title = new cField('skyview_about', 'skyview_about', 'x_skyview_about_icon_title', 'skyview_about_icon_title', '`skyview_about_icon_title`', '`skyview_about_icon_title`', 200, -1, FALSE, '`skyview_about_icon_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['skyview_about_icon_title'] = &$this->skyview_about_icon_title;

		// skyview_about_title
		$this->skyview_about_title = new cField('skyview_about', 'skyview_about', 'x_skyview_about_title', 'skyview_about_title', '`skyview_about_title`', '`skyview_about_title`', 200, -1, FALSE, '`skyview_about_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['skyview_about_title'] = &$this->skyview_about_title;

		// skyview_about_content
		$this->skyview_about_content = new cField('skyview_about', 'skyview_about', 'x_skyview_about_content', 'skyview_about_content', '`skyview_about_content`', '`skyview_about_content`', 201, -1, FALSE, '`skyview_about_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['skyview_about_content'] = &$this->skyview_about_content;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`skyview_about`";
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
			if (array_key_exists('skyview_about_id', $rs))
				ew_AddFilter($where, ew_QuotedName('skyview_about_id', $this->DBID) . '=' . ew_QuotedValue($rs['skyview_about_id'], $this->skyview_about_id->FldDataType, $this->DBID));
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
		return "`skyview_about_id` = @skyview_about_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->skyview_about_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@skyview_about_id@", ew_AdjustSql($this->skyview_about_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "skyview_aboutlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "skyview_aboutlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("skyview_aboutview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("skyview_aboutview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "skyview_aboutadd.php?" . $this->UrlParm($parm);
		else
			$url = "skyview_aboutadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("skyview_aboutedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("skyview_aboutadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("skyview_aboutdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "skyview_about_id:" . ew_VarToJson($this->skyview_about_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->skyview_about_id->CurrentValue)) {
			$sUrl .= "skyview_about_id=" . urlencode($this->skyview_about_id->CurrentValue);
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
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["skyview_about_id"]) : ew_StripSlashes(@$_GET["skyview_about_id"]); // skyview_about_id

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
			$this->skyview_about_id->CurrentValue = $key;
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
		$this->skyview_about_id->setDbValue($rs->fields('skyview_about_id'));
		$this->skyview_about_left_pic->Upload->DbValue = $rs->fields('skyview_about_left_pic');
		$this->skyview_about_right_pic->Upload->DbValue = $rs->fields('skyview_about_right_pic');
		$this->skyview_about_goal->setDbValue($rs->fields('skyview_about_goal'));
		$this->skyview_about_icon_title->setDbValue($rs->fields('skyview_about_icon_title'));
		$this->skyview_about_title->setDbValue($rs->fields('skyview_about_title'));
		$this->skyview_about_content->setDbValue($rs->fields('skyview_about_content'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// skyview_about_id
		// skyview_about_left_pic
		// skyview_about_right_pic
		// skyview_about_goal
		// skyview_about_icon_title
		// skyview_about_title
		// skyview_about_content
		// skyview_about_id

		$this->skyview_about_id->ViewValue = $this->skyview_about_id->CurrentValue;
		$this->skyview_about_id->ViewCustomAttributes = "";

		// skyview_about_left_pic
		$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
			$this->skyview_about_left_pic->ImageWidth = 80;
			$this->skyview_about_left_pic->ImageHeight = 120;
			$this->skyview_about_left_pic->ImageAlt = $this->skyview_about_left_pic->FldAlt();
			$this->skyview_about_left_pic->ViewValue = $this->skyview_about_left_pic->Upload->DbValue;
		} else {
			$this->skyview_about_left_pic->ViewValue = "";
		}
		$this->skyview_about_left_pic->ViewCustomAttributes = "";

		// skyview_about_right_pic
		$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
			$this->skyview_about_right_pic->ImageWidth = 110;
			$this->skyview_about_right_pic->ImageHeight = 120;
			$this->skyview_about_right_pic->ImageAlt = $this->skyview_about_right_pic->FldAlt();
			$this->skyview_about_right_pic->ViewValue = $this->skyview_about_right_pic->Upload->DbValue;
		} else {
			$this->skyview_about_right_pic->ViewValue = "";
		}
		$this->skyview_about_right_pic->ViewCustomAttributes = "";

		// skyview_about_goal
		$this->skyview_about_goal->ViewValue = $this->skyview_about_goal->CurrentValue;
		$this->skyview_about_goal->ViewCustomAttributes = "";

		// skyview_about_icon_title
		$this->skyview_about_icon_title->ViewValue = $this->skyview_about_icon_title->CurrentValue;
		$this->skyview_about_icon_title->ViewCustomAttributes = "";

		// skyview_about_title
		$this->skyview_about_title->ViewValue = $this->skyview_about_title->CurrentValue;
		$this->skyview_about_title->ViewCustomAttributes = "";

		// skyview_about_content
		$this->skyview_about_content->ViewValue = $this->skyview_about_content->CurrentValue;
		$this->skyview_about_content->ViewCustomAttributes = "";

		// skyview_about_id
		$this->skyview_about_id->LinkCustomAttributes = "";
		$this->skyview_about_id->HrefValue = "";
		$this->skyview_about_id->TooltipValue = "";

		// skyview_about_left_pic
		$this->skyview_about_left_pic->LinkCustomAttributes = "";
		$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
			$this->skyview_about_left_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_about_left_pic, $this->skyview_about_left_pic->Upload->DbValue); // Add prefix/suffix
			$this->skyview_about_left_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->skyview_about_left_pic->HrefValue = ew_ConvertFullUrl($this->skyview_about_left_pic->HrefValue);
		} else {
			$this->skyview_about_left_pic->HrefValue = "";
		}
		$this->skyview_about_left_pic->HrefValue2 = $this->skyview_about_left_pic->UploadPath . $this->skyview_about_left_pic->Upload->DbValue;
		$this->skyview_about_left_pic->TooltipValue = "";
		if ($this->skyview_about_left_pic->UseColorbox) {
			$this->skyview_about_left_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->skyview_about_left_pic->LinkAttrs["data-rel"] = "skyview_about_x_skyview_about_left_pic";

			//$this->skyview_about_left_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->skyview_about_left_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->skyview_about_left_pic->LinkAttrs["data-container"] = "body";

			$this->skyview_about_left_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// skyview_about_right_pic
		$this->skyview_about_right_pic->LinkCustomAttributes = "";
		$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
			$this->skyview_about_right_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_about_right_pic, $this->skyview_about_right_pic->Upload->DbValue); // Add prefix/suffix
			$this->skyview_about_right_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->skyview_about_right_pic->HrefValue = ew_ConvertFullUrl($this->skyview_about_right_pic->HrefValue);
		} else {
			$this->skyview_about_right_pic->HrefValue = "";
		}
		$this->skyview_about_right_pic->HrefValue2 = $this->skyview_about_right_pic->UploadPath . $this->skyview_about_right_pic->Upload->DbValue;
		$this->skyview_about_right_pic->TooltipValue = "";
		if ($this->skyview_about_right_pic->UseColorbox) {
			$this->skyview_about_right_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->skyview_about_right_pic->LinkAttrs["data-rel"] = "skyview_about_x_skyview_about_right_pic";

			//$this->skyview_about_right_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->skyview_about_right_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->skyview_about_right_pic->LinkAttrs["data-container"] = "body";

			$this->skyview_about_right_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// skyview_about_goal
		$this->skyview_about_goal->LinkCustomAttributes = "";
		$this->skyview_about_goal->HrefValue = "";
		$this->skyview_about_goal->TooltipValue = "";

		// skyview_about_icon_title
		$this->skyview_about_icon_title->LinkCustomAttributes = "";
		$this->skyview_about_icon_title->HrefValue = "";
		$this->skyview_about_icon_title->TooltipValue = "";

		// skyview_about_title
		$this->skyview_about_title->LinkCustomAttributes = "";
		$this->skyview_about_title->HrefValue = "";
		$this->skyview_about_title->TooltipValue = "";

		// skyview_about_content
		$this->skyview_about_content->LinkCustomAttributes = "";
		$this->skyview_about_content->HrefValue = "";
		$this->skyview_about_content->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// skyview_about_id
		$this->skyview_about_id->EditAttrs["class"] = "form-control";
		$this->skyview_about_id->EditCustomAttributes = "";
		$this->skyview_about_id->EditValue = $this->skyview_about_id->CurrentValue;
		$this->skyview_about_id->ViewCustomAttributes = "";

		// skyview_about_left_pic
		$this->skyview_about_left_pic->EditAttrs["class"] = "form-control";
		$this->skyview_about_left_pic->EditCustomAttributes = "";
		$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
			$this->skyview_about_left_pic->ImageWidth = 80;
			$this->skyview_about_left_pic->ImageHeight = 120;
			$this->skyview_about_left_pic->ImageAlt = $this->skyview_about_left_pic->FldAlt();
			$this->skyview_about_left_pic->EditValue = $this->skyview_about_left_pic->Upload->DbValue;
		} else {
			$this->skyview_about_left_pic->EditValue = "";
		}
		if (!ew_Empty($this->skyview_about_left_pic->CurrentValue))
			$this->skyview_about_left_pic->Upload->FileName = $this->skyview_about_left_pic->CurrentValue;

		// skyview_about_right_pic
		$this->skyview_about_right_pic->EditAttrs["class"] = "form-control";
		$this->skyview_about_right_pic->EditCustomAttributes = "";
		$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
			$this->skyview_about_right_pic->ImageWidth = 110;
			$this->skyview_about_right_pic->ImageHeight = 120;
			$this->skyview_about_right_pic->ImageAlt = $this->skyview_about_right_pic->FldAlt();
			$this->skyview_about_right_pic->EditValue = $this->skyview_about_right_pic->Upload->DbValue;
		} else {
			$this->skyview_about_right_pic->EditValue = "";
		}
		if (!ew_Empty($this->skyview_about_right_pic->CurrentValue))
			$this->skyview_about_right_pic->Upload->FileName = $this->skyview_about_right_pic->CurrentValue;

		// skyview_about_goal
		$this->skyview_about_goal->EditAttrs["class"] = "form-control";
		$this->skyview_about_goal->EditCustomAttributes = "";
		$this->skyview_about_goal->EditValue = $this->skyview_about_goal->CurrentValue;
		$this->skyview_about_goal->PlaceHolder = ew_RemoveHtml($this->skyview_about_goal->FldCaption());

		// skyview_about_icon_title
		$this->skyview_about_icon_title->EditAttrs["class"] = "form-control";
		$this->skyview_about_icon_title->EditCustomAttributes = "";
		$this->skyview_about_icon_title->EditValue = $this->skyview_about_icon_title->CurrentValue;
		$this->skyview_about_icon_title->PlaceHolder = ew_RemoveHtml($this->skyview_about_icon_title->FldCaption());

		// skyview_about_title
		$this->skyview_about_title->EditAttrs["class"] = "form-control";
		$this->skyview_about_title->EditCustomAttributes = "";
		$this->skyview_about_title->EditValue = $this->skyview_about_title->CurrentValue;
		$this->skyview_about_title->PlaceHolder = ew_RemoveHtml($this->skyview_about_title->FldCaption());

		// skyview_about_content
		$this->skyview_about_content->EditAttrs["class"] = "form-control";
		$this->skyview_about_content->EditCustomAttributes = "";
		$this->skyview_about_content->EditValue = $this->skyview_about_content->CurrentValue;
		$this->skyview_about_content->PlaceHolder = ew_RemoveHtml($this->skyview_about_content->FldCaption());

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
					if ($this->skyview_about_id->Exportable) $Doc->ExportCaption($this->skyview_about_id);
					if ($this->skyview_about_left_pic->Exportable) $Doc->ExportCaption($this->skyview_about_left_pic);
					if ($this->skyview_about_right_pic->Exportable) $Doc->ExportCaption($this->skyview_about_right_pic);
					if ($this->skyview_about_goal->Exportable) $Doc->ExportCaption($this->skyview_about_goal);
					if ($this->skyview_about_icon_title->Exportable) $Doc->ExportCaption($this->skyview_about_icon_title);
					if ($this->skyview_about_title->Exportable) $Doc->ExportCaption($this->skyview_about_title);
					if ($this->skyview_about_content->Exportable) $Doc->ExportCaption($this->skyview_about_content);
				} else {
					if ($this->skyview_about_id->Exportable) $Doc->ExportCaption($this->skyview_about_id);
					if ($this->skyview_about_left_pic->Exportable) $Doc->ExportCaption($this->skyview_about_left_pic);
					if ($this->skyview_about_right_pic->Exportable) $Doc->ExportCaption($this->skyview_about_right_pic);
					if ($this->skyview_about_icon_title->Exportable) $Doc->ExportCaption($this->skyview_about_icon_title);
					if ($this->skyview_about_title->Exportable) $Doc->ExportCaption($this->skyview_about_title);
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
						if ($this->skyview_about_id->Exportable) $Doc->ExportField($this->skyview_about_id);
						if ($this->skyview_about_left_pic->Exportable) $Doc->ExportField($this->skyview_about_left_pic);
						if ($this->skyview_about_right_pic->Exportable) $Doc->ExportField($this->skyview_about_right_pic);
						if ($this->skyview_about_goal->Exportable) $Doc->ExportField($this->skyview_about_goal);
						if ($this->skyview_about_icon_title->Exportable) $Doc->ExportField($this->skyview_about_icon_title);
						if ($this->skyview_about_title->Exportable) $Doc->ExportField($this->skyview_about_title);
						if ($this->skyview_about_content->Exportable) $Doc->ExportField($this->skyview_about_content);
					} else {
						if ($this->skyview_about_id->Exportable) $Doc->ExportField($this->skyview_about_id);
						if ($this->skyview_about_left_pic->Exportable) $Doc->ExportField($this->skyview_about_left_pic);
						if ($this->skyview_about_right_pic->Exportable) $Doc->ExportField($this->skyview_about_right_pic);
						if ($this->skyview_about_icon_title->Exportable) $Doc->ExportField($this->skyview_about_icon_title);
						if ($this->skyview_about_title->Exportable) $Doc->ExportField($this->skyview_about_title);
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
