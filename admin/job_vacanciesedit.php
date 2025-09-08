<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "job_vacanciesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$job_vacancies_edit = NULL; // Initialize page object first

class cjob_vacancies_edit extends cjob_vacancies {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'job_vacancies';

	// Page object name
	var $PageObjName = 'job_vacancies_edit';

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

		// Table object (job_vacancies)
		if (!isset($GLOBALS["job_vacancies"]) || get_class($GLOBALS["job_vacancies"]) == "cjob_vacancies") {
			$GLOBALS["job_vacancies"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["job_vacancies"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'job_vacancies', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->job_vacancy_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $job_vacancies;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($job_vacancies);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["job_vacancy_id"] <> "") {
			$this->job_vacancy_id->setQueryStringValue($_GET["job_vacancy_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->job_vacancy_id->CurrentValue == "")
			$this->Page_Terminate("job_vacancieslist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("job_vacancieslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->job_vacancy_id->FldIsDetailKey)
			$this->job_vacancy_id->setFormValue($objForm->GetValue("x_job_vacancy_id"));
		if (!$this->job_vacancy_title->FldIsDetailKey) {
			$this->job_vacancy_title->setFormValue($objForm->GetValue("x_job_vacancy_title"));
		}
		if (!$this->job_vacancy_description->FldIsDetailKey) {
			$this->job_vacancy_description->setFormValue($objForm->GetValue("x_job_vacancy_description"));
		}
		if (!$this->job_vacancy_expiry_date->FldIsDetailKey) {
			$this->job_vacancy_expiry_date->setFormValue($objForm->GetValue("x_job_vacancy_expiry_date"));
			$this->job_vacancy_expiry_date->CurrentValue = ew_UnFormatDateTime($this->job_vacancy_expiry_date->CurrentValue, 5);
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->job_vacancy_id->CurrentValue = $this->job_vacancy_id->FormValue;
		$this->job_vacancy_title->CurrentValue = $this->job_vacancy_title->FormValue;
		$this->job_vacancy_description->CurrentValue = $this->job_vacancy_description->FormValue;
		$this->job_vacancy_expiry_date->CurrentValue = $this->job_vacancy_expiry_date->FormValue;
		$this->job_vacancy_expiry_date->CurrentValue = ew_UnFormatDateTime($this->job_vacancy_expiry_date->CurrentValue, 5);
		$this->status->CurrentValue = $this->status->FormValue;
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
		$this->job_vacancy_id->setDbValue($rs->fields('job_vacancy_id'));
		$this->job_vacancy_title->setDbValue($rs->fields('job_vacancy_title'));
		$this->job_vacancy_description->setDbValue($rs->fields('job_vacancy_description'));
		$this->job_vacancy_date_posted->setDbValue($rs->fields('job_vacancy_date_posted'));
		$this->job_vacancy_expiry_date->setDbValue($rs->fields('job_vacancy_expiry_date'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->job_vacancy_id->DbValue = $row['job_vacancy_id'];
		$this->job_vacancy_title->DbValue = $row['job_vacancy_title'];
		$this->job_vacancy_description->DbValue = $row['job_vacancy_description'];
		$this->job_vacancy_date_posted->DbValue = $row['job_vacancy_date_posted'];
		$this->job_vacancy_expiry_date->DbValue = $row['job_vacancy_expiry_date'];
		$this->status->DbValue = $row['status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// job_vacancy_id
		// job_vacancy_title
		// job_vacancy_description
		// job_vacancy_date_posted
		// job_vacancy_expiry_date
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// job_vacancy_id
		$this->job_vacancy_id->ViewValue = $this->job_vacancy_id->CurrentValue;
		$this->job_vacancy_id->ViewCustomAttributes = "";

		// job_vacancy_title
		$this->job_vacancy_title->ViewValue = $this->job_vacancy_title->CurrentValue;
		$this->job_vacancy_title->ViewCustomAttributes = "";

		// job_vacancy_description
		$this->job_vacancy_description->ViewValue = $this->job_vacancy_description->CurrentValue;
		$this->job_vacancy_description->ViewCustomAttributes = "";

		// job_vacancy_date_posted
		$this->job_vacancy_date_posted->ViewValue = $this->job_vacancy_date_posted->CurrentValue;
		$this->job_vacancy_date_posted->ViewValue = ew_FormatDateTime($this->job_vacancy_date_posted->ViewValue, 5);
		$this->job_vacancy_date_posted->ViewCustomAttributes = "";

		// job_vacancy_expiry_date
		$this->job_vacancy_expiry_date->ViewValue = $this->job_vacancy_expiry_date->CurrentValue;
		$this->job_vacancy_expiry_date->ViewValue = ew_FormatDateTime($this->job_vacancy_expiry_date->ViewValue, 5);
		$this->job_vacancy_expiry_date->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

			// job_vacancy_id
			$this->job_vacancy_id->LinkCustomAttributes = "";
			$this->job_vacancy_id->HrefValue = "";
			$this->job_vacancy_id->TooltipValue = "";

			// job_vacancy_title
			$this->job_vacancy_title->LinkCustomAttributes = "";
			$this->job_vacancy_title->HrefValue = "";
			$this->job_vacancy_title->TooltipValue = "";

			// job_vacancy_description
			$this->job_vacancy_description->LinkCustomAttributes = "";
			$this->job_vacancy_description->HrefValue = "";
			$this->job_vacancy_description->TooltipValue = "";

			// job_vacancy_expiry_date
			$this->job_vacancy_expiry_date->LinkCustomAttributes = "";
			$this->job_vacancy_expiry_date->HrefValue = "";
			$this->job_vacancy_expiry_date->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// job_vacancy_id
			$this->job_vacancy_id->EditAttrs["class"] = "form-control";
			$this->job_vacancy_id->EditCustomAttributes = "";
			$this->job_vacancy_id->EditValue = $this->job_vacancy_id->CurrentValue;
			$this->job_vacancy_id->ViewCustomAttributes = "";

			// job_vacancy_title
			$this->job_vacancy_title->EditAttrs["class"] = "form-control";
			$this->job_vacancy_title->EditCustomAttributes = "";
			$this->job_vacancy_title->EditValue = ew_HtmlEncode($this->job_vacancy_title->CurrentValue);
			$this->job_vacancy_title->PlaceHolder = ew_RemoveHtml($this->job_vacancy_title->FldCaption());

			// job_vacancy_description
			$this->job_vacancy_description->EditAttrs["class"] = "form-control";
			$this->job_vacancy_description->EditCustomAttributes = "";
			$this->job_vacancy_description->EditValue = ew_HtmlEncode($this->job_vacancy_description->CurrentValue);
			$this->job_vacancy_description->PlaceHolder = ew_RemoveHtml($this->job_vacancy_description->FldCaption());

			// job_vacancy_expiry_date
			$this->job_vacancy_expiry_date->EditAttrs["class"] = "form-control";
			$this->job_vacancy_expiry_date->EditCustomAttributes = "";
			$this->job_vacancy_expiry_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->job_vacancy_expiry_date->CurrentValue, 5));
			$this->job_vacancy_expiry_date->PlaceHolder = ew_RemoveHtml($this->job_vacancy_expiry_date->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// job_vacancy_id

			$this->job_vacancy_id->HrefValue = "";

			// job_vacancy_title
			$this->job_vacancy_title->HrefValue = "";

			// job_vacancy_description
			$this->job_vacancy_description->HrefValue = "";

			// job_vacancy_expiry_date
			$this->job_vacancy_expiry_date->HrefValue = "";

			// status
			$this->status->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->job_vacancy_title->FldIsDetailKey && !is_null($this->job_vacancy_title->FormValue) && $this->job_vacancy_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->job_vacancy_title->FldCaption(), $this->job_vacancy_title->ReqErrMsg));
		}
		if (!$this->job_vacancy_description->FldIsDetailKey && !is_null($this->job_vacancy_description->FormValue) && $this->job_vacancy_description->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->job_vacancy_description->FldCaption(), $this->job_vacancy_description->ReqErrMsg));
		}
		if (!$this->job_vacancy_expiry_date->FldIsDetailKey && !is_null($this->job_vacancy_expiry_date->FormValue) && $this->job_vacancy_expiry_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->job_vacancy_expiry_date->FldCaption(), $this->job_vacancy_expiry_date->ReqErrMsg));
		}
		if (!ew_CheckDate($this->job_vacancy_expiry_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->job_vacancy_expiry_date->FldErrMsg());
		}
		if ($this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// job_vacancy_title
			$this->job_vacancy_title->SetDbValueDef($rsnew, $this->job_vacancy_title->CurrentValue, "", $this->job_vacancy_title->ReadOnly);

			// job_vacancy_description
			$this->job_vacancy_description->SetDbValueDef($rsnew, $this->job_vacancy_description->CurrentValue, "", $this->job_vacancy_description->ReadOnly);

			// job_vacancy_expiry_date
			$this->job_vacancy_expiry_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->job_vacancy_expiry_date->CurrentValue, 5), ew_CurrentDate(), $this->job_vacancy_expiry_date->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "job_vacancieslist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($job_vacancies_edit)) $job_vacancies_edit = new cjob_vacancies_edit();

// Page init
$job_vacancies_edit->Page_Init();

// Page main
$job_vacancies_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$job_vacancies_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fjob_vacanciesedit = new ew_Form("fjob_vacanciesedit", "edit");

// Validate form
fjob_vacanciesedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_job_vacancy_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_vacancies->job_vacancy_title->FldCaption(), $job_vacancies->job_vacancy_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_job_vacancy_description");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_vacancies->job_vacancy_description->FldCaption(), $job_vacancies->job_vacancy_description->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_job_vacancy_expiry_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_vacancies->job_vacancy_expiry_date->FldCaption(), $job_vacancies->job_vacancy_expiry_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_job_vacancy_expiry_date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($job_vacancies->job_vacancy_expiry_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_vacancies->status->FldCaption(), $job_vacancies->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fjob_vacanciesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fjob_vacanciesedit.ValidateRequired = true;
<?php } else { ?>
fjob_vacanciesedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fjob_vacanciesedit.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fjob_vacanciesedit.Lists["x_status"].Options = <?php echo json_encode($job_vacancies->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $job_vacancies_edit->ShowPageHeader(); ?>
<?php
$job_vacancies_edit->ShowMessage();
?>
<form name="fjob_vacanciesedit" id="fjob_vacanciesedit" class="<?php echo $job_vacancies_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($job_vacancies_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $job_vacancies_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="job_vacancies">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($job_vacancies->job_vacancy_id->Visible) { // job_vacancy_id ?>
	<div id="r_job_vacancy_id" class="form-group">
		<label id="elh_job_vacancies_job_vacancy_id" class="col-sm-2 control-label ewLabel"><?php echo $job_vacancies->job_vacancy_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $job_vacancies->job_vacancy_id->CellAttributes() ?>>
<span id="el_job_vacancies_job_vacancy_id">
<span<?php echo $job_vacancies->job_vacancy_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $job_vacancies->job_vacancy_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="job_vacancies" data-field="x_job_vacancy_id" name="x_job_vacancy_id" id="x_job_vacancy_id" value="<?php echo ew_HtmlEncode($job_vacancies->job_vacancy_id->CurrentValue) ?>">
<?php echo $job_vacancies->job_vacancy_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_vacancies->job_vacancy_title->Visible) { // job_vacancy_title ?>
	<div id="r_job_vacancy_title" class="form-group">
		<label id="elh_job_vacancies_job_vacancy_title" for="x_job_vacancy_title" class="col-sm-2 control-label ewLabel"><?php echo $job_vacancies->job_vacancy_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_vacancies->job_vacancy_title->CellAttributes() ?>>
<span id="el_job_vacancies_job_vacancy_title">
<input type="text" data-table="job_vacancies" data-field="x_job_vacancy_title" name="x_job_vacancy_title" id="x_job_vacancy_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($job_vacancies->job_vacancy_title->getPlaceHolder()) ?>" value="<?php echo $job_vacancies->job_vacancy_title->EditValue ?>"<?php echo $job_vacancies->job_vacancy_title->EditAttributes() ?>>
</span>
<?php echo $job_vacancies->job_vacancy_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_vacancies->job_vacancy_description->Visible) { // job_vacancy_description ?>
	<div id="r_job_vacancy_description" class="form-group">
		<label id="elh_job_vacancies_job_vacancy_description" class="col-sm-2 control-label ewLabel"><?php echo $job_vacancies->job_vacancy_description->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_vacancies->job_vacancy_description->CellAttributes() ?>>
<span id="el_job_vacancies_job_vacancy_description">
<?php ew_AppendClass($job_vacancies->job_vacancy_description->EditAttrs["class"], "editor"); ?>
<textarea data-table="job_vacancies" data-field="x_job_vacancy_description" name="x_job_vacancy_description" id="x_job_vacancy_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($job_vacancies->job_vacancy_description->getPlaceHolder()) ?>"<?php echo $job_vacancies->job_vacancy_description->EditAttributes() ?>><?php echo $job_vacancies->job_vacancy_description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fjob_vacanciesedit", "x_job_vacancy_description", 35, 4, <?php echo ($job_vacancies->job_vacancy_description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $job_vacancies->job_vacancy_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_vacancies->job_vacancy_expiry_date->Visible) { // job_vacancy_expiry_date ?>
	<div id="r_job_vacancy_expiry_date" class="form-group">
		<label id="elh_job_vacancies_job_vacancy_expiry_date" for="x_job_vacancy_expiry_date" class="col-sm-2 control-label ewLabel"><?php echo $job_vacancies->job_vacancy_expiry_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_vacancies->job_vacancy_expiry_date->CellAttributes() ?>>
<span id="el_job_vacancies_job_vacancy_expiry_date">
<input type="text" data-table="job_vacancies" data-field="x_job_vacancy_expiry_date" data-format="5" name="x_job_vacancy_expiry_date" id="x_job_vacancy_expiry_date" placeholder="<?php echo ew_HtmlEncode($job_vacancies->job_vacancy_expiry_date->getPlaceHolder()) ?>" value="<?php echo $job_vacancies->job_vacancy_expiry_date->EditValue ?>"<?php echo $job_vacancies->job_vacancy_expiry_date->EditAttributes() ?>>
<?php if (!$job_vacancies->job_vacancy_expiry_date->ReadOnly && !$job_vacancies->job_vacancy_expiry_date->Disabled && !isset($job_vacancies->job_vacancy_expiry_date->EditAttrs["readonly"]) && !isset($job_vacancies->job_vacancy_expiry_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fjob_vacanciesedit", "x_job_vacancy_expiry_date", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php echo $job_vacancies->job_vacancy_expiry_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_vacancies->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_job_vacancies_status" class="col-sm-2 control-label ewLabel"><?php echo $job_vacancies->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_vacancies->status->CellAttributes() ?>>
<span id="el_job_vacancies_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="job_vacancies" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($job_vacancies->status->DisplayValueSeparator) ? json_encode($job_vacancies->status->DisplayValueSeparator) : $job_vacancies->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $job_vacancies->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $job_vacancies->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($job_vacancies->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="job_vacancies" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $job_vacancies->status->EditAttributes() ?>><?php echo $job_vacancies->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($job_vacancies->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="job_vacancies" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($job_vacancies->status->CurrentValue) ?>" checked<?php echo $job_vacancies->status->EditAttributes() ?>><?php echo $job_vacancies->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $job_vacancies->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $job_vacancies_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fjob_vacanciesedit.Init();
</script>
<?php
$job_vacancies_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$job_vacancies_edit->Page_Terminate();
?>
