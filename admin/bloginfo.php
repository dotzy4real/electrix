<?php

// Global variable for table object
$blog = NULL;

//
// Table class for blog
//
class cblog extends cTable {
	var $blog_id;
	var $blog_title;
	var $blog_content;
	var $blog_pic;
	var $blog_category_id;
	var $status;
	var $added_time;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'blog';
		$this->TableName = 'blog';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`blog`";
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

		// blog_id
		$this->blog_id = new cField('blog', 'blog', 'x_blog_id', 'blog_id', '`blog_id`', '`blog_id`', 19, -1, FALSE, '`blog_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->blog_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['blog_id'] = &$this->blog_id;

		// blog_title
		$this->blog_title = new cField('blog', 'blog', 'x_blog_title', 'blog_title', '`blog_title`', '`blog_title`', 200, -1, FALSE, '`blog_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['blog_title'] = &$this->blog_title;

		// blog_content
		$this->blog_content = new cField('blog', 'blog', 'x_blog_content', 'blog_content', '`blog_content`', '`blog_content`', 201, -1, FALSE, '`blog_content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['blog_content'] = &$this->blog_content;

		// blog_pic
		$this->blog_pic = new cField('blog', 'blog', 'x_blog_pic', 'blog_pic', '`blog_pic`', '`blog_pic`', 200, -1, TRUE, '`blog_pic`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->fields['blog_pic'] = &$this->blog_pic;

		// blog_category_id
		$this->blog_category_id = new cField('blog', 'blog', 'x_blog_category_id', 'blog_category_id', '`blog_category_id`', '`blog_category_id`', 3, -1, FALSE, '`blog_category_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->blog_category_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['blog_category_id'] = &$this->blog_category_id;

		// status
		$this->status = new cField('blog', 'blog', 'x_status', 'status', '`status`', '`status`', 202, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->status->OptionCount = 2;
		$this->fields['status'] = &$this->status;

		// added_time
		$this->added_time = new cField('blog', 'blog', 'x_added_time', 'added_time', '`added_time`', 'DATE_FORMAT(`added_time`, \'%Y/%m/%d\')', 135, 5, FALSE, '`added_time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->added_time->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['added_time'] = &$this->added_time;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`blog`";
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
			if (array_key_exists('blog_id', $rs))
				ew_AddFilter($where, ew_QuotedName('blog_id', $this->DBID) . '=' . ew_QuotedValue($rs['blog_id'], $this->blog_id->FldDataType, $this->DBID));
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
		return "`blog_id` = @blog_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->blog_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@blog_id@", ew_AdjustSql($this->blog_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "bloglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "bloglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("blogview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("blogview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "blogadd.php?" . $this->UrlParm($parm);
		else
			$url = "blogadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("blogedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("blogadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("blogdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "blog_id:" . ew_VarToJson($this->blog_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->blog_id->CurrentValue)) {
			$sUrl .= "blog_id=" . urlencode($this->blog_id->CurrentValue);
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
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["blog_id"]) : ew_StripSlashes(@$_GET["blog_id"]); // blog_id

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
			$this->blog_id->CurrentValue = $key;
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
		$this->blog_id->setDbValue($rs->fields('blog_id'));
		$this->blog_title->setDbValue($rs->fields('blog_title'));
		$this->blog_content->setDbValue($rs->fields('blog_content'));
		$this->blog_pic->Upload->DbValue = $rs->fields('blog_pic');
		$this->blog_category_id->setDbValue($rs->fields('blog_category_id'));
		$this->status->setDbValue($rs->fields('status'));
		$this->added_time->setDbValue($rs->fields('added_time'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// blog_id
		// blog_title
		// blog_content
		// blog_pic
		// blog_category_id
		// status
		// added_time
		// blog_id

		$this->blog_id->ViewValue = $this->blog_id->CurrentValue;
		$this->blog_id->ViewCustomAttributes = "";

		// blog_title
		$this->blog_title->ViewValue = $this->blog_title->CurrentValue;
		$this->blog_title->ViewCustomAttributes = "";

		// blog_content
		$this->blog_content->ViewValue = $this->blog_content->CurrentValue;
		$this->blog_content->ViewCustomAttributes = "";

		// blog_pic
		$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
		if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
			$this->blog_pic->ImageWidth = 120;
			$this->blog_pic->ImageHeight = 55;
			$this->blog_pic->ImageAlt = $this->blog_pic->FldAlt();
			$this->blog_pic->ViewValue = $this->blog_pic->Upload->DbValue;
		} else {
			$this->blog_pic->ViewValue = "";
		}
		$this->blog_pic->ViewCustomAttributes = "";

		// blog_category_id
		if (strval($this->blog_category_id->CurrentValue) <> "") {
			$sFilterWrk = "`blog_category_id`" . ew_SearchString("=", $this->blog_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `blog_category_id`, `blog_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `blog_categories`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->blog_category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->blog_category_id->ViewValue = $this->blog_category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->blog_category_id->ViewValue = $this->blog_category_id->CurrentValue;
			}
		} else {
			$this->blog_category_id->ViewValue = NULL;
		}
		$this->blog_category_id->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// added_time
		$this->added_time->ViewValue = $this->added_time->CurrentValue;
		$this->added_time->ViewValue = ew_FormatDateTime($this->added_time->ViewValue, 5);
		$this->added_time->ViewCustomAttributes = "";

		// blog_id
		$this->blog_id->LinkCustomAttributes = "";
		$this->blog_id->HrefValue = "";
		$this->blog_id->TooltipValue = "";

		// blog_title
		$this->blog_title->LinkCustomAttributes = "";
		$this->blog_title->HrefValue = "";
		$this->blog_title->TooltipValue = "";

		// blog_content
		$this->blog_content->LinkCustomAttributes = "";
		$this->blog_content->HrefValue = "";
		$this->blog_content->TooltipValue = "";

		// blog_pic
		$this->blog_pic->LinkCustomAttributes = "";
		$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
		if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
			$this->blog_pic->HrefValue = ew_GetFileUploadUrl($this->blog_pic, $this->blog_pic->Upload->DbValue); // Add prefix/suffix
			$this->blog_pic->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->blog_pic->HrefValue = ew_ConvertFullUrl($this->blog_pic->HrefValue);
		} else {
			$this->blog_pic->HrefValue = "";
		}
		$this->blog_pic->HrefValue2 = $this->blog_pic->UploadPath . $this->blog_pic->Upload->DbValue;
		$this->blog_pic->TooltipValue = "";
		if ($this->blog_pic->UseColorbox) {
			$this->blog_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->blog_pic->LinkAttrs["data-rel"] = "blog_x_blog_pic";

			//$this->blog_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
			//$this->blog_pic->LinkAttrs["data-placement"] = "bottom";
			//$this->blog_pic->LinkAttrs["data-container"] = "body";

			$this->blog_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
		}

		// blog_category_id
		$this->blog_category_id->LinkCustomAttributes = "";
		$this->blog_category_id->HrefValue = "";
		$this->blog_category_id->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// added_time
		$this->added_time->LinkCustomAttributes = "";
		$this->added_time->HrefValue = "";
		$this->added_time->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// blog_id
		$this->blog_id->EditAttrs["class"] = "form-control";
		$this->blog_id->EditCustomAttributes = "";
		$this->blog_id->EditValue = $this->blog_id->CurrentValue;
		$this->blog_id->ViewCustomAttributes = "";

		// blog_title
		$this->blog_title->EditAttrs["class"] = "form-control";
		$this->blog_title->EditCustomAttributes = "";
		$this->blog_title->EditValue = $this->blog_title->CurrentValue;
		$this->blog_title->PlaceHolder = ew_RemoveHtml($this->blog_title->FldCaption());

		// blog_content
		$this->blog_content->EditAttrs["class"] = "form-control";
		$this->blog_content->EditCustomAttributes = "";
		$this->blog_content->EditValue = $this->blog_content->CurrentValue;
		$this->blog_content->PlaceHolder = ew_RemoveHtml($this->blog_content->FldCaption());

		// blog_pic
		$this->blog_pic->EditAttrs["class"] = "form-control";
		$this->blog_pic->EditCustomAttributes = "";
		$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
		if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
			$this->blog_pic->ImageWidth = 120;
			$this->blog_pic->ImageHeight = 55;
			$this->blog_pic->ImageAlt = $this->blog_pic->FldAlt();
			$this->blog_pic->EditValue = $this->blog_pic->Upload->DbValue;
		} else {
			$this->blog_pic->EditValue = "";
		}
		if (!ew_Empty($this->blog_pic->CurrentValue))
			$this->blog_pic->Upload->FileName = $this->blog_pic->CurrentValue;

		// blog_category_id
		$this->blog_category_id->EditAttrs["class"] = "form-control";
		$this->blog_category_id->EditCustomAttributes = "";

		// status
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(FALSE);

		// added_time
		$this->added_time->EditAttrs["class"] = "form-control";
		$this->added_time->EditCustomAttributes = "";
		$this->added_time->EditValue = $this->added_time->CurrentValue;
		$this->added_time->EditValue = ew_FormatDateTime($this->added_time->EditValue, 5);
		$this->added_time->ViewCustomAttributes = "";

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
					if ($this->blog_id->Exportable) $Doc->ExportCaption($this->blog_id);
					if ($this->blog_title->Exportable) $Doc->ExportCaption($this->blog_title);
					if ($this->blog_content->Exportable) $Doc->ExportCaption($this->blog_content);
					if ($this->blog_pic->Exportable) $Doc->ExportCaption($this->blog_pic);
					if ($this->blog_category_id->Exportable) $Doc->ExportCaption($this->blog_category_id);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->added_time->Exportable) $Doc->ExportCaption($this->added_time);
				} else {
					if ($this->blog_id->Exportable) $Doc->ExportCaption($this->blog_id);
					if ($this->blog_title->Exportable) $Doc->ExportCaption($this->blog_title);
					if ($this->blog_pic->Exportable) $Doc->ExportCaption($this->blog_pic);
					if ($this->blog_category_id->Exportable) $Doc->ExportCaption($this->blog_category_id);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->added_time->Exportable) $Doc->ExportCaption($this->added_time);
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
						if ($this->blog_id->Exportable) $Doc->ExportField($this->blog_id);
						if ($this->blog_title->Exportable) $Doc->ExportField($this->blog_title);
						if ($this->blog_content->Exportable) $Doc->ExportField($this->blog_content);
						if ($this->blog_pic->Exportable) $Doc->ExportField($this->blog_pic);
						if ($this->blog_category_id->Exportable) $Doc->ExportField($this->blog_category_id);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->added_time->Exportable) $Doc->ExportField($this->added_time);
					} else {
						if ($this->blog_id->Exportable) $Doc->ExportField($this->blog_id);
						if ($this->blog_title->Exportable) $Doc->ExportField($this->blog_title);
						if ($this->blog_pic->Exportable) $Doc->ExportField($this->blog_pic);
						if ($this->blog_category_id->Exportable) $Doc->ExportField($this->blog_category_id);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->added_time->Exportable) $Doc->ExportField($this->added_time);
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
