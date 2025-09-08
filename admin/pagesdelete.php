<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "pagesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$pages_delete = NULL; // Initialize page object first

class cpages_delete extends cpages {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'pages';

	// Page object name
	var $PageObjName = 'pages_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (pages)
		if (!isset($GLOBALS["pages"]) || get_class($GLOBALS["pages"]) == "cpages") {
			$GLOBALS["pages"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pages"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pages', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) $this->Page_Terminate(ew_GetUrl("login.php"));
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->page_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $pages;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pages);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("pageslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in pages class, pagesinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->page_id->setDbValue($rs->fields('page_id'));
		$this->page_name->setDbValue($rs->fields('page_name'));
		$this->page_icon_title->setDbValue($rs->fields('page_icon_title'));
		$this->page_title->setDbValue($rs->fields('page_title'));
		$this->page_breadcumb_title->setDbValue($rs->fields('page_breadcumb_title'));
		$this->page_content->setDbValue($rs->fields('page_content'));
		$this->page_banner->Upload->DbValue = $rs->fields('page_banner');
		$this->page_banner->CurrentValue = $this->page_banner->Upload->DbValue;
		$this->page_title_caption->setDbValue($rs->fields('page_title_caption'));
		$this->page_show_title->setDbValue($rs->fields('page_show_title'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->page_id->DbValue = $row['page_id'];
		$this->page_name->DbValue = $row['page_name'];
		$this->page_icon_title->DbValue = $row['page_icon_title'];
		$this->page_title->DbValue = $row['page_title'];
		$this->page_breadcumb_title->DbValue = $row['page_breadcumb_title'];
		$this->page_content->DbValue = $row['page_content'];
		$this->page_banner->Upload->DbValue = $row['page_banner'];
		$this->page_title_caption->DbValue = $row['page_title_caption'];
		$this->page_show_title->DbValue = $row['page_show_title'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// page_id
		// page_name
		// page_icon_title
		// page_title
		// page_breadcumb_title
		// page_content
		// page_banner
		// page_title_caption
		// page_show_title

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['page_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "pageslist.php", "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($pages_delete)) $pages_delete = new cpages_delete();

// Page init
$pages_delete->Page_Init();

// Page main
$pages_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pages_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpagesdelete = new ew_Form("fpagesdelete", "delete");

// Form_CustomValidate event
fpagesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpagesdelete.ValidateRequired = true;
<?php } else { ?>
fpagesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpagesdelete.Lists["x_page_show_title"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpagesdelete.Lists["x_page_show_title"].Options = <?php echo json_encode($pages->page_show_title->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($pages_delete->Recordset = $pages_delete->LoadRecordset())
	$pages_deleteTotalRecs = $pages_delete->Recordset->RecordCount(); // Get record count
if ($pages_deleteTotalRecs <= 0) { // No record found, exit
	if ($pages_delete->Recordset)
		$pages_delete->Recordset->Close();
	$pages_delete->Page_Terminate("pageslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $pages_delete->ShowPageHeader(); ?>
<?php
$pages_delete->ShowMessage();
?>
<form name="fpagesdelete" id="fpagesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pages_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pages_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pages">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($pages_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $pages->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($pages->page_id->Visible) { // page_id ?>
		<th><span id="elh_pages_page_id" class="pages_page_id"><?php echo $pages->page_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_name->Visible) { // page_name ?>
		<th><span id="elh_pages_page_name" class="pages_page_name"><?php echo $pages->page_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_icon_title->Visible) { // page_icon_title ?>
		<th><span id="elh_pages_page_icon_title" class="pages_page_icon_title"><?php echo $pages->page_icon_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_title->Visible) { // page_title ?>
		<th><span id="elh_pages_page_title" class="pages_page_title"><?php echo $pages->page_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_breadcumb_title->Visible) { // page_breadcumb_title ?>
		<th><span id="elh_pages_page_breadcumb_title" class="pages_page_breadcumb_title"><?php echo $pages->page_breadcumb_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_banner->Visible) { // page_banner ?>
		<th><span id="elh_pages_page_banner" class="pages_page_banner"><?php echo $pages->page_banner->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_title_caption->Visible) { // page_title_caption ?>
		<th><span id="elh_pages_page_title_caption" class="pages_page_title_caption"><?php echo $pages->page_title_caption->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pages->page_show_title->Visible) { // page_show_title ?>
		<th><span id="elh_pages_page_show_title" class="pages_page_show_title"><?php echo $pages->page_show_title->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pages_delete->RecCnt = 0;
$i = 0;
while (!$pages_delete->Recordset->EOF) {
	$pages_delete->RecCnt++;
	$pages_delete->RowCnt++;

	// Set row properties
	$pages->ResetAttrs();
	$pages->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$pages_delete->LoadRowValues($pages_delete->Recordset);

	// Render row
	$pages_delete->RenderRow();
?>
	<tr<?php echo $pages->RowAttributes() ?>>
<?php if ($pages->page_id->Visible) { // page_id ?>
		<td<?php echo $pages->page_id->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_id" class="pages_page_id">
<span<?php echo $pages->page_id->ViewAttributes() ?>>
<?php echo $pages->page_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_name->Visible) { // page_name ?>
		<td<?php echo $pages->page_name->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_name" class="pages_page_name">
<span<?php echo $pages->page_name->ViewAttributes() ?>>
<?php echo $pages->page_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_icon_title->Visible) { // page_icon_title ?>
		<td<?php echo $pages->page_icon_title->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_icon_title" class="pages_page_icon_title">
<span<?php echo $pages->page_icon_title->ViewAttributes() ?>>
<?php echo $pages->page_icon_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_title->Visible) { // page_title ?>
		<td<?php echo $pages->page_title->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_title" class="pages_page_title">
<span<?php echo $pages->page_title->ViewAttributes() ?>>
<?php echo $pages->page_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_breadcumb_title->Visible) { // page_breadcumb_title ?>
		<td<?php echo $pages->page_breadcumb_title->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_breadcumb_title" class="pages_page_breadcumb_title">
<span<?php echo $pages->page_breadcumb_title->ViewAttributes() ?>>
<?php echo $pages->page_breadcumb_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_banner->Visible) { // page_banner ?>
		<td<?php echo $pages->page_banner->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_banner" class="pages_page_banner">
<span>
<?php echo ew_GetFileViewTag($pages->page_banner, $pages->page_banner->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_title_caption->Visible) { // page_title_caption ?>
		<td<?php echo $pages->page_title_caption->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_title_caption" class="pages_page_title_caption">
<span<?php echo $pages->page_title_caption->ViewAttributes() ?>>
<?php echo $pages->page_title_caption->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pages->page_show_title->Visible) { // page_show_title ?>
		<td<?php echo $pages->page_show_title->CellAttributes() ?>>
<span id="el<?php echo $pages_delete->RowCnt ?>_pages_page_show_title" class="pages_page_show_title">
<span<?php echo $pages->page_show_title->ViewAttributes() ?>>
<?php echo $pages->page_show_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pages_delete->Recordset->MoveNext();
}
$pages_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pages_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpagesdelete.Init();
</script>
<?php
$pages_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pages_delete->Page_Terminate();
?>
