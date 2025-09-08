<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "job_submissionsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$job_submissions_delete = NULL; // Initialize page object first

class cjob_submissions_delete extends cjob_submissions {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'job_submissions';

	// Page object name
	var $PageObjName = 'job_submissions_delete';

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

		// Table object (job_submissions)
		if (!isset($GLOBALS["job_submissions"]) || get_class($GLOBALS["job_submissions"]) == "cjob_submissions") {
			$GLOBALS["job_submissions"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["job_submissions"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'job_submissions', TRUE);

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
		$this->job_submission_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $job_submissions;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($job_submissions);
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
			$this->Page_Terminate("job_submissionslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in job_submissions class, job_submissionsinfo.php

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
		$this->job_submission_id->setDbValue($rs->fields('job_submission_id'));
		$this->first_name->setDbValue($rs->fields('first_name'));
		$this->last_name->setDbValue($rs->fields('last_name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->position->setDbValue($rs->fields('position'));
		$this->resume->Upload->DbValue = $rs->fields('resume');
		$this->resume->CurrentValue = $this->resume->Upload->DbValue;
		$this->submission_date->setDbValue($rs->fields('submission_date'));
		$this->cover_letter->setDbValue($rs->fields('cover_letter'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->job_submission_id->DbValue = $row['job_submission_id'];
		$this->first_name->DbValue = $row['first_name'];
		$this->last_name->DbValue = $row['last_name'];
		$this->_email->DbValue = $row['email'];
		$this->phone->DbValue = $row['phone'];
		$this->position->DbValue = $row['position'];
		$this->resume->Upload->DbValue = $row['resume'];
		$this->submission_date->DbValue = $row['submission_date'];
		$this->cover_letter->DbValue = $row['cover_letter'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// job_submission_id
		// first_name
		// last_name
		// email
		// phone
		// position
		// resume
		// submission_date
		// cover_letter

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// job_submission_id
		$this->job_submission_id->ViewValue = $this->job_submission_id->CurrentValue;
		$this->job_submission_id->ViewCustomAttributes = "";

		// first_name
		$this->first_name->ViewValue = $this->first_name->CurrentValue;
		$this->first_name->ViewCustomAttributes = "";

		// last_name
		$this->last_name->ViewValue = $this->last_name->CurrentValue;
		$this->last_name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// position
		if (strval($this->position->CurrentValue) <> "") {
			$sFilterWrk = "`job_vacancy_id`" . ew_SearchString("=", $this->position->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `job_vacancy_id`, `job_vacancy_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `job_vacancies`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->position, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->position->ViewValue = $this->position->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->position->ViewValue = $this->position->CurrentValue;
			}
		} else {
			$this->position->ViewValue = NULL;
		}
		$this->position->ViewCustomAttributes = "";

		// resume
		$this->resume->UploadPath = '../src/assets/docs/resume';
		if (!ew_Empty($this->resume->Upload->DbValue)) {
			$this->resume->ViewValue = $this->resume->Upload->DbValue;
		} else {
			$this->resume->ViewValue = "";
		}
		$this->resume->ViewCustomAttributes = "";

		// submission_date
		$this->submission_date->ViewValue = $this->submission_date->CurrentValue;
		$this->submission_date->ViewValue = ew_FormatDateTime($this->submission_date->ViewValue, 5);
		$this->submission_date->ViewCustomAttributes = "";

		// cover_letter
		$this->cover_letter->ViewValue = $this->cover_letter->CurrentValue;
		$this->cover_letter->ViewCustomAttributes = "";

			// job_submission_id
			$this->job_submission_id->LinkCustomAttributes = "";
			$this->job_submission_id->HrefValue = "";
			$this->job_submission_id->TooltipValue = "";

			// first_name
			$this->first_name->LinkCustomAttributes = "";
			$this->first_name->HrefValue = "";
			$this->first_name->TooltipValue = "";

			// last_name
			$this->last_name->LinkCustomAttributes = "";
			$this->last_name->HrefValue = "";
			$this->last_name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// position
			$this->position->LinkCustomAttributes = "";
			$this->position->HrefValue = "";
			$this->position->TooltipValue = "";

			// resume
			$this->resume->LinkCustomAttributes = "";
			$this->resume->HrefValue = "";
			$this->resume->HrefValue2 = $this->resume->UploadPath . $this->resume->Upload->DbValue;
			$this->resume->TooltipValue = "";

			// submission_date
			$this->submission_date->LinkCustomAttributes = "";
			$this->submission_date->HrefValue = "";
			$this->submission_date->TooltipValue = "";

			// cover_letter
			$this->cover_letter->LinkCustomAttributes = "";
			$this->cover_letter->HrefValue = "";
			$this->cover_letter->TooltipValue = "";
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
				$sThisKey .= $row['job_submission_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "job_submissionslist.php", "", $this->TableVar, TRUE);
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
if (!isset($job_submissions_delete)) $job_submissions_delete = new cjob_submissions_delete();

// Page init
$job_submissions_delete->Page_Init();

// Page main
$job_submissions_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$job_submissions_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fjob_submissionsdelete = new ew_Form("fjob_submissionsdelete", "delete");

// Form_CustomValidate event
fjob_submissionsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fjob_submissionsdelete.ValidateRequired = true;
<?php } else { ?>
fjob_submissionsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fjob_submissionsdelete.Lists["x_position"] = {"LinkField":"x_job_vacancy_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_job_vacancy_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($job_submissions_delete->Recordset = $job_submissions_delete->LoadRecordset())
	$job_submissions_deleteTotalRecs = $job_submissions_delete->Recordset->RecordCount(); // Get record count
if ($job_submissions_deleteTotalRecs <= 0) { // No record found, exit
	if ($job_submissions_delete->Recordset)
		$job_submissions_delete->Recordset->Close();
	$job_submissions_delete->Page_Terminate("job_submissionslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $job_submissions_delete->ShowPageHeader(); ?>
<?php
$job_submissions_delete->ShowMessage();
?>
<form name="fjob_submissionsdelete" id="fjob_submissionsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($job_submissions_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $job_submissions_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="job_submissions">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($job_submissions_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $job_submissions->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($job_submissions->job_submission_id->Visible) { // job_submission_id ?>
		<th><span id="elh_job_submissions_job_submission_id" class="job_submissions_job_submission_id"><?php echo $job_submissions->job_submission_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->first_name->Visible) { // first_name ?>
		<th><span id="elh_job_submissions_first_name" class="job_submissions_first_name"><?php echo $job_submissions->first_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->last_name->Visible) { // last_name ?>
		<th><span id="elh_job_submissions_last_name" class="job_submissions_last_name"><?php echo $job_submissions->last_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->_email->Visible) { // email ?>
		<th><span id="elh_job_submissions__email" class="job_submissions__email"><?php echo $job_submissions->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->phone->Visible) { // phone ?>
		<th><span id="elh_job_submissions_phone" class="job_submissions_phone"><?php echo $job_submissions->phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->position->Visible) { // position ?>
		<th><span id="elh_job_submissions_position" class="job_submissions_position"><?php echo $job_submissions->position->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->resume->Visible) { // resume ?>
		<th><span id="elh_job_submissions_resume" class="job_submissions_resume"><?php echo $job_submissions->resume->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->submission_date->Visible) { // submission_date ?>
		<th><span id="elh_job_submissions_submission_date" class="job_submissions_submission_date"><?php echo $job_submissions->submission_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($job_submissions->cover_letter->Visible) { // cover_letter ?>
		<th><span id="elh_job_submissions_cover_letter" class="job_submissions_cover_letter"><?php echo $job_submissions->cover_letter->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$job_submissions_delete->RecCnt = 0;
$i = 0;
while (!$job_submissions_delete->Recordset->EOF) {
	$job_submissions_delete->RecCnt++;
	$job_submissions_delete->RowCnt++;

	// Set row properties
	$job_submissions->ResetAttrs();
	$job_submissions->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$job_submissions_delete->LoadRowValues($job_submissions_delete->Recordset);

	// Render row
	$job_submissions_delete->RenderRow();
?>
	<tr<?php echo $job_submissions->RowAttributes() ?>>
<?php if ($job_submissions->job_submission_id->Visible) { // job_submission_id ?>
		<td<?php echo $job_submissions->job_submission_id->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_job_submission_id" class="job_submissions_job_submission_id">
<span<?php echo $job_submissions->job_submission_id->ViewAttributes() ?>>
<?php echo $job_submissions->job_submission_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->first_name->Visible) { // first_name ?>
		<td<?php echo $job_submissions->first_name->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_first_name" class="job_submissions_first_name">
<span<?php echo $job_submissions->first_name->ViewAttributes() ?>>
<?php echo $job_submissions->first_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->last_name->Visible) { // last_name ?>
		<td<?php echo $job_submissions->last_name->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_last_name" class="job_submissions_last_name">
<span<?php echo $job_submissions->last_name->ViewAttributes() ?>>
<?php echo $job_submissions->last_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->_email->Visible) { // email ?>
		<td<?php echo $job_submissions->_email->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions__email" class="job_submissions__email">
<span<?php echo $job_submissions->_email->ViewAttributes() ?>>
<?php echo $job_submissions->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->phone->Visible) { // phone ?>
		<td<?php echo $job_submissions->phone->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_phone" class="job_submissions_phone">
<span<?php echo $job_submissions->phone->ViewAttributes() ?>>
<?php echo $job_submissions->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->position->Visible) { // position ?>
		<td<?php echo $job_submissions->position->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_position" class="job_submissions_position">
<span<?php echo $job_submissions->position->ViewAttributes() ?>>
<?php echo $job_submissions->position->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->resume->Visible) { // resume ?>
		<td<?php echo $job_submissions->resume->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_resume" class="job_submissions_resume">
<span<?php echo $job_submissions->resume->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($job_submissions->resume, $job_submissions->resume->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->submission_date->Visible) { // submission_date ?>
		<td<?php echo $job_submissions->submission_date->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_submission_date" class="job_submissions_submission_date">
<span<?php echo $job_submissions->submission_date->ViewAttributes() ?>>
<?php echo $job_submissions->submission_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($job_submissions->cover_letter->Visible) { // cover_letter ?>
		<td<?php echo $job_submissions->cover_letter->CellAttributes() ?>>
<span id="el<?php echo $job_submissions_delete->RowCnt ?>_job_submissions_cover_letter" class="job_submissions_cover_letter">
<span<?php echo $job_submissions->cover_letter->ViewAttributes() ?>>
<?php echo $job_submissions->cover_letter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$job_submissions_delete->Recordset->MoveNext();
}
$job_submissions_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $job_submissions_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fjob_submissionsdelete.Init();
</script>
<?php
$job_submissions_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$job_submissions_delete->Page_Terminate();
?>
