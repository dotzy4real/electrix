<?php

// Global variable for table object
$homebanners = NULL;

//
// Table class for homebanners
//
class chomebanners extends cTable {
	var $homebanner_id;
	var $homebanner_subtitle;
	var $homebanner_maintitle;
	var $homebanner_pic;
	var $homebanner_button_text;
	var $homebanner_button_link;
	var $sort_order;
	var $status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'homebanners';
		$this->TableName = 'homebanners';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`homebanners`";
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

		// homebanner_id
		$this->homebanner_id = new cField('homebanners', 'homebanners', 'x_homebanner_id', 'homebanner_id', '`homebanner_id`', '`homebanner_id`', 19, -1, FALSE, '`homebanner_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->homebanner_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['homebanner_id'] = &$this->homebanner_id;

		// homebanner_subtitle
		$this->homebanner_subtitle = new cField('homebanners', 'homebanners', 'x_homebanner_subtitle', 'homebanner_subtitle', '`homebanner_subtitle`', '`homebanner_subtitle`', 200, -1, FALSE, '`homebanner_subtitle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['homebanner_subtitle'] = &$this->homebanner_subtitle;

		// homebanner_maintitle
		$this->homebanner_maintitle = new cField('homebanners', 'homebanners', 'x_homebanner_maintitle', 'homebanner_maintitle', '`homebanner_maintitle`', '`homebanner_maintitle`', 200, -1, FALSE, '`homebanner_maintitle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['homebanner_maintitle'] = &$this->homebanner_maintitle;

		// homebanner_pic
		$this->homebanner_pic = new cField('homebanners', 'homebanners', 'x_homebanner_pic', 'homebanner_pic', '`homebanner_pic`', '`homebanner_pic`', 200, -1, TRUE, '`homebanner_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['homebanner_pic'] = &$this->homebanner_pic;

		// homebanner_button_text
		$this->homebanner_button_text = new cField('homebanners', 'homebanners', 'x_homebanner_button_text', 'homebanner_button_text', '`homebanner_button_text`', '`homebanner_button_text`', 200, -1, FALSE, '`homebanner_button_text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['homebanner_button_text'] = &$this->homebanner_button_text;

		// homebanner_button_link
		$this->homebanner_button_link = new cField('homebanners', 'homebanners', 'x_homebanner_button_link', 'homebanner_button_link', '`homebanner_button_link`', '`homebanner_button_link`', 200, -1, FALSE, '`homebanner_button_link`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['homebanner_button_link'] = &$this->homebanner_button_link;

		// sort_order
		$this->sort_order = new cField('homebanners', 'homebanners', 'x_sort_order', 'sort_order', '`sort_order`', '`sort_order`', 3, -1, FALSE, '`sort_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sort_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sort_order'] = &$this->sort_order;

		// status
		$this->status = new cField('homebanners', 'homebanners', 'x_status', 'status', '`status`', '`status`', 202, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`homebanners`";
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
			if (array_key_exists('homebanner_id', $rs))
				ew_AddFilter($where, ew_QuotedName('homebanner_id', $this->DBID) . '=' . ew_QuotedValue($rs['homebanner_id'], $this->homebanner_id->FldDataType, $this->DBID));
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
		return "`homebanner_id` = @homebanner_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->homebanner_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@homebanner_id@", ew_AdjustSql($this->homebanner_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "homebannerslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "homebannerslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("homebannersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("homebannersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "homebannersadd.php?" . $this->UrlParm($parm);
		else
			$url = "homebannersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("homebannersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("homebannersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("homebannersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "homebanner_id:" . ew_VarToJson($this->homebanner_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->homebanner_id->CurrentValue)) {
			$sUrl .= "homebanner_id=" . urlencode($this->homebanner_id->CurrentValue);
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
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["homebanner_id"]) : ew_StripSlashes(@$_GET["homebanner_id"]); // homebanner_id

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
			$this->homebanner_id->CurrentValue = $key;
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
		$this->homebanner_id->setDbValue($rs->fields('homebanner_id'));
		$this->homebanner_subtitle->setDbValue($rs->fields('homebanner_subtitle'));
		$this->homebanner_maintitle->setDbValue($rs->fields('homebanner_maintitle'));
		$this->homebanner_pic->Upload->DbValue = $rs->fields('homebanner_pic');
		$this->homebanner_button_text->setDbValue($rs->fields('homebanner_button_text'));
		$this->homebanner_button_link->setDbValue($rs->fields('homebanner_button_link'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// homebanner_id
		// homebanner_subtitle
		// homebanner_maintitle
		// homebanner_pic
		// homebanner_button_text
		// homebanner_button_link
		// sort_order
		// status
		// homebanner_id

		$this->homebanner_id->ViewValue = $this->homebanner_id->CurrentValue;
		$this->homebanner_id->ViewCustomAttributes = "";

		// homebanner_subtitle
		$this->homebanner_subtitle->ViewValue = $this->homebanner_subtitle->CurrentValue;
		$this->homebanner_subtitle->ViewCustomAttributes = "";

		// homebanner_maintitle
		$this->homebanner_maintitle->ViewValue = $this->homebanner_maintitle->CurrentValue;
		$this->homebanner_maintitle->ViewCustomAttributes = "";

		// homebanner_pic
		$this->homebanner_pic->UploadPath = '../src/assets/images/resource/homebanners';
		if (!ew_Empty($this->homebanner_pic->Upload->DbValue)) {
			$this->homebanner_pic->ImageWidth = 120;
			$this->homebanner_pic->ImageHeight = 65;
			$this->homebanner_pic->ImageAlt = $this->homebanner_pic->FldAlt();
			$this->homebanner_pic->ViewValue = $this->homebanner_pic->Upload->DbValue;
		} else {
			$this->homebanner_pic->ViewValue = "";
		}
		$this->homebanner_pic->ViewCustomAttributes = "";

		// homebanner_button_text
		$this->homebanner_button_text->ViewValue = $this->homebanner_button_text->CurrentValue;
		$this->homebanner_button_text->ViewCustomAttributes = "";

		// homebanner_button_link
		$this->homebanner_button_link->ViewValue = $this->homebanner_button_link->CurrentValue;
		$this->homebanner_button_link->ViewCustomAttributes = "";

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

		// homebanner_id
		$this->homebanner_id->LinkCustomAttributes = "";
		$this->homebanner_id->HrefValue = "";
		$this->homebanner_id->TooltipValue = "";

		// homebanner_subtitle
		$this->homebanner_subtitle->LinkCustomAttributes = "";
		$this->homebanner_subtitle->HrefValue = "";
		$this->homebanner_subtitle->TooltipValue = "";

		// homebanner_maintitle
		$this->homebanner_maintitle->LinkCustomAttributes = "";
		$this->homebanner_maintitle->HrefValue = "";
		$this->homebanner_maintitle->TooltipValue = "";

		// homebanner_pic
		$this->homebanner_pic->LinkCustomAttributes = "";
		$this->homebanner_pic->UploadPath = '../src/assets/images/resource/homebanners';
		if (!ew_Empty($this->homebanner_pic->Upload->DbValue)) {
			$this->homebanner_pic->HrefValue = ew_GetFileUploadUrl($this->homebanner_pic, $this->homebanner_pic->Upload->DbValue); // Add prefix/suffix
			$this->homebanner_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->homebanner_pic->HrefValue = ew_ConvertFullUrl($this->homebanner_pic->HrefValue);
		} else {
			$this->homebanner_pic->HrefValue = "";
		}
		$this->homebanner_pic->HrefValue2 = $this->homebanner_pic->UploadPath . $this->homebanner_pic->Upload->DbValue;
		$this->homebanner_pic->TooltipValue = "";
		if ($this->homebanner_pic->UseColorbox) {
			$this->homebanner_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->homebanner_pic->LinkAttrs["data-rel"] = "homebanners_x_homebanner_pic";

			//$this->homebanner_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->homebanner_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->homebanner_pic->LinkAttrs["data-container"] = "body";

			$this->homebanner_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// homebanner_button_text
		$this->homebanner_button_text->LinkCustomAttributes = "";
		$this->homebanner_button_text->HrefValue = "";
		$this->homebanner_button_text->TooltipValue = "";

		// homebanner_button_link
		$this->homebanner_button_link->LinkCustomAttributes = "";
		$this->homebanner_button_link->HrefValue = "";
		$this->homebanner_button_link->TooltipValue = "";

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

		// homebanner_id
		$this->homebanner_id->EditAttrs["class"] = "form-control";
		$this->homebanner_id->EditCustomAttributes = "";
		$this->homebanner_id->EditValue = $this->homebanner_id->CurrentValue;
		$this->homebanner_id->ViewCustomAttributes = "";

		// homebanner_subtitle
		$this->homebanner_subtitle->EditAttrs["class"] = "form-control";
		$this->homebanner_subtitle->EditCustomAttributes = "";
		$this->homebanner_subtitle->EditValue = $this->homebanner_subtitle->CurrentValue;
		$this->homebanner_subtitle->PlaceHolder = ew_RemoveHtml($this->homebanner_subtitle->FldCaption());

		// homebanner_maintitle
		$this->homebanner_maintitle->EditAttrs["class"] = "form-control";
		$this->homebanner_maintitle->EditCustomAttributes = "";
		$this->homebanner_maintitle->EditValue = $this->homebanner_maintitle->CurrentValue;
		$this->homebanner_maintitle->PlaceHolder = ew_RemoveHtml($this->homebanner_maintitle->FldCaption());

		// homebanner_pic
		$this->homebanner_pic->EditAttrs["class"] = "form-control";
		$this->homebanner_pic->EditCustomAttributes = "";
		$this->homebanner_pic->UploadPath = '../src/assets/images/resource/homebanners';
		if (!ew_Empty($this->homebanner_pic->Upload->DbValue)) {
			$this->homebanner_pic->ImageWidth = 120;
			$this->homebanner_pic->ImageHeight = 65;
			$this->homebanner_pic->ImageAlt = $this->homebanner_pic->FldAlt();
			$this->homebanner_pic->EditValue = $this->homebanner_pic->Upload->DbValue;
		} else {
			$this->homebanner_pic->EditValue = "";
		}
		if (!ew_Empty($this->homebanner_pic->CurrentValue))
			$this->homebanner_pic->Upload->FileName = $this->homebanner_pic->CurrentValue;

		// homebanner_button_text
		$this->homebanner_button_text->EditAttrs["class"] = "form-control";
		$this->homebanner_button_text->EditCustomAttributes = "";
		$this->homebanner_button_text->EditValue = $this->homebanner_button_text->CurrentValue;
		$this->homebanner_button_text->PlaceHolder = ew_RemoveHtml($this->homebanner_button_text->FldCaption());

		// homebanner_button_link
		$this->homebanner_button_link->EditAttrs["class"] = "form-control";
		$this->homebanner_button_link->EditCustomAttributes = "";
		$this->homebanner_button_link->EditValue = $this->homebanner_button_link->CurrentValue;
		$this->homebanner_button_link->PlaceHolder = ew_RemoveHtml($this->homebanner_button_link->FldCaption());

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
					if ($this->homebanner_id->Exportable) $Doc->ExportCaption($this->homebanner_id);
					if ($this->homebanner_subtitle->Exportable) $Doc->ExportCaption($this->homebanner_subtitle);
					if ($this->homebanner_maintitle->Exportable) $Doc->ExportCaption($this->homebanner_maintitle);
					if ($this->homebanner_pic->Exportable) $Doc->ExportCaption($this->homebanner_pic);
					if ($this->homebanner_button_text->Exportable) $Doc->ExportCaption($this->homebanner_button_text);
					if ($this->homebanner_button_link->Exportable) $Doc->ExportCaption($this->homebanner_button_link);
					if ($this->sort_order->Exportable) $Doc->ExportCaption($this->sort_order);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
				} else {
					if ($this->homebanner_id->Exportable) $Doc->ExportCaption($this->homebanner_id);
					if ($this->homebanner_subtitle->Exportable) $Doc->ExportCaption($this->homebanner_subtitle);
					if ($this->homebanner_maintitle->Exportable) $Doc->ExportCaption($this->homebanner_maintitle);
					if ($this->homebanner_pic->Exportable) $Doc->ExportCaption($this->homebanner_pic);
					if ($this->homebanner_button_text->Exportable) $Doc->ExportCaption($this->homebanner_button_text);
					if ($this->homebanner_button_link->Exportable) $Doc->ExportCaption($this->homebanner_button_link);
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
						if ($this->homebanner_id->Exportable) $Doc->ExportField($this->homebanner_id);
						if ($this->homebanner_subtitle->Exportable) $Doc->ExportField($this->homebanner_subtitle);
						if ($this->homebanner_maintitle->Exportable) $Doc->ExportField($this->homebanner_maintitle);
						if ($this->homebanner_pic->Exportable) $Doc->ExportField($this->homebanner_pic);
						if ($this->homebanner_button_text->Exportable) $Doc->ExportField($this->homebanner_button_text);
						if ($this->homebanner_button_link->Exportable) $Doc->ExportField($this->homebanner_button_link);
						if ($this->sort_order->Exportable) $Doc->ExportField($this->sort_order);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
					} else {
						if ($this->homebanner_id->Exportable) $Doc->ExportField($this->homebanner_id);
						if ($this->homebanner_subtitle->Exportable) $Doc->ExportField($this->homebanner_subtitle);
						if ($this->homebanner_maintitle->Exportable) $Doc->ExportField($this->homebanner_maintitle);
						if ($this->homebanner_pic->Exportable) $Doc->ExportField($this->homebanner_pic);
						if ($this->homebanner_button_text->Exportable) $Doc->ExportField($this->homebanner_button_text);
						if ($this->homebanner_button_link->Exportable) $Doc->ExportField($this->homebanner_button_link);
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
