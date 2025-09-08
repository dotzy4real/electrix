<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "skyview_servicesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$skyview_services_delete = NULL; // Initialize page object first

class cskyview_services_delete extends cskyview_services {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'skyview_services';

	// Page object name
	var $PageObjName = 'skyview_services_delete';

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

		// Table object (skyview_services)
		if (!isset($GLOBALS["skyview_services"]) || get_class($GLOBALS["skyview_services"]) == "cskyview_services") {
			$GLOBALS["skyview_services"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["skyview_services"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'skyview_services', TRUE);

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
		$this->skyview_service_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $skyview_services;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($skyview_services);
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
			$this->Page_Terminate("skyview_serviceslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in skyview_services class, skyview_servicesinfo.php

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
		$this->skyview_service_id->setDbValue($rs->fields('skyview_service_id'));
		$this->skyview_service_icon->setDbValue($rs->fields('skyview_service_icon'));
		$this->skyview_service_title->setDbValue($rs->fields('skyview_service_title'));
		$this->skyview_service_pic->Upload->DbValue = $rs->fields('skyview_service_pic');
		$this->skyview_service_pic->CurrentValue = $this->skyview_service_pic->Upload->DbValue;
		$this->skyview_service_snippet->setDbValue($rs->fields('skyview_service_snippet'));
		$this->skyview_service_content->setDbValue($rs->fields('skyview_service_content'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->skyview_service_id->DbValue = $row['skyview_service_id'];
		$this->skyview_service_icon->DbValue = $row['skyview_service_icon'];
		$this->skyview_service_title->DbValue = $row['skyview_service_title'];
		$this->skyview_service_pic->Upload->DbValue = $row['skyview_service_pic'];
		$this->skyview_service_snippet->DbValue = $row['skyview_service_snippet'];
		$this->skyview_service_content->DbValue = $row['skyview_service_content'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// skyview_service_id
		// skyview_service_icon
		// skyview_service_title
		// skyview_service_pic
		// skyview_service_snippet
		// skyview_service_content
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// skyview_service_id
		$this->skyview_service_id->ViewValue = $this->skyview_service_id->CurrentValue;
		$this->skyview_service_id->ViewCustomAttributes = "";

		// skyview_service_icon
		if (strval($this->skyview_service_icon->CurrentValue) <> "") {
			$this->skyview_service_icon->ViewValue = $this->skyview_service_icon->OptionCaption($this->skyview_service_icon->CurrentValue);
		} else {
			$this->skyview_service_icon->ViewValue = NULL;
		}
		$this->skyview_service_icon->ViewCustomAttributes = "";

		// skyview_service_title
		$this->skyview_service_title->ViewValue = $this->skyview_service_title->CurrentValue;
		$this->skyview_service_title->ViewCustomAttributes = "";

		// skyview_service_pic
		$this->skyview_service_pic->UploadPath = '../src/assets/images/skyview/services';
		if (!ew_Empty($this->skyview_service_pic->Upload->DbValue)) {
			$this->skyview_service_pic->ImageWidth = 129;
			$this->skyview_service_pic->ImageHeight = 90;
			$this->skyview_service_pic->ImageAlt = $this->skyview_service_pic->FldAlt();
			$this->skyview_service_pic->ViewValue = $this->skyview_service_pic->Upload->DbValue;
		} else {
			$this->skyview_service_pic->ViewValue = "";
		}
		$this->skyview_service_pic->ViewCustomAttributes = "";

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

			// skyview_service_id
			$this->skyview_service_id->LinkCustomAttributes = "";
			$this->skyview_service_id->HrefValue = "";
			$this->skyview_service_id->TooltipValue = "";

			// skyview_service_icon
			$this->skyview_service_icon->LinkCustomAttributes = "";
			$this->skyview_service_icon->HrefValue = "";
			$this->skyview_service_icon->TooltipValue = "";

			// skyview_service_title
			$this->skyview_service_title->LinkCustomAttributes = "";
			$this->skyview_service_title->HrefValue = "";
			$this->skyview_service_title->TooltipValue = "";

			// skyview_service_pic
			$this->skyview_service_pic->LinkCustomAttributes = "";
			$this->skyview_service_pic->UploadPath = '../src/assets/images/skyview/services';
			if (!ew_Empty($this->skyview_service_pic->Upload->DbValue)) {
				$this->skyview_service_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_service_pic, $this->skyview_service_pic->Upload->DbValue); // Add prefix/suffix
				$this->skyview_service_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->skyview_service_pic->HrefValue = ew_ConvertFullUrl($this->skyview_service_pic->HrefValue);
			} else {
				$this->skyview_service_pic->HrefValue = "";
			}
			$this->skyview_service_pic->HrefValue2 = $this->skyview_service_pic->UploadPath . $this->skyview_service_pic->Upload->DbValue;
			$this->skyview_service_pic->TooltipValue = "";
			if ($this->skyview_service_pic->UseColorbox) {
				$this->skyview_service_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->skyview_service_pic->LinkAttrs["data-rel"] = "skyview_services_x_skyview_service_pic";

				//$this->skyview_service_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->skyview_service_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->skyview_service_pic->LinkAttrs["data-container"] = "body";

				$this->skyview_service_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
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
				$sThisKey .= $row['skyview_service_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "skyview_serviceslist.php", "", $this->TableVar, TRUE);
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
if (!isset($skyview_services_delete)) $skyview_services_delete = new cskyview_services_delete();

// Page init
$skyview_services_delete->Page_Init();

// Page main
$skyview_services_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$skyview_services_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fskyview_servicesdelete = new ew_Form("fskyview_servicesdelete", "delete");

// Form_CustomValidate event
fskyview_servicesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fskyview_servicesdelete.ValidateRequired = true;
<?php } else { ?>
fskyview_servicesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fskyview_servicesdelete.Lists["x_skyview_service_icon"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fskyview_servicesdelete.Lists["x_skyview_service_icon"].Options = <?php echo json_encode($skyview_services->skyview_service_icon->Options()) ?>;
fskyview_servicesdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fskyview_servicesdelete.Lists["x_status"].Options = <?php echo json_encode($skyview_services->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($skyview_services_delete->Recordset = $skyview_services_delete->LoadRecordset())
	$skyview_services_deleteTotalRecs = $skyview_services_delete->Recordset->RecordCount(); // Get record count
if ($skyview_services_deleteTotalRecs <= 0) { // No record found, exit
	if ($skyview_services_delete->Recordset)
		$skyview_services_delete->Recordset->Close();
	$skyview_services_delete->Page_Terminate("skyview_serviceslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $skyview_services_delete->ShowPageHeader(); ?>
<?php
$skyview_services_delete->ShowMessage();
?>
<form name="fskyview_servicesdelete" id="fskyview_servicesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($skyview_services_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $skyview_services_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="skyview_services">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($skyview_services_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $skyview_services->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($skyview_services->skyview_service_id->Visible) { // skyview_service_id ?>
		<th><span id="elh_skyview_services_skyview_service_id" class="skyview_services_skyview_service_id"><?php echo $skyview_services->skyview_service_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_services->skyview_service_icon->Visible) { // skyview_service_icon ?>
		<th><span id="elh_skyview_services_skyview_service_icon" class="skyview_services_skyview_service_icon"><?php echo $skyview_services->skyview_service_icon->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_services->skyview_service_title->Visible) { // skyview_service_title ?>
		<th><span id="elh_skyview_services_skyview_service_title" class="skyview_services_skyview_service_title"><?php echo $skyview_services->skyview_service_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_services->skyview_service_pic->Visible) { // skyview_service_pic ?>
		<th><span id="elh_skyview_services_skyview_service_pic" class="skyview_services_skyview_service_pic"><?php echo $skyview_services->skyview_service_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_services->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_skyview_services_sort_order" class="skyview_services_sort_order"><?php echo $skyview_services->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_services->status->Visible) { // status ?>
		<th><span id="elh_skyview_services_status" class="skyview_services_status"><?php echo $skyview_services->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$skyview_services_delete->RecCnt = 0;
$i = 0;
while (!$skyview_services_delete->Recordset->EOF) {
	$skyview_services_delete->RecCnt++;
	$skyview_services_delete->RowCnt++;

	// Set row properties
	$skyview_services->ResetAttrs();
	$skyview_services->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$skyview_services_delete->LoadRowValues($skyview_services_delete->Recordset);

	// Render row
	$skyview_services_delete->RenderRow();
?>
	<tr<?php echo $skyview_services->RowAttributes() ?>>
<?php if ($skyview_services->skyview_service_id->Visible) { // skyview_service_id ?>
		<td<?php echo $skyview_services->skyview_service_id->CellAttributes() ?>>
<span id="el<?php echo $skyview_services_delete->RowCnt ?>_skyview_services_skyview_service_id" class="skyview_services_skyview_service_id">
<span<?php echo $skyview_services->skyview_service_id->ViewAttributes() ?>>
<?php echo $skyview_services->skyview_service_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_services->skyview_service_icon->Visible) { // skyview_service_icon ?>
		<td<?php echo $skyview_services->skyview_service_icon->CellAttributes() ?>>
<span id="el<?php echo $skyview_services_delete->RowCnt ?>_skyview_services_skyview_service_icon" class="skyview_services_skyview_service_icon">
<span<?php echo $skyview_services->skyview_service_icon->ViewAttributes() ?>>
<?php echo $skyview_services->skyview_service_icon->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_services->skyview_service_title->Visible) { // skyview_service_title ?>
		<td<?php echo $skyview_services->skyview_service_title->CellAttributes() ?>>
<span id="el<?php echo $skyview_services_delete->RowCnt ?>_skyview_services_skyview_service_title" class="skyview_services_skyview_service_title">
<span<?php echo $skyview_services->skyview_service_title->ViewAttributes() ?>>
<?php echo $skyview_services->skyview_service_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_services->skyview_service_pic->Visible) { // skyview_service_pic ?>
		<td<?php echo $skyview_services->skyview_service_pic->CellAttributes() ?>>
<span id="el<?php echo $skyview_services_delete->RowCnt ?>_skyview_services_skyview_service_pic" class="skyview_services_skyview_service_pic">
<span>
<?php echo ew_GetFileViewTag($skyview_services->skyview_service_pic, $skyview_services->skyview_service_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($skyview_services->sort_order->Visible) { // sort_order ?>
		<td<?php echo $skyview_services->sort_order->CellAttributes() ?>>
<span id="el<?php echo $skyview_services_delete->RowCnt ?>_skyview_services_sort_order" class="skyview_services_sort_order">
<span<?php echo $skyview_services->sort_order->ViewAttributes() ?>>
<?php echo $skyview_services->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_services->status->Visible) { // status ?>
		<td<?php echo $skyview_services->status->CellAttributes() ?>>
<span id="el<?php echo $skyview_services_delete->RowCnt ?>_skyview_services_status" class="skyview_services_status">
<span<?php echo $skyview_services->status->ViewAttributes() ?>>
<?php echo $skyview_services->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$skyview_services_delete->Recordset->MoveNext();
}
$skyview_services_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $skyview_services_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fskyview_servicesdelete.Init();
</script>
<?php
$skyview_services_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$skyview_services_delete->Page_Terminate();
?>
