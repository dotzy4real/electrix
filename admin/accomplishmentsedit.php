<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "accomplishmentsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$accomplishments_edit = NULL; // Initialize page object first

class caccomplishments_edit extends caccomplishments {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'accomplishments';

	// Page object name
	var $PageObjName = 'accomplishments_edit';

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

		// Table object (accomplishments)
		if (!isset($GLOBALS["accomplishments"]) || get_class($GLOBALS["accomplishments"]) == "caccomplishments") {
			$GLOBALS["accomplishments"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["accomplishments"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'accomplishments', TRUE);

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
		$this->accomplishment_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $accomplishments;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($accomplishments);
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
		if (@$_GET["accomplishment_id"] <> "") {
			$this->accomplishment_id->setQueryStringValue($_GET["accomplishment_id"]);
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
		if ($this->accomplishment_id->CurrentValue == "")
			$this->Page_Terminate("accomplishmentslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("accomplishmentslist.php"); // No matching record, return to list
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
		if (!$this->accomplishment_id->FldIsDetailKey)
			$this->accomplishment_id->setFormValue($objForm->GetValue("x_accomplishment_id"));
		if (!$this->years_of_experience->FldIsDetailKey) {
			$this->years_of_experience->setFormValue($objForm->GetValue("x_years_of_experience"));
		}
		if (!$this->satisfied_clients->FldIsDetailKey) {
			$this->satisfied_clients->setFormValue($objForm->GetValue("x_satisfied_clients"));
		}
		if (!$this->projects_complete->FldIsDetailKey) {
			$this->projects_complete->setFormValue($objForm->GetValue("x_projects_complete"));
		}
		if (!$this->awards_winning->FldIsDetailKey) {
			$this->awards_winning->setFormValue($objForm->GetValue("x_awards_winning"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->accomplishment_id->CurrentValue = $this->accomplishment_id->FormValue;
		$this->years_of_experience->CurrentValue = $this->years_of_experience->FormValue;
		$this->satisfied_clients->CurrentValue = $this->satisfied_clients->FormValue;
		$this->projects_complete->CurrentValue = $this->projects_complete->FormValue;
		$this->awards_winning->CurrentValue = $this->awards_winning->FormValue;
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
		$this->accomplishment_id->setDbValue($rs->fields('accomplishment_id'));
		$this->years_of_experience->setDbValue($rs->fields('years_of_experience'));
		$this->satisfied_clients->setDbValue($rs->fields('satisfied_clients'));
		$this->projects_complete->setDbValue($rs->fields('projects_complete'));
		$this->awards_winning->setDbValue($rs->fields('awards_winning'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->accomplishment_id->DbValue = $row['accomplishment_id'];
		$this->years_of_experience->DbValue = $row['years_of_experience'];
		$this->satisfied_clients->DbValue = $row['satisfied_clients'];
		$this->projects_complete->DbValue = $row['projects_complete'];
		$this->awards_winning->DbValue = $row['awards_winning'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// accomplishment_id
		// years_of_experience
		// satisfied_clients
		// projects_complete
		// awards_winning

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// accomplishment_id
		$this->accomplishment_id->ViewValue = $this->accomplishment_id->CurrentValue;
		$this->accomplishment_id->ViewCustomAttributes = "";

		// years_of_experience
		$this->years_of_experience->ViewValue = $this->years_of_experience->CurrentValue;
		$this->years_of_experience->ViewCustomAttributes = "";

		// satisfied_clients
		$this->satisfied_clients->ViewValue = $this->satisfied_clients->CurrentValue;
		$this->satisfied_clients->ViewCustomAttributes = "";

		// projects_complete
		$this->projects_complete->ViewValue = $this->projects_complete->CurrentValue;
		$this->projects_complete->ViewCustomAttributes = "";

		// awards_winning
		$this->awards_winning->ViewValue = $this->awards_winning->CurrentValue;
		$this->awards_winning->ViewCustomAttributes = "";

			// accomplishment_id
			$this->accomplishment_id->LinkCustomAttributes = "";
			$this->accomplishment_id->HrefValue = "";
			$this->accomplishment_id->TooltipValue = "";

			// years_of_experience
			$this->years_of_experience->LinkCustomAttributes = "";
			$this->years_of_experience->HrefValue = "";
			$this->years_of_experience->TooltipValue = "";

			// satisfied_clients
			$this->satisfied_clients->LinkCustomAttributes = "";
			$this->satisfied_clients->HrefValue = "";
			$this->satisfied_clients->TooltipValue = "";

			// projects_complete
			$this->projects_complete->LinkCustomAttributes = "";
			$this->projects_complete->HrefValue = "";
			$this->projects_complete->TooltipValue = "";

			// awards_winning
			$this->awards_winning->LinkCustomAttributes = "";
			$this->awards_winning->HrefValue = "";
			$this->awards_winning->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// accomplishment_id
			$this->accomplishment_id->EditAttrs["class"] = "form-control";
			$this->accomplishment_id->EditCustomAttributes = "";
			$this->accomplishment_id->EditValue = $this->accomplishment_id->CurrentValue;
			$this->accomplishment_id->ViewCustomAttributes = "";

			// years_of_experience
			$this->years_of_experience->EditAttrs["class"] = "form-control";
			$this->years_of_experience->EditCustomAttributes = "";
			$this->years_of_experience->EditValue = ew_HtmlEncode($this->years_of_experience->CurrentValue);
			$this->years_of_experience->PlaceHolder = ew_RemoveHtml($this->years_of_experience->FldCaption());

			// satisfied_clients
			$this->satisfied_clients->EditAttrs["class"] = "form-control";
			$this->satisfied_clients->EditCustomAttributes = "";
			$this->satisfied_clients->EditValue = ew_HtmlEncode($this->satisfied_clients->CurrentValue);
			$this->satisfied_clients->PlaceHolder = ew_RemoveHtml($this->satisfied_clients->FldCaption());

			// projects_complete
			$this->projects_complete->EditAttrs["class"] = "form-control";
			$this->projects_complete->EditCustomAttributes = "";
			$this->projects_complete->EditValue = ew_HtmlEncode($this->projects_complete->CurrentValue);
			$this->projects_complete->PlaceHolder = ew_RemoveHtml($this->projects_complete->FldCaption());

			// awards_winning
			$this->awards_winning->EditAttrs["class"] = "form-control";
			$this->awards_winning->EditCustomAttributes = "";
			$this->awards_winning->EditValue = ew_HtmlEncode($this->awards_winning->CurrentValue);
			$this->awards_winning->PlaceHolder = ew_RemoveHtml($this->awards_winning->FldCaption());

			// Edit refer script
			// accomplishment_id

			$this->accomplishment_id->HrefValue = "";

			// years_of_experience
			$this->years_of_experience->HrefValue = "";

			// satisfied_clients
			$this->satisfied_clients->HrefValue = "";

			// projects_complete
			$this->projects_complete->HrefValue = "";

			// awards_winning
			$this->awards_winning->HrefValue = "";
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
		if (!$this->years_of_experience->FldIsDetailKey && !is_null($this->years_of_experience->FormValue) && $this->years_of_experience->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->years_of_experience->FldCaption(), $this->years_of_experience->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->years_of_experience->FormValue)) {
			ew_AddMessage($gsFormError, $this->years_of_experience->FldErrMsg());
		}
		if (!$this->satisfied_clients->FldIsDetailKey && !is_null($this->satisfied_clients->FormValue) && $this->satisfied_clients->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->satisfied_clients->FldCaption(), $this->satisfied_clients->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->satisfied_clients->FormValue)) {
			ew_AddMessage($gsFormError, $this->satisfied_clients->FldErrMsg());
		}
		if (!$this->projects_complete->FldIsDetailKey && !is_null($this->projects_complete->FormValue) && $this->projects_complete->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->projects_complete->FldCaption(), $this->projects_complete->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->projects_complete->FormValue)) {
			ew_AddMessage($gsFormError, $this->projects_complete->FldErrMsg());
		}
		if (!$this->awards_winning->FldIsDetailKey && !is_null($this->awards_winning->FormValue) && $this->awards_winning->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->awards_winning->FldCaption(), $this->awards_winning->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->awards_winning->FormValue)) {
			ew_AddMessage($gsFormError, $this->awards_winning->FldErrMsg());
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

			// years_of_experience
			$this->years_of_experience->SetDbValueDef($rsnew, $this->years_of_experience->CurrentValue, 0, $this->years_of_experience->ReadOnly);

			// satisfied_clients
			$this->satisfied_clients->SetDbValueDef($rsnew, $this->satisfied_clients->CurrentValue, 0, $this->satisfied_clients->ReadOnly);

			// projects_complete
			$this->projects_complete->SetDbValueDef($rsnew, $this->projects_complete->CurrentValue, 0, $this->projects_complete->ReadOnly);

			// awards_winning
			$this->awards_winning->SetDbValueDef($rsnew, $this->awards_winning->CurrentValue, 0, $this->awards_winning->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, "accomplishmentslist.php", "", $this->TableVar, TRUE);
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
if (!isset($accomplishments_edit)) $accomplishments_edit = new caccomplishments_edit();

// Page init
$accomplishments_edit->Page_Init();

// Page main
$accomplishments_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$accomplishments_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = faccomplishmentsedit = new ew_Form("faccomplishmentsedit", "edit");

// Validate form
faccomplishmentsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_years_of_experience");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $accomplishments->years_of_experience->FldCaption(), $accomplishments->years_of_experience->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_years_of_experience");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($accomplishments->years_of_experience->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_satisfied_clients");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $accomplishments->satisfied_clients->FldCaption(), $accomplishments->satisfied_clients->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_satisfied_clients");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($accomplishments->satisfied_clients->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_projects_complete");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $accomplishments->projects_complete->FldCaption(), $accomplishments->projects_complete->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_projects_complete");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($accomplishments->projects_complete->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_awards_winning");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $accomplishments->awards_winning->FldCaption(), $accomplishments->awards_winning->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_awards_winning");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($accomplishments->awards_winning->FldErrMsg()) ?>");

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
faccomplishmentsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faccomplishmentsedit.ValidateRequired = true;
<?php } else { ?>
faccomplishmentsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $accomplishments_edit->ShowPageHeader(); ?>
<?php
$accomplishments_edit->ShowMessage();
?>
<form name="faccomplishmentsedit" id="faccomplishmentsedit" class="<?php echo $accomplishments_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($accomplishments_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $accomplishments_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="accomplishments">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($accomplishments->accomplishment_id->Visible) { // accomplishment_id ?>
	<div id="r_accomplishment_id" class="form-group">
		<label id="elh_accomplishments_accomplishment_id" class="col-sm-2 control-label ewLabel"><?php echo $accomplishments->accomplishment_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $accomplishments->accomplishment_id->CellAttributes() ?>>
<span id="el_accomplishments_accomplishment_id">
<span<?php echo $accomplishments->accomplishment_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $accomplishments->accomplishment_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="accomplishments" data-field="x_accomplishment_id" name="x_accomplishment_id" id="x_accomplishment_id" value="<?php echo ew_HtmlEncode($accomplishments->accomplishment_id->CurrentValue) ?>">
<?php echo $accomplishments->accomplishment_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($accomplishments->years_of_experience->Visible) { // years_of_experience ?>
	<div id="r_years_of_experience" class="form-group">
		<label id="elh_accomplishments_years_of_experience" for="x_years_of_experience" class="col-sm-2 control-label ewLabel"><?php echo $accomplishments->years_of_experience->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $accomplishments->years_of_experience->CellAttributes() ?>>
<span id="el_accomplishments_years_of_experience">
<input type="text" data-table="accomplishments" data-field="x_years_of_experience" name="x_years_of_experience" id="x_years_of_experience" size="30" placeholder="<?php echo ew_HtmlEncode($accomplishments->years_of_experience->getPlaceHolder()) ?>" value="<?php echo $accomplishments->years_of_experience->EditValue ?>"<?php echo $accomplishments->years_of_experience->EditAttributes() ?>>
</span>
<?php echo $accomplishments->years_of_experience->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($accomplishments->satisfied_clients->Visible) { // satisfied_clients ?>
	<div id="r_satisfied_clients" class="form-group">
		<label id="elh_accomplishments_satisfied_clients" for="x_satisfied_clients" class="col-sm-2 control-label ewLabel"><?php echo $accomplishments->satisfied_clients->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $accomplishments->satisfied_clients->CellAttributes() ?>>
<span id="el_accomplishments_satisfied_clients">
<input type="text" data-table="accomplishments" data-field="x_satisfied_clients" name="x_satisfied_clients" id="x_satisfied_clients" size="30" placeholder="<?php echo ew_HtmlEncode($accomplishments->satisfied_clients->getPlaceHolder()) ?>" value="<?php echo $accomplishments->satisfied_clients->EditValue ?>"<?php echo $accomplishments->satisfied_clients->EditAttributes() ?>>
</span>
<?php echo $accomplishments->satisfied_clients->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($accomplishments->projects_complete->Visible) { // projects_complete ?>
	<div id="r_projects_complete" class="form-group">
		<label id="elh_accomplishments_projects_complete" for="x_projects_complete" class="col-sm-2 control-label ewLabel"><?php echo $accomplishments->projects_complete->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $accomplishments->projects_complete->CellAttributes() ?>>
<span id="el_accomplishments_projects_complete">
<input type="text" data-table="accomplishments" data-field="x_projects_complete" name="x_projects_complete" id="x_projects_complete" size="30" placeholder="<?php echo ew_HtmlEncode($accomplishments->projects_complete->getPlaceHolder()) ?>" value="<?php echo $accomplishments->projects_complete->EditValue ?>"<?php echo $accomplishments->projects_complete->EditAttributes() ?>>
</span>
<?php echo $accomplishments->projects_complete->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($accomplishments->awards_winning->Visible) { // awards_winning ?>
	<div id="r_awards_winning" class="form-group">
		<label id="elh_accomplishments_awards_winning" for="x_awards_winning" class="col-sm-2 control-label ewLabel"><?php echo $accomplishments->awards_winning->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $accomplishments->awards_winning->CellAttributes() ?>>
<span id="el_accomplishments_awards_winning">
<input type="text" data-table="accomplishments" data-field="x_awards_winning" name="x_awards_winning" id="x_awards_winning" size="30" placeholder="<?php echo ew_HtmlEncode($accomplishments->awards_winning->getPlaceHolder()) ?>" value="<?php echo $accomplishments->awards_winning->EditValue ?>"<?php echo $accomplishments->awards_winning->EditAttributes() ?>>
</span>
<?php echo $accomplishments->awards_winning->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $accomplishments_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
faccomplishmentsedit.Init();
</script>
<?php
$accomplishments_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$accomplishments_edit->Page_Terminate();
?>
