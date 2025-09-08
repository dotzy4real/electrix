<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "armese_capabilitiesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$armese_capabilities_edit = NULL; // Initialize page object first

class carmese_capabilities_edit extends carmese_capabilities {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'armese_capabilities';

	// Page object name
	var $PageObjName = 'armese_capabilities_edit';

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

		// Table object (armese_capabilities)
		if (!isset($GLOBALS["armese_capabilities"]) || get_class($GLOBALS["armese_capabilities"]) == "carmese_capabilities") {
			$GLOBALS["armese_capabilities"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["armese_capabilities"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'armese_capabilities', TRUE);

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
		$this->armese_capability_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $armese_capabilities;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($armese_capabilities);
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
		if (@$_GET["armese_capability_id"] <> "") {
			$this->armese_capability_id->setQueryStringValue($_GET["armese_capability_id"]);
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
		if ($this->armese_capability_id->CurrentValue == "")
			$this->Page_Terminate("armese_capabilitieslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("armese_capabilitieslist.php"); // No matching record, return to list
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
		if (!$this->armese_capability_id->FldIsDetailKey)
			$this->armese_capability_id->setFormValue($objForm->GetValue("x_armese_capability_id"));
		if (!$this->armese_capability_title->FldIsDetailKey) {
			$this->armese_capability_title->setFormValue($objForm->GetValue("x_armese_capability_title"));
		}
		if (!$this->armese_capability_content->FldIsDetailKey) {
			$this->armese_capability_content->setFormValue($objForm->GetValue("x_armese_capability_content"));
		}
		if (!$this->armese_capability_icon->FldIsDetailKey) {
			$this->armese_capability_icon->setFormValue($objForm->GetValue("x_armese_capability_icon"));
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
		$this->armese_capability_id->CurrentValue = $this->armese_capability_id->FormValue;
		$this->armese_capability_title->CurrentValue = $this->armese_capability_title->FormValue;
		$this->armese_capability_content->CurrentValue = $this->armese_capability_content->FormValue;
		$this->armese_capability_icon->CurrentValue = $this->armese_capability_icon->FormValue;
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
		$this->armese_capability_id->setDbValue($rs->fields('armese_capability_id'));
		$this->armese_capability_title->setDbValue($rs->fields('armese_capability_title'));
		$this->armese_capability_content->setDbValue($rs->fields('armese_capability_content'));
		$this->armese_capability_icon->setDbValue($rs->fields('armese_capability_icon'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->armese_capability_id->DbValue = $row['armese_capability_id'];
		$this->armese_capability_title->DbValue = $row['armese_capability_title'];
		$this->armese_capability_content->DbValue = $row['armese_capability_content'];
		$this->armese_capability_icon->DbValue = $row['armese_capability_icon'];
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
		// armese_capability_id
		// armese_capability_title
		// armese_capability_content
		// armese_capability_icon
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// armese_capability_id
		$this->armese_capability_id->ViewValue = $this->armese_capability_id->CurrentValue;
		$this->armese_capability_id->ViewCustomAttributes = "";

		// armese_capability_title
		$this->armese_capability_title->ViewValue = $this->armese_capability_title->CurrentValue;
		$this->armese_capability_title->ViewCustomAttributes = "";

		// armese_capability_content
		$this->armese_capability_content->ViewValue = $this->armese_capability_content->CurrentValue;
		$this->armese_capability_content->ViewCustomAttributes = "";

		// armese_capability_icon
		if (strval($this->armese_capability_icon->CurrentValue) <> "") {
			$this->armese_capability_icon->ViewValue = $this->armese_capability_icon->OptionCaption($this->armese_capability_icon->CurrentValue);
		} else {
			$this->armese_capability_icon->ViewValue = NULL;
		}
		$this->armese_capability_icon->ViewCustomAttributes = "";

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

			// armese_capability_id
			$this->armese_capability_id->LinkCustomAttributes = "";
			$this->armese_capability_id->HrefValue = "";
			$this->armese_capability_id->TooltipValue = "";

			// armese_capability_title
			$this->armese_capability_title->LinkCustomAttributes = "";
			$this->armese_capability_title->HrefValue = "";
			$this->armese_capability_title->TooltipValue = "";

			// armese_capability_content
			$this->armese_capability_content->LinkCustomAttributes = "";
			$this->armese_capability_content->HrefValue = "";
			$this->armese_capability_content->TooltipValue = "";

			// armese_capability_icon
			$this->armese_capability_icon->LinkCustomAttributes = "";
			$this->armese_capability_icon->HrefValue = "";
			$this->armese_capability_icon->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// armese_capability_id
			$this->armese_capability_id->EditAttrs["class"] = "form-control";
			$this->armese_capability_id->EditCustomAttributes = "";
			$this->armese_capability_id->EditValue = $this->armese_capability_id->CurrentValue;
			$this->armese_capability_id->ViewCustomAttributes = "";

			// armese_capability_title
			$this->armese_capability_title->EditAttrs["class"] = "form-control";
			$this->armese_capability_title->EditCustomAttributes = "";
			$this->armese_capability_title->EditValue = ew_HtmlEncode($this->armese_capability_title->CurrentValue);
			$this->armese_capability_title->PlaceHolder = ew_RemoveHtml($this->armese_capability_title->FldCaption());

			// armese_capability_content
			$this->armese_capability_content->EditAttrs["class"] = "form-control";
			$this->armese_capability_content->EditCustomAttributes = "";
			$this->armese_capability_content->EditValue = ew_HtmlEncode($this->armese_capability_content->CurrentValue);
			$this->armese_capability_content->PlaceHolder = ew_RemoveHtml($this->armese_capability_content->FldCaption());

			// armese_capability_icon
			$this->armese_capability_icon->EditAttrs["class"] = "form-control";
			$this->armese_capability_icon->EditCustomAttributes = "";
			$this->armese_capability_icon->EditValue = $this->armese_capability_icon->Options(TRUE);

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// Edit refer script
			// armese_capability_id

			$this->armese_capability_id->HrefValue = "";

			// armese_capability_title
			$this->armese_capability_title->HrefValue = "";

			// armese_capability_content
			$this->armese_capability_content->HrefValue = "";

			// armese_capability_icon
			$this->armese_capability_icon->HrefValue = "";

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
		if (!$this->armese_capability_title->FldIsDetailKey && !is_null($this->armese_capability_title->FormValue) && $this->armese_capability_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->armese_capability_title->FldCaption(), $this->armese_capability_title->ReqErrMsg));
		}
		if (!$this->armese_capability_content->FldIsDetailKey && !is_null($this->armese_capability_content->FormValue) && $this->armese_capability_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->armese_capability_content->FldCaption(), $this->armese_capability_content->ReqErrMsg));
		}
		if (!$this->armese_capability_icon->FldIsDetailKey && !is_null($this->armese_capability_icon->FormValue) && $this->armese_capability_icon->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->armese_capability_icon->FldCaption(), $this->armese_capability_icon->ReqErrMsg));
		}
		if (!$this->sort_order->FldIsDetailKey && !is_null($this->sort_order->FormValue) && $this->sort_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sort_order->FldCaption(), $this->sort_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sort_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->sort_order->FldErrMsg());
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
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

			// armese_capability_title
			$this->armese_capability_title->SetDbValueDef($rsnew, $this->armese_capability_title->CurrentValue, "", $this->armese_capability_title->ReadOnly);

			// armese_capability_content
			$this->armese_capability_content->SetDbValueDef($rsnew, $this->armese_capability_content->CurrentValue, "", $this->armese_capability_content->ReadOnly);

			// armese_capability_icon
			$this->armese_capability_icon->SetDbValueDef($rsnew, $this->armese_capability_icon->CurrentValue, "", $this->armese_capability_icon->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, "armese_capabilitieslist.php", "", $this->TableVar, TRUE);
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
if (!isset($armese_capabilities_edit)) $armese_capabilities_edit = new carmese_capabilities_edit();

// Page init
$armese_capabilities_edit->Page_Init();

// Page main
$armese_capabilities_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$armese_capabilities_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = farmese_capabilitiesedit = new ew_Form("farmese_capabilitiesedit", "edit");

// Validate form
farmese_capabilitiesedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_armese_capability_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $armese_capabilities->armese_capability_title->FldCaption(), $armese_capabilities->armese_capability_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_armese_capability_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $armese_capabilities->armese_capability_content->FldCaption(), $armese_capabilities->armese_capability_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_armese_capability_icon");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $armese_capabilities->armese_capability_icon->FldCaption(), $armese_capabilities->armese_capability_icon->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $armese_capabilities->sort_order->FldCaption(), $armese_capabilities->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($armese_capabilities->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $armese_capabilities->status->FldCaption(), $armese_capabilities->status->ReqErrMsg)) ?>");

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
farmese_capabilitiesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
farmese_capabilitiesedit.ValidateRequired = true;
<?php } else { ?>
farmese_capabilitiesedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
farmese_capabilitiesedit.Lists["x_armese_capability_icon"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_capabilitiesedit.Lists["x_armese_capability_icon"].Options = <?php echo json_encode($armese_capabilities->armese_capability_icon->Options()) ?>;
farmese_capabilitiesedit.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_capabilitiesedit.Lists["x_status"].Options = <?php echo json_encode($armese_capabilities->status->Options()) ?>;

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
<?php $armese_capabilities_edit->ShowPageHeader(); ?>
<?php
$armese_capabilities_edit->ShowMessage();
?>
<form name="farmese_capabilitiesedit" id="farmese_capabilitiesedit" class="<?php echo $armese_capabilities_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($armese_capabilities_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $armese_capabilities_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="armese_capabilities">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($armese_capabilities->armese_capability_id->Visible) { // armese_capability_id ?>
	<div id="r_armese_capability_id" class="form-group">
		<label id="elh_armese_capabilities_armese_capability_id" class="col-sm-2 control-label ewLabel"><?php echo $armese_capabilities->armese_capability_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $armese_capabilities->armese_capability_id->CellAttributes() ?>>
<span id="el_armese_capabilities_armese_capability_id">
<span<?php echo $armese_capabilities->armese_capability_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $armese_capabilities->armese_capability_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="armese_capabilities" data-field="x_armese_capability_id" name="x_armese_capability_id" id="x_armese_capability_id" value="<?php echo ew_HtmlEncode($armese_capabilities->armese_capability_id->CurrentValue) ?>">
<?php echo $armese_capabilities->armese_capability_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($armese_capabilities->armese_capability_title->Visible) { // armese_capability_title ?>
	<div id="r_armese_capability_title" class="form-group">
		<label id="elh_armese_capabilities_armese_capability_title" for="x_armese_capability_title" class="col-sm-2 control-label ewLabel"><?php echo $armese_capabilities->armese_capability_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $armese_capabilities->armese_capability_title->CellAttributes() ?>>
<span id="el_armese_capabilities_armese_capability_title">
<input type="text" data-table="armese_capabilities" data-field="x_armese_capability_title" name="x_armese_capability_title" id="x_armese_capability_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($armese_capabilities->armese_capability_title->getPlaceHolder()) ?>" value="<?php echo $armese_capabilities->armese_capability_title->EditValue ?>"<?php echo $armese_capabilities->armese_capability_title->EditAttributes() ?>>
</span>
<?php echo $armese_capabilities->armese_capability_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($armese_capabilities->armese_capability_content->Visible) { // armese_capability_content ?>
	<div id="r_armese_capability_content" class="form-group">
		<label id="elh_armese_capabilities_armese_capability_content" for="x_armese_capability_content" class="col-sm-2 control-label ewLabel"><?php echo $armese_capabilities->armese_capability_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $armese_capabilities->armese_capability_content->CellAttributes() ?>>
<span id="el_armese_capabilities_armese_capability_content">
<textarea data-table="armese_capabilities" data-field="x_armese_capability_content" name="x_armese_capability_content" id="x_armese_capability_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($armese_capabilities->armese_capability_content->getPlaceHolder()) ?>"<?php echo $armese_capabilities->armese_capability_content->EditAttributes() ?>><?php echo $armese_capabilities->armese_capability_content->EditValue ?></textarea>
</span>
<?php echo $armese_capabilities->armese_capability_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($armese_capabilities->armese_capability_icon->Visible) { // armese_capability_icon ?>
	<div id="r_armese_capability_icon" class="form-group">
		<label id="elh_armese_capabilities_armese_capability_icon" for="x_armese_capability_icon" class="col-sm-2 control-label ewLabel"><?php echo $armese_capabilities->armese_capability_icon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $armese_capabilities->armese_capability_icon->CellAttributes() ?>>
<span id="el_armese_capabilities_armese_capability_icon">
<select data-table="armese_capabilities" data-field="x_armese_capability_icon" data-value-separator="<?php echo ew_HtmlEncode(is_array($armese_capabilities->armese_capability_icon->DisplayValueSeparator) ? json_encode($armese_capabilities->armese_capability_icon->DisplayValueSeparator) : $armese_capabilities->armese_capability_icon->DisplayValueSeparator) ?>" id="x_armese_capability_icon" name="x_armese_capability_icon"<?php echo $armese_capabilities->armese_capability_icon->EditAttributes() ?>>
<?php
if (is_array($armese_capabilities->armese_capability_icon->EditValue)) {
	$arwrk = $armese_capabilities->armese_capability_icon->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($armese_capabilities->armese_capability_icon->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $armese_capabilities->armese_capability_icon->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($armese_capabilities->armese_capability_icon->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($armese_capabilities->armese_capability_icon->CurrentValue) ?>" selected><?php echo $armese_capabilities->armese_capability_icon->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $armese_capabilities->armese_capability_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($armese_capabilities->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_armese_capabilities_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $armese_capabilities->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $armese_capabilities->sort_order->CellAttributes() ?>>
<span id="el_armese_capabilities_sort_order">
<input type="text" data-table="armese_capabilities" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($armese_capabilities->sort_order->getPlaceHolder()) ?>" value="<?php echo $armese_capabilities->sort_order->EditValue ?>"<?php echo $armese_capabilities->sort_order->EditAttributes() ?>>
</span>
<?php echo $armese_capabilities->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($armese_capabilities->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_armese_capabilities_status" for="x_status" class="col-sm-2 control-label ewLabel"><?php echo $armese_capabilities->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $armese_capabilities->status->CellAttributes() ?>>
<span id="el_armese_capabilities_status">
<select data-table="armese_capabilities" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($armese_capabilities->status->DisplayValueSeparator) ? json_encode($armese_capabilities->status->DisplayValueSeparator) : $armese_capabilities->status->DisplayValueSeparator) ?>" id="x_status" name="x_status"<?php echo $armese_capabilities->status->EditAttributes() ?>>
<?php
if (is_array($armese_capabilities->status->EditValue)) {
	$arwrk = $armese_capabilities->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($armese_capabilities->status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $armese_capabilities->status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($armese_capabilities->status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($armese_capabilities->status->CurrentValue) ?>" selected><?php echo $armese_capabilities->status->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $armese_capabilities->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $armese_capabilities_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
farmese_capabilitiesedit.Init();
</script>
<?php
$armese_capabilities_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$armese_capabilities_edit->Page_Terminate();
?>
