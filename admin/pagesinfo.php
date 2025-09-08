<?php

// Global variable for table object
$pages = NULL;

//
// Table class for pages
//
class cpages extends cTable {
	var $page_id;
	var $page_name;
	var $page_icon_title;
	var $page_title;
	var $page_breadcumb_title;
	var $page_content;
	var $page_banner;
	var $page_title_caption;
	var $page_show_title;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pages';
		$this->TableName = 'pages';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`pages`";
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

		// page_id
		$this->page_id = new cField('pages', 'pages', 'x_page_id', 'page_id', '`page_id`', '`page_id`', 19, -1, FALSE, '`page_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->page_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['page_id'] = &$this->page_id;

		// page_name
		$this->page_name = new cField('pages', 'pages', 'x_page_name', 'page_name', '`page_name`', '`page_name`', 200, -1, FALSE, '`page_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['page_name'] = &$this->page_name;

		// page_icon_title
		$this->page_icon_title = new cField('pages', 'pages', 'x_page_icon_title', 'page_icon_title', '`page_icon_title`', '`page_icon_title`', 200, -1, FALSE, '`page_icon_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['page_icon_title'] = &$this->page_icon_title;

		// page_title
		$this->page_title = new cField('pages', 'pages', 'x_page_title', 'page_title', '`page_title`', '`page_title`', 200, -1, FALSE, '`page_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['page_title'] = &$this->page_title;

		// page_breadcumb_title
		$this->page_breadcumb_title = new cField('pages', 'pages', 'x_page_breadcumb_title', 'page_breadcumb_title', '`page_breadcumb_title`', '`page_breadcumb_title`', 200, -1, FALSE, '`page_breadcumb_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['page_breadcumb_title'] = &$this->page_breadcumb_title;

		// page_content
		$this->page_content = new cField('pages', 'pages', 'x_page_content', 'page_content', '`page_content`', '`page_content`', 201, -1, FALSE, '`page_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['page_content'] = &$this->page_content;

		// page_banner
		$this->page_banner = new cField('pages', 'pages', 'x_page_banner', 'page_banner', '`page_banner`', '`page_banner`', 200, -1, TRUE, '`page_banner`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['page_banner'] = &$this->page_banner;

		// page_title_caption
		$this->page_title_caption = new cField('pages', 'pages', 'x_page_title_caption', 'page_title_caption', '`page_title_caption`', '`page_title_caption`', 200, -1, FALSE, '`page_title_caption`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['page_title_caption'] = &$this->page_title_caption;

		// page_show_title
		$this->page_show_title = new cField('pages', 'pages', 'x_page_show_title', 'page_show_title', '`page_show_title`', '`page_show_title`', 202, -1, FALSE, '`page_show_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->page_show_title->OptionCount = 2;
		$this->fields['page_show_title'] = &$this->page_show_title;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pages`";
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
			if (array_key_exists('page_id', $rs))
				ew_AddFilter($where, ew_QuotedName('page_id', $this->DBID) . '=' . ew_QuotedValue($rs['page_id'], $this->page_id->FldDataType, $this->DBID));
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
		return "`page_id` = @page_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->page_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@page_id@", ew_AdjustSql($this->page_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "pageslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pageslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pagesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pagesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pagesadd.php?" . $this->UrlParm($parm);
		else
			$url = "pagesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pagesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pagesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pagesdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "page_id:" . ew_VarToJson($this->page_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->page_id->CurrentValue)) {
			$sUrl .= "page_id=" . urlencode($this->page_id->CurrentValue);
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
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["page_id"]) : ew_StripSlashes(@$_GET["page_id"]); // page_id

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
			$this->page_id->CurrentValue = $key;
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
		$this->page_id->setDbValue($rs->fields('page_id'));
		$this->page_name->setDbValue($rs->fields('page_name'));
		$this->page_icon_title->setDbValue($rs->fields('page_icon_title'));
		$this->page_title->setDbValue($rs->fields('page_title'));
		$this->page_breadcumb_title->setDbValue($rs->fields('page_breadcumb_title'));
		$this->page_content->setDbValue($rs->fields('page_content'));
		$this->page_banner->Upload->DbValue = $rs->fields('page_banner');
		$this->page_title_caption->setDbValue($rs->fields('page_title_caption'));
		$this->page_show_title->setDbValue($rs->fields('page_show_title'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// page_id
		// page_name
		// page_icon_title
		// page_title
		// page_breadcumb_title
		// page_content
		// page_banner
		// page_title_caption
		// page_show_title
		// page_id

		$this->page_id->ViewValue = $this->page_id->CurrentValue;
		$this->page_id->ViewCustomAttributes = "";

		// page_name
		$this->page_name->ViewValue = $this->page_name->CurrentValue;
		$this->page_name->ViewCustomAttributes = "";

		// page_icon_title
		$this->page_icon_title->ViewValue = $this->page_icon_title->CurrentValue;
		$this->page_icon_title->ViewCustomAttributes = "";

		// page_title
		$this->page_title->ViewValue = $this->page_title->CurrentValue;
		$this->page_title->ViewCustomAttributes = "";

		// page_breadcumb_title
		$this->page_breadcumb_title->ViewValue = $this->page_breadcumb_title->CurrentValue;
		$this->page_breadcumb_title->ViewCustomAttributes = "";

		// page_content
		$this->page_content->ViewValue = $this->page_content->CurrentValue;
		$this->page_content->ViewCustomAttributes = "";

		// page_banner
		$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
		if (!ew_Empty($this->page_banner->Upload->DbValue)) {
			$this->page_banner->ImageWidth = 120;
			$this->page_banner->ImageHeight = 65;
			$this->page_banner->ImageAlt = $this->page_banner->FldAlt();
			$this->page_banner->ViewValue = $this->page_banner->Upload->DbValue;
		} else {
			$this->page_banner->ViewValue = "";
		}
		$this->page_banner->ViewCustomAttributes = "";

		// page_title_caption
		$this->page_title_caption->ViewValue = $this->page_title_caption->CurrentValue;
		$this->page_title_caption->ViewCustomAttributes = "";

		// page_show_title
		if (strval($this->page_show_title->CurrentValue) <> "") {
			$this->page_show_title->ViewValue = $this->page_show_title->OptionCaption($this->page_show_title->CurrentValue);
		} else {
			$this->page_show_title->ViewValue = NULL;
		}
		$this->page_show_title->ViewCustomAttributes = "";

		// page_id
		$this->page_id->LinkCustomAttributes = "";
		$this->page_id->HrefValue = "";
		$this->page_id->TooltipValue = "";

		// page_name
		$this->page_name->LinkCustomAttributes = "";
		$this->page_name->HrefValue = "";
		$this->page_name->TooltipValue = "";

		// page_icon_title
		$this->page_icon_title->LinkCustomAttributes = "";
		$this->page_icon_title->HrefValue = "";
		$this->page_icon_title->TooltipValue = "";

		// page_title
		$this->page_title->LinkCustomAttributes = "";
		$this->page_title->HrefValue = "";
		$this->page_title->TooltipValue = "";

		// page_breadcumb_title
		$this->page_breadcumb_title->LinkCustomAttributes = "";
		$this->page_breadcumb_title->HrefValue = "";
		$this->page_breadcumb_title->TooltipValue = "";

		// page_content
		$this->page_content->LinkCustomAttributes = "";
		$this->page_content->HrefValue = "";
		$this->page_content->TooltipValue = "";

		// page_banner
		$this->page_banner->LinkCustomAttributes = "";
		$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
		if (!ew_Empty($this->page_banner->Upload->DbValue)) {
			$this->page_banner->HrefValue = ew_GetFileUploadUrl($this->page_banner, $this->page_banner->Upload->DbValue); // Add prefix/suffix
			$this->page_banner->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->page_banner->HrefValue = ew_ConvertFullUrl($this->page_banner->HrefValue);
		} else {
			$this->page_banner->HrefValue = "";
		}
		$this->page_banner->HrefValue2 = $this->page_banner->UploadPath . $this->page_banner->Upload->DbValue;
		$this->page_banner->TooltipValue = "";
		if ($this->page_banner->UseColorbox) {
			$this->page_banner->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->page_banner->LinkAttrs["data-rel"] = "pages_x_page_banner";

			//$this->page_banner->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->page_banner->LinkAttrs["data-placement"] = "bottom";
			//$this->page_banner->LinkAttrs["data-container"] = "body";

			$this->page_banner->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// page_title_caption
		$this->page_title_caption->LinkCustomAttributes = "";
		$this->page_title_caption->HrefValue = "";
		$this->page_title_caption->TooltipValue = "";

		// page_show_title
		$this->page_show_title->LinkCustomAttributes = "";
		$this->page_show_title->HrefValue = "";
		$this->page_show_title->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// page_id
		$this->page_id->EditAttrs["class"] = "form-control";
		$this->page_id->EditCustomAttributes = "";
		$this->page_id->EditValue = $this->page_id->CurrentValue;
		$this->page_id->ViewCustomAttributes = "";

		// page_name
		$this->page_name->EditAttrs["class"] = "form-control";
		$this->page_name->EditCustomAttributes = "";
		$this->page_name->EditValue = $this->page_name->CurrentValue;
		$this->page_name->PlaceHolder = ew_RemoveHtml($this->page_name->FldCaption());

		// page_icon_title
		$this->page_icon_title->EditAttrs["class"] = "form-control";
		$this->page_icon_title->EditCustomAttributes = "";
		$this->page_icon_title->EditValue = $this->page_icon_title->CurrentValue;
		$this->page_icon_title->PlaceHolder = ew_RemoveHtml($this->page_icon_title->FldCaption());

		// page_title
		$this->page_title->EditAttrs["class"] = "form-control";
		$this->page_title->EditCustomAttributes = "";
		$this->page_title->EditValue = $this->page_title->CurrentValue;
		$this->page_title->PlaceHolder = ew_RemoveHtml($this->page_title->FldCaption());

		// page_breadcumb_title
		$this->page_breadcumb_title->EditAttrs["class"] = "form-control";
		$this->page_breadcumb_title->EditCustomAttributes = "";
		$this->page_breadcumb_title->EditValue = $this->page_breadcumb_title->CurrentValue;
		$this->page_breadcumb_title->PlaceHolder = ew_RemoveHtml($this->page_breadcumb_title->FldCaption());

		// page_content
		$this->page_content->EditAttrs["class"] = "form-control";
		$this->page_content->EditCustomAttributes = "";
		$this->page_content->EditValue = $this->page_content->CurrentValue;
		$this->page_content->PlaceHolder = ew_RemoveHtml($this->page_content->FldCaption());

		// page_banner
		$this->page_banner->EditAttrs["class"] = "form-control";
		$this->page_banner->EditCustomAttributes = "";
		$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
		if (!ew_Empty($this->page_banner->Upload->DbValue)) {
			$this->page_banner->ImageWidth = 120;
			$this->page_banner->ImageHeight = 65;
			$this->page_banner->ImageAlt = $this->page_banner->FldAlt();
			$this->page_banner->EditValue = $this->page_banner->Upload->DbValue;
		} else {
			$this->page_banner->EditValue = "";
		}
		if (!ew_Empty($this->page_banner->CurrentValue))
			$this->page_banner->Upload->FileName = $this->page_banner->CurrentValue;

		// page_title_caption
		$this->page_title_caption->EditAttrs["class"] = "form-control";
		$this->page_title_caption->EditCustomAttributes = "";
		$this->page_title_caption->EditValue = $this->page_title_caption->CurrentValue;
		$this->page_title_caption->PlaceHolder = ew_RemoveHtml($this->page_title_caption->FldCaption());

		// page_show_title
		$this->page_show_title->EditCustomAttributes = "";
		$this->page_show_title->EditValue = $this->page_show_title->Options(FALSE);

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
					if ($this->page_id->Exportable) $Doc->ExportCaption($this->page_id);
					if ($this->page_name->Exportable) $Doc->ExportCaption($this->page_name);
					if ($this->page_icon_title->Exportable) $Doc->ExportCaption($this->page_icon_title);
					if ($this->page_title->Exportable) $Doc->ExportCaption($this->page_title);
					if ($this->page_breadcumb_title->Exportable) $Doc->ExportCaption($this->page_breadcumb_title);
					if ($this->page_content->Exportable) $Doc->ExportCaption($this->page_content);
					if ($this->page_banner->Exportable) $Doc->ExportCaption($this->page_banner);
					if ($this->page_title_caption->Exportable) $Doc->ExportCaption($this->page_title_caption);
					if ($this->page_show_title->Exportable) $Doc->ExportCaption($this->page_show_title);
				} else {
					if ($this->page_id->Exportable) $Doc->ExportCaption($this->page_id);
					if ($this->page_name->Exportable) $Doc->ExportCaption($this->page_name);
					if ($this->page_icon_title->Exportable) $Doc->ExportCaption($this->page_icon_title);
					if ($this->page_title->Exportable) $Doc->ExportCaption($this->page_title);
					if ($this->page_breadcumb_title->Exportable) $Doc->ExportCaption($this->page_breadcumb_title);
					if ($this->page_banner->Exportable) $Doc->ExportCaption($this->page_banner);
					if ($this->page_title_caption->Exportable) $Doc->ExportCaption($this->page_title_caption);
					if ($this->page_show_title->Exportable) $Doc->ExportCaption($this->page_show_title);
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
						if ($this->page_id->Exportable) $Doc->ExportField($this->page_id);
						if ($this->page_name->Exportable) $Doc->ExportField($this->page_name);
						if ($this->page_icon_title->Exportable) $Doc->ExportField($this->page_icon_title);
						if ($this->page_title->Exportable) $Doc->ExportField($this->page_title);
						if ($this->page_breadcumb_title->Exportable) $Doc->ExportField($this->page_breadcumb_title);
						if ($this->page_content->Exportable) $Doc->ExportField($this->page_content);
						if ($this->page_banner->Exportable) $Doc->ExportField($this->page_banner);
						if ($this->page_title_caption->Exportable) $Doc->ExportField($this->page_title_caption);
						if ($this->page_show_title->Exportable) $Doc->ExportField($this->page_show_title);
					} else {
						if ($this->page_id->Exportable) $Doc->ExportField($this->page_id);
						if ($this->page_name->Exportable) $Doc->ExportField($this->page_name);
						if ($this->page_icon_title->Exportable) $Doc->ExportField($this->page_icon_title);
						if ($this->page_title->Exportable) $Doc->ExportField($this->page_title);
						if ($this->page_breadcumb_title->Exportable) $Doc->ExportField($this->page_breadcumb_title);
						if ($this->page_banner->Exportable) $Doc->ExportField($this->page_banner);
						if ($this->page_title_caption->Exportable) $Doc->ExportField($this->page_title_caption);
						if ($this->page_show_title->Exportable) $Doc->ExportField($this->page_show_title);
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
