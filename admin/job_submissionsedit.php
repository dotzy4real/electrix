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

$job_submissions_edit = NULL; // Initialize page object first

class cjob_submissions_edit extends cjob_submissions {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'job_submissions';

	// Page object name
	var $PageObjName = 'job_submissions_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["job_submission_id"] <> "") {
			$this->job_submission_id->setQueryStringValue($_GET["job_submission_id"]);
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
		if ($this->job_submission_id->CurrentValue == "")
			$this->Page_Terminate("job_submissionslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("job_submissionslist.php"); // No matching record, return to list
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
		$this->resume->Upload->Index = $objForm->Index;
		$this->resume->Upload->UploadFile();
		$this->resume->CurrentValue = $this->resume->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->job_submission_id->FldIsDetailKey)
			$this->job_submission_id->setFormValue($objForm->GetValue("x_job_submission_id"));
		if (!$this->first_name->FldIsDetailKey) {
			$this->first_name->setFormValue($objForm->GetValue("x_first_name"));
		}
		if (!$this->last_name->FldIsDetailKey) {
			$this->last_name->setFormValue($objForm->GetValue("x_last_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->position->FldIsDetailKey) {
			$this->position->setFormValue($objForm->GetValue("x_position"));
		}
		if (!$this->cover_letter->FldIsDetailKey) {
			$this->cover_letter->setFormValue($objForm->GetValue("x_cover_letter"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->job_submission_id->CurrentValue = $this->job_submission_id->FormValue;
		$this->first_name->CurrentValue = $this->first_name->FormValue;
		$this->last_name->CurrentValue = $this->last_name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->position->CurrentValue = $this->position->FormValue;
		$this->cover_letter->CurrentValue = $this->cover_letter->FormValue;
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

			// cover_letter
			$this->cover_letter->LinkCustomAttributes = "";
			$this->cover_letter->HrefValue = "";
			$this->cover_letter->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// job_submission_id
			$this->job_submission_id->EditAttrs["class"] = "form-control";
			$this->job_submission_id->EditCustomAttributes = "";
			$this->job_submission_id->EditValue = $this->job_submission_id->CurrentValue;
			$this->job_submission_id->ViewCustomAttributes = "";

			// first_name
			$this->first_name->EditAttrs["class"] = "form-control";
			$this->first_name->EditCustomAttributes = "";
			$this->first_name->EditValue = ew_HtmlEncode($this->first_name->CurrentValue);
			$this->first_name->PlaceHolder = ew_RemoveHtml($this->first_name->FldCaption());

			// last_name
			$this->last_name->EditAttrs["class"] = "form-control";
			$this->last_name->EditCustomAttributes = "";
			$this->last_name->EditValue = ew_HtmlEncode($this->last_name->CurrentValue);
			$this->last_name->PlaceHolder = ew_RemoveHtml($this->last_name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// position
			$this->position->EditAttrs["class"] = "form-control";
			$this->position->EditCustomAttributes = "";
			if (trim(strval($this->position->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`job_vacancy_id`" . ew_SearchString("=", $this->position->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `job_vacancy_id`, `job_vacancy_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `job_vacancies`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->position, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->position->EditValue = $arwrk;

			// resume
			$this->resume->EditAttrs["class"] = "form-control";
			$this->resume->EditCustomAttributes = "";
			$this->resume->UploadPath = '../src/assets/docs/resume';
			if (!ew_Empty($this->resume->Upload->DbValue)) {
				$this->resume->EditValue = $this->resume->Upload->DbValue;
			} else {
				$this->resume->EditValue = "";
			}
			if (!ew_Empty($this->resume->CurrentValue))
				$this->resume->Upload->FileName = $this->resume->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->resume);

			// cover_letter
			$this->cover_letter->EditAttrs["class"] = "form-control";
			$this->cover_letter->EditCustomAttributes = "";
			$this->cover_letter->EditValue = ew_HtmlEncode($this->cover_letter->CurrentValue);
			$this->cover_letter->PlaceHolder = ew_RemoveHtml($this->cover_letter->FldCaption());

			// Edit refer script
			// job_submission_id

			$this->job_submission_id->HrefValue = "";

			// first_name
			$this->first_name->HrefValue = "";

			// last_name
			$this->last_name->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// phone
			$this->phone->HrefValue = "";

			// position
			$this->position->HrefValue = "";

			// resume
			$this->resume->HrefValue = "";
			$this->resume->HrefValue2 = $this->resume->UploadPath . $this->resume->Upload->DbValue;

			// cover_letter
			$this->cover_letter->HrefValue = "";
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
		if (!$this->first_name->FldIsDetailKey && !is_null($this->first_name->FormValue) && $this->first_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->first_name->FldCaption(), $this->first_name->ReqErrMsg));
		}
		if (!$this->last_name->FldIsDetailKey && !is_null($this->last_name->FormValue) && $this->last_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->last_name->FldCaption(), $this->last_name->ReqErrMsg));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!$this->phone->FldIsDetailKey && !is_null($this->phone->FormValue) && $this->phone->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->phone->FldCaption(), $this->phone->ReqErrMsg));
		}
		if (!$this->position->FldIsDetailKey && !is_null($this->position->FormValue) && $this->position->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->position->FldCaption(), $this->position->ReqErrMsg));
		}
		if ($this->resume->Upload->FileName == "" && !$this->resume->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->resume->FldCaption(), $this->resume->ReqErrMsg));
		}
		if (!$this->cover_letter->FldIsDetailKey && !is_null($this->cover_letter->FormValue) && $this->cover_letter->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cover_letter->FldCaption(), $this->cover_letter->ReqErrMsg));
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
			$this->resume->OldUploadPath = '../src/assets/docs/resume';
			$this->resume->UploadPath = $this->resume->OldUploadPath;
			$rsnew = array();

			// first_name
			$this->first_name->SetDbValueDef($rsnew, $this->first_name->CurrentValue, "", $this->first_name->ReadOnly);

			// last_name
			$this->last_name->SetDbValueDef($rsnew, $this->last_name->CurrentValue, "", $this->last_name->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, "", $this->phone->ReadOnly);

			// position
			$this->position->SetDbValueDef($rsnew, $this->position->CurrentValue, 0, $this->position->ReadOnly);

			// resume
			if (!($this->resume->ReadOnly) && !$this->resume->Upload->KeepFile) {
				$this->resume->Upload->DbValue = $rsold['resume']; // Get original value
				if ($this->resume->Upload->FileName == "") {
					$rsnew['resume'] = NULL;
				} else {
					$rsnew['resume'] = $this->resume->Upload->FileName;
				}
			}

			// cover_letter
			$this->cover_letter->SetDbValueDef($rsnew, $this->cover_letter->CurrentValue, "", $this->cover_letter->ReadOnly);
			if (!$this->resume->Upload->KeepFile) {
				$this->resume->UploadPath = '../src/assets/docs/resume';
				if (!ew_Empty($this->resume->Upload->Value)) {
					$rsnew['resume'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->resume->UploadPath), $rsnew['resume']); // Get new file name
				}
			}

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
					if (!$this->resume->Upload->KeepFile) {
						if (!ew_Empty($this->resume->Upload->Value)) {
							$this->resume->Upload->SaveToFile($this->resume->UploadPath, $rsnew['resume'], TRUE);
						}
					}
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

		// resume
		ew_CleanUploadTempPath($this->resume, $this->resume->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "job_submissionslist.php", "", $this->TableVar, TRUE);
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
if (!isset($job_submissions_edit)) $job_submissions_edit = new cjob_submissions_edit();

