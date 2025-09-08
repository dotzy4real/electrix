<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "feature_listsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$feature_lists_edit = NULL; // Initialize page object first

class cfeature_lists_edit extends cfeature_lists {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'feature_lists';

	// Page object name
	var $PageObjName = 'feature_lists_edit';

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

		// Table object (feature_lists)
		if (!isset($GLOBALS["feature_lists"]) || get_class($GLOBALS["feature_lists"]) == "cfeature_lists") {
			$GLOBALS["feature_lists"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["feature_lists"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'feature_lists', TRUE);

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
		$this->feature_list_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $feature_lists;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($feature_lists);
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
		if (@$_GET["feature_list_id"] <> "") {
			$this->feature_list_id->setQueryStringValue($_GET["feature_list_id"]);
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
		if ($this->feature_list_id->CurrentValue == "")
			$this->Page_Terminate("feature_listslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("feature_listslist.php"); // No matching record, return to list
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
		if (!$this->feature_list_id->FldIsDetailKey)
			$this->feature_list_id->setFormValue($objForm->GetValue("x_feature_list_id"));
		if (!$this->feature_list_title->FldIsDetailKey) {
			$this->feature_list_title->setFormValue($objForm->GetValue("x_feature_list_title"));
		}
		if (!$this->feature_list_snippet->FldIsDetailKey) {
			$this->feature_list_snippet->setFormValue($objForm->GetValue("x_feature_list_snippet"));
		}
		if (!$this->sort_order->FldIsDetailKey) {
			$this->sort_order->setFormValue($objForm->GetValue("x_sort_order"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->feature_list_id->CurrentValue = $this->feature_list_id->FormValue;
		$this->feature_list_title->CurrentValue = $this->feature_list_title->FormValue;
		$this->feature_list_snippet->CurrentValue = $this->feature_list_snippet->FormValue;
		$this->sort_order->CurrentValue = $this->sort_order->FormValue;
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
		$this->feature_list_id->setDbValue($rs->fields('feature_list_id'));
		$this->feature_list_title->setDbValue($rs->fields('feature_list_title'));
		$this->feature_list_snippet->setDbValue($rs->fields('feature_list_snippet'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->feature_list_id->DbValue = $row['feature_list_id'];
		$this->feature_list_title->DbValue = $row['feature_list_title'];
		$this->feature_list_snippet->DbValue = $row['feature_list_snippet'];
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
		// feature_list_id
		// feature_list_title
		// feature_list_snippet
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// feature_list_id
		$this->feature_list_id->ViewValue = $this->feature_list_id->CurrentValue;
		$this->feature_list_id->ViewCustomAttributes = "";

		// feature_list_title
		$this->feature_list_title->ViewValue = $this->feature_list_title->CurrentValue;
		$this->feature_list_title->ViewCustomAttributes = "";

		// feature_list_snippet
		$this->feature_list_snippet->ViewValue = $this->feature_list_snippet->CurrentValue;
		$this->feature_list_snippet->ViewCustomAttributes = "";

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

			// feature_list_id
			$this->feature_list_id->LinkCustomAttributes = "";
			$this->feature_list_id->HrefValue = "";
			$this->feature_list_id->TooltipValue = "";

			// feature_list_title
			$this->feature_list_title->LinkCustomAttributes = "";
			$this->feature_list_title->HrefValue = "";
			$this->feature_list_title->TooltipValue = "";

			// feature_list_snippet
			$this->feature_list_snippet->LinkCustomAttributes = "";
			$this->feature_list_snippet->HrefValue = "";
			$this->feature_list_snippet->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// feature_list_id
			$this->feature_list_id->EditAttrs["class"] = "form-control";
			$this->feature_list_id->EditCustomAttributes = "";
			$this->feature_list_id->EditValue = $this->feature_list_id->CurrentValue;
			$this->feature_list_id->ViewCustomAttributes = "";

			// feature_list_title
			$this->feature_list_title->EditAttrs["class"] = "form-control";
			$this->feature_list_title->EditCustomAttributes = "";
			$this->feature_list_title->EditValue = ew_HtmlEncode($this->feature_list_title->CurrentValue);
			$this->feature_list_title->PlaceHolder = ew_RemoveHtml($this->feature_list_title->FldCaption());

			// feature_list_snippet
			$this->feature_list_snippet->EditAttrs["class"] = "form-control";
			$this->feature_list_snippet->EditCustomAttributes = "";
			$this->feature_list_snippet->EditValue = ew_HtmlEncode($this->feature_list_snippet->CurrentValue);
			$this->feature_list_snippet->PlaceHolder = ew_RemoveHtml($this->feature_list_snippet->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// feature_list_id

			$this->feature_list_id->HrefValue = "";

			// feature_list_title
			$this->feature_list_title->HrefValue = "";

			// feature_list_snippet
			$this->feature_list_snippet->HrefValue = "";

			// sort_order
			$this->sort_order->HrefValue = "";

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
		if (!$this->feature_list_title->FldIsDetailKey && !is_null($this->feature_list_title->FormValue) && $this->feature_list_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->feature_list_title->FldCaption(), $this->feature_list_title->ReqErrMsg));
		}
		if (!$this->feature_list_snippet->FldIsDetailKey && !is_null($this->feature_list_snippet->FormValue) && $this->feature_list_snippet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->feature_list_snippet->FldCaption(), $this->feature_list_snippet->ReqErrMsg));
		}
		if (!$this->sort_order->FldIsDetailKey && !is_null($this->sort_order->FormValue) && $this->sort_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sort_order->FldCaption(), $this->sort_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sort_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->sort_order->FldErrMsg());
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

			// feature_list_title
			$this->feature_list_title->SetDbValueDef($rsnew, $this->feature_list_title->CurrentValue, "", $this->feature_list_title->ReadOnly);

			// feature_list_snippet
			$this->feature_list_snippet->SetDbValueDef($rsnew, $this->feature_list_snippet->CurrentValue, "", $this->feature_list_snippet->ReadOnly);

			// sort_order
			$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, $this->sort_order->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, "feature_listslist.php", "", $this->TableVar, TRUE);
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
if (!isset($feature_lists_edit)) $feature_lists_edit = new cfeature_lists_edit();

// Page init
$feature_lists_edit->Page_Init();

// Page main
$feature_lists_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$feature_lists_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ffeature_listsedit = new ew_Form("ffeature_listsedit", "edit");

// Validate form
ffeature_listsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_feature_list_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature_lists->feature_list_title->FldCaption(), $feature_lists->feature_list_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_feature_list_snippet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature_lists->feature_list_snippet->FldCaption(), $feature_lists->feature_list_snippet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature_lists->sort_order->FldCaption(), $feature_lists->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($feature_lists->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature_lists->status->FldCaption(), $feature_lists->status->ReqErrMsg)) ?>");

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
ffeature_listsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffeature_listsedit.ValidateRequired = true;
<?php } else { ?>
ffeature_listsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffeature_listsedit.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffeature_listsedit.Lists["x_status"].Options = <?php echo json_encode($feature_lists->status->Options()) ?>;

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
<?php $feature_lists_edit->ShowPageHeader(); ?>
<?php
$feature_lists_edit->ShowMessage();
?>
<form name="ffeature_listsedit" id="ffeature_listsedit" class="<?php echo $feature_lists_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($feature_lists_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $feature_lists_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="feature_lists">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($feature_lists->feature_list_id->Visible) { // feature_list_id ?>
	<div id="r_feature_list_id" class="form-group">
		<label id="elh_feature_lists_feature_list_id" class="col-sm-2 control-label ewLabel"><?php echo $feature_lists->feature_list_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $feature_lists->feature_list_id->CellAttributes() ?>>
<span id="el_feature_lists_feature_list_id">
<span<?php echo $feature_lists->feature_list_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature_lists->feature_list_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="feature_lists" data-field="x_feature_list_id" name="x_feature_list_id" id="x_feature_list_id" value="<?php echo ew_HtmlEncode($feature_lists->feature_list_id->CurrentValue) ?>">
<?php echo $feature_lists->feature_list_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature_lists->feature_list_title->Visible) { // feature_list_title ?>
	<div id="r_feature_list_title" class="form-group">
		<label id="elh_feature_lists_feature_list_title" for="x_feature_list_title" class="col-sm-2 control-label ewLabel"><?php echo $feature_lists->feature_list_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $feature_lists->feature_list_title->CellAttributes() ?>>
<span id="el_feature_lists_feature_list_title">
<input type="text" data-table="feature_lists" data-field="x_feature_list_title" name="x_feature_list_title" id="x_feature_list_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($feature_lists->feature_list_title->getPlaceHolder()) ?>" value="<?php echo $feature_lists->feature_list_title->EditValue ?>"<?php echo $feature_lists->feature_list_title->EditAttributes() ?>>
</span>
<?php echo $feature_lists->feature_list_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature_lists->feature_list_snippet->Visible) { // feature_list_snippet ?>
	<div id="r_feature_list_snippet" class="form-group">
		<label id="elh_feature_lists_feature_list_snippet" for="x_feature_list_snippet" class="col-sm-2 control-label ewLabel"><?php echo $feature_lists->feature_list_snippet->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $feature_lists->feature_list_snippet->CellAttributes() ?>>
<span id="el_feature_lists_feature_list_snippet">
<textarea data-table="feature_lists" data-field="x_feature_list_snippet" name="x_feature_list_snippet" id="x_feature_list_snippet" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($feature_lists->feature_list_snippet->getPlaceHolder()) ?>"<?php echo $feature_lists->feature_list_snippet->EditAttributes() ?>><?php echo $feature_lists->feature_list_snippet->EditValue ?></textarea>
</span>
<?php echo $feature_lists->feature_list_snippet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature_lists->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_feature_lists_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $feature_lists->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $feature_lists->sort_order->CellAttributes() ?>>
<span id="el_feature_lists_sort_order">
<input type="text" data-table="feature_lists" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($feature_lists->sort_order->getPlaceHolder()) ?>" value="<?php echo $feature_lists->sort_order->EditValue ?>"<?php echo $feature_lists->sort_order->EditAttributes() ?>>
</span>
<?php echo $feature_lists->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature_lists->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_feature_lists_status" class="col-sm-2 control-label ewLabel"><?php echo $feature_lists->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $feature_lists->status->CellAttributes() ?>>
<span id="el_feature_lists_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="feature_lists" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($feature_lists->status->DisplayValueSeparator) ? json_encode($feature_lists->status->DisplayValueSeparator) : $feature_lists->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $feature_lists->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $feature_lists->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($feature_lists->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="feature_lists" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $feature_lists->status->EditAttributes() ?>><?php echo $feature_lists->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($feature_lists->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="feature_lists" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($feature_lists->status->CurrentValue) ?>" checked<?php echo $feature_lists->status->EditAttributes() ?>><?php echo $feature_lists->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $feature_lists->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $feature_lists_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
ffeature_listsedit.Init();
</script>
<?php
$feature_lists_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$feature_lists_edit->Page_Terminate();
?>