// Page init
$job_submissions_edit->Page_Init();

// Page main
$job_submissions_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$job_submissions_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fjob_submissionsedit = new ew_Form("fjob_submissionsedit", "edit");

// Validate form
fjob_submissionsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_first_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->first_name->FldCaption(), $job_submissions->first_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_last_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->last_name->FldCaption(), $job_submissions->last_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->_email->FldCaption(), $job_submissions->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_phone");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->phone->FldCaption(), $job_submissions->phone->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_position");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->position->FldCaption(), $job_submissions->position->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_resume");
			elm = this.GetElements("fn_x" + infix + "_resume");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->resume->FldCaption(), $job_submissions->resume->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cover_letter");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $job_submissions->cover_letter->FldCaption(), $job_submissions->cover_letter->ReqErrMsg)) ?>");

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
fjob_submissionsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fjob_submissionsedit.ValidateRequired = true;
<?php } else { ?>
fjob_submissionsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fjob_submissionsedit.Lists["x_position"] = {"LinkField":"x_job_vacancy_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_job_vacancy_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $job_submissions_edit->ShowPageHeader(); ?>
<?php
$job_submissions_edit->ShowMessage();
?>
<form name="fjob_submissionsedit" id="fjob_submissionsedit" class="<?php echo $job_submissions_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($job_submissions_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $job_submissions_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="job_submissions">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($job_submissions->job_submission_id->Visible) { // job_submission_id ?>
	<div id="r_job_submission_id" class="form-group">
		<label id="elh_job_submissions_job_submission_id" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->job_submission_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->job_submission_id->CellAttributes() ?>>
<span id="el_job_submissions_job_submission_id">
<span<?php echo $job_submissions->job_submission_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $job_submissions->job_submission_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="job_submissions" data-field="x_job_submission_id" name="x_job_submission_id" id="x_job_submission_id" value="<?php echo ew_HtmlEncode($job_submissions->job_submission_id->CurrentValue) ?>">
<?php echo $job_submissions->job_submission_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->first_name->Visible) { // first_name ?>
	<div id="r_first_name" class="form-group">
		<label id="elh_job_submissions_first_name" for="x_first_name" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->first_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->first_name->CellAttributes() ?>>
<span id="el_job_submissions_first_name">
<input type="text" data-table="job_submissions" data-field="x_first_name" name="x_first_name" id="x_first_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($job_submissions->first_name->getPlaceHolder()) ?>" value="<?php echo $job_submissions->first_name->EditValue ?>"<?php echo $job_submissions->first_name->EditAttributes() ?>>
</span>
<?php echo $job_submissions->first_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->last_name->Visible) { // last_name ?>
	<div id="r_last_name" class="form-group">
		<label id="elh_job_submissions_last_name" for="x_last_name" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->last_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->last_name->CellAttributes() ?>>
<span id="el_job_submissions_last_name">
<input type="text" data-table="job_submissions" data-field="x_last_name" name="x_last_name" id="x_last_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($job_submissions->last_name->getPlaceHolder()) ?>" value="<?php echo $job_submissions->last_name->EditValue ?>"<?php echo $job_submissions->last_name->EditAttributes() ?>>
</span>
<?php echo $job_submissions->last_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_job_submissions__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->_email->CellAttributes() ?>>
<span id="el_job_submissions__email">
<input type="text" data-table="job_submissions" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($job_submissions->_email->getPlaceHolder()) ?>" value="<?php echo $job_submissions->_email->EditValue ?>"<?php echo $job_submissions->_email->EditAttributes() ?>>
</span>
<?php echo $job_submissions->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_job_submissions_phone" for="x_phone" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->phone->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->phone->CellAttributes() ?>>
<span id="el_job_submissions_phone">
<input type="text" data-table="job_submissions" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($job_submissions->phone->getPlaceHolder()) ?>" value="<?php echo $job_submissions->phone->EditValue ?>"<?php echo $job_submissions->phone->EditAttributes() ?>>
</span>
<?php echo $job_submissions->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->position->Visible) { // position ?>
	<div id="r_position" class="form-group">
		<label id="elh_job_submissions_position" for="x_position" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->position->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->position->CellAttributes() ?>>
<span id="el_job_submissions_position">
<select data-table="job_submissions" data-field="x_position" data-value-separator="<?php echo ew_HtmlEncode(is_array($job_submissions->position->DisplayValueSeparator) ? json_encode($job_submissions->position->DisplayValueSeparator) : $job_submissions->position->DisplayValueSeparator) ?>" id="x_position" name="x_position"<?php echo $job_submissions->position->EditAttributes() ?>>
<?php
if (is_array($job_submissions->position->EditValue)) {
	$arwrk = $job_submissions->position->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($job_submissions->position->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $job_submissions->position->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($job_submissions->position->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($job_submissions->position->CurrentValue) ?>" selected><?php echo $job_submissions->position->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `job_vacancy_id`, `job_vacancy_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `job_vacancies`";
$sWhereWrk = "";
$job_submissions->position->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$job_submissions->position->LookupFilters += array("f0" => "`job_vacancy_id` = {filter_value}", "t0" => "19", "fn0" => "");
$sSqlWrk = "";
$job_submissions->Lookup_Selecting($job_submissions->position, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $job_submissions->position->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_position" id="s_x_position" value="<?php echo $job_submissions->position->LookupFilterQuery() ?>">
</span>
<?php echo $job_submissions->position->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->resume->Visible) { // resume ?>
	<div id="r_resume" class="form-group">
		<label id="elh_job_submissions_resume" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->resume->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->resume->CellAttributes() ?>>
<span id="el_job_submissions_resume">
<div id="fd_x_resume">
<span title="<?php echo $job_submissions->resume->FldTitle() ? $job_submissions->resume->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($job_submissions->resume->ReadOnly || $job_submissions->resume->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="job_submissions" data-field="x_resume" name="x_resume" id="x_resume"<?php echo $job_submissions->resume->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_resume" id= "fn_x_resume" value="<?php echo $job_submissions->resume->Upload->FileName ?>">
<?php if (@$_POST["fa_x_resume"] == "0") { ?>
<input type="hidden" name="fa_x_resume" id= "fa_x_resume" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_resume" id= "fa_x_resume" value="1">
<?php } ?>
<input type="hidden" name="fs_x_resume" id= "fs_x_resume" value="255">
<input type="hidden" name="fx_x_resume" id= "fx_x_resume" value="<?php echo $job_submissions->resume->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_resume" id= "fm_x_resume" value="<?php echo $job_submissions->resume->UploadMaxFileSize ?>">
</div>
<table id="ft_x_resume" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $job_submissions->resume->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($job_submissions->cover_letter->Visible) { // cover_letter ?>
	<div id="r_cover_letter" class="form-group">
		<label id="elh_job_submissions_cover_letter" for="x_cover_letter" class="col-sm-2 control-label ewLabel"><?php echo $job_submissions->cover_letter->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $job_submissions->cover_letter->CellAttributes() ?>>
<span id="el_job_submissions_cover_letter">
<input type="text" data-table="job_submissions" data-field="x_cover_letter" name="x_cover_letter" id="x_cover_letter" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($job_submissions->cover_letter->getPlaceHolder()) ?>" value="<?php echo $job_submissions->cover_letter->EditValue ?>"<?php echo $job_submissions->cover_letter->EditAttributes() ?>>
</span>
<?php echo $job_submissions->cover_letter->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $job_submissions_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fjob_submissionsedit.Init();
</script>
<?php
$job_submissions_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$job_submissions_edit->Page_Terminate();
?>
