<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "msmsl_choose_us_itemsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$msmsl_choose_us_items_add = NULL; // Initialize page object first

class cmsmsl_choose_us_items_add extends cmsmsl_choose_us_items {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'msmsl_choose_us_items';

	// Page object name
	var $PageObjName = 'msmsl_choose_us_items_add';

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

		// Table object (msmsl_choose_us_items)
		if (!isset($GLOBALS["msmsl_choose_us_items"]) || get_class($GLOBALS["msmsl_choose_us_items"]) == "cmsmsl_choose_us_items") {
			$GLOBALS["msmsl_choose_us_items"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["msmsl_choose_us_items"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'msmsl_choose_us_items', TRUE);

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
		global $EW_EXPORT, $msmsl_choose_us_items;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($msmsl_choose_us_items);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["msmsl_choose_us_item_id"] != "") {
				$this->msmsl_choose_us_item_id->setQueryStringValue($_GET["msmsl_choose_us_item_id"]);
				$this->setKey("msmsl_choose_us_item_id", $this->msmsl_choose_us_item_id->CurrentValue); // Set up key
			} else {
				$this->setKey("msmsl_choose_us_item_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("msmsl_choose_us_itemslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "msmsl_choose_us_itemsview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->msmsl_choose_us_item_title->CurrentValue = NULL;
		$this->msmsl_choose_us_item_title->OldValue = $this->msmsl_choose_us_item_title->CurrentValue;
		$this->msmsl_choose_us_item_snippet->CurrentValue = NULL;
		$this->msmsl_choose_us_item_snippet->OldValue = $this->msmsl_choose_us_item_snippet->CurrentValue;
		$this->msmsl_choose_us_item_icon->CurrentValue = NULL;
		$this->msmsl_choose_us_item_icon->OldValue = $this->msmsl_choose_us_item_icon->CurrentValue;
		$this->status->CurrentValue = "active";
		$this->sort_order->CurrentValue = NULL;
		$this->sort_order->OldValue = $this->sort_order->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->msmsl_choose_us_item_title->FldIsDetailKey) {
			$this->msmsl_choose_us_item_title->setFormValue($objForm->GetValue("x_msmsl_choose_us_item_title"));
		}
		if (!$this->msmsl_choose_us_item_snippet->FldIsDetailKey) {
			$this->msmsl_choose_us_item_snippet->setFormValue($objForm->GetValue("x_msmsl_choose_us_item_snippet"));
		}
		if (!$this->msmsl_choose_us_item_icon->FldIsDetailKey) {
			$this->msmsl_choose_us_item_icon->setFormValue($objForm->GetValue("x_msmsl_choose_us_item_icon"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->sort_order->FldIsDetailKey) {
			$this->sort_order->setFormValue($objForm->GetValue("x_sort_order"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->msmsl_choose_us_item_title->CurrentValue = $this->msmsl_choose_us_item_title->FormValue;
		$this->msmsl_choose_us_item_snippet->CurrentValue = $this->msmsl_choose_us_item_snippet->FormValue;
		$this->msmsl_choose_us_item_icon->CurrentValue = $this->msmsl_choose_us_item_icon->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->sort_order->CurrentValue = $this->sort_order->FormValue;
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
		$this->msmsl_choose_us_item_id->setDbValue($rs->fields('msmsl_choose_us_item_id'));
		$this->msmsl_choose_us_item_title->setDbValue($rs->fields('msmsl_choose_us_item_title'));
		$this->msmsl_choose_us_item_snippet->setDbValue($rs->fields('msmsl_choose_us_item_snippet'));
		$this->msmsl_choose_us_item_icon->setDbValue($rs->fields('msmsl_choose_us_item_icon'));
		$this->status->setDbValue($rs->fields('status'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->msmsl_choose_us_item_id->DbValue = $row['msmsl_choose_us_item_id'];
		$this->msmsl_choose_us_item_title->DbValue = $row['msmsl_choose_us_item_title'];
		$this->msmsl_choose_us_item_snippet->DbValue = $row['msmsl_choose_us_item_snippet'];
		$this->msmsl_choose_us_item_icon->DbValue = $row['msmsl_choose_us_item_icon'];
		$this->status->DbValue = $row['status'];
		$this->sort_order->DbValue = $row['sort_order'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("msmsl_choose_us_item_id")) <> "")
			$this->msmsl_choose_us_item_id->CurrentValue = $this->getKey("msmsl_choose_us_item_id"); // msmsl_choose_us_item_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// msmsl_choose_us_item_id
		// msmsl_choose_us_item_title
		// msmsl_choose_us_item_snippet
		// msmsl_choose_us_item_icon
		// status
		// sort_order

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// msmsl_choose_us_item_id
		$this->msmsl_choose_us_item_id->ViewValue = $this->msmsl_choose_us_item_id->CurrentValue;
		$this->msmsl_choose_us_item_id->ViewCustomAttributes = "";

		// msmsl_choose_us_item_title
		$this->msmsl_choose_us_item_title->ViewValue = $this->msmsl_choose_us_item_title->CurrentValue;
		$this->msmsl_choose_us_item_title->ViewCustomAttributes = "";

		// msmsl_choose_us_item_snippet
		$this->msmsl_choose_us_item_snippet->ViewValue = $this->msmsl_choose_us_item_snippet->CurrentValue;
		$this->msmsl_choose_us_item_snippet->ViewCustomAttributes = "";

		// msmsl_choose_us_item_icon
		if (strval($this->msmsl_choose_us_item_icon->CurrentValue) <> "") {
			$this->msmsl_choose_us_item_icon->ViewValue = $this->msmsl_choose_us_item_icon->OptionCaption($this->msmsl_choose_us_item_icon->CurrentValue);
		} else {
			$this->msmsl_choose_us_item_icon->ViewValue = NULL;
		}
		$this->msmsl_choose_us_item_icon->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// sort_order
		$this->sort_order->ViewValue = $this->sort_order->CurrentValue;
		$this->sort_order->ViewCustomAttributes = "";

			// msmsl_choose_us_item_title
			$this->msmsl_choose_us_item_title->LinkCustomAttributes = "";
			$this->msmsl_choose_us_item_title->HrefValue = "";
			$this->msmsl_choose_us_item_title->TooltipValue = "";

			// msmsl_choose_us_item_snippet
			$this->msmsl_choose_us_item_snippet->LinkCustomAttributes = "";
			$this->msmsl_choose_us_item_snippet->HrefValue = "";
			$this->msmsl_choose_us_item_snippet->TooltipValue = "";

			// msmsl_choose_us_item_icon
			$this->msmsl_choose_us_item_icon->LinkCustomAttributes = "";
			$this->msmsl_choose_us_item_icon->HrefValue = "";
			$this->msmsl_choose_us_item_icon->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// msmsl_choose_us_item_title
			$this->msmsl_choose_us_item_title->EditAttrs["class"] = "form-control";
			$this->msmsl_choose_us_item_title->EditCustomAttributes = "";
			$this->msmsl_choose_us_item_title->EditValue = ew_HtmlEncode($this->msmsl_choose_us_item_title->CurrentValue);
			$this->msmsl_choose_us_item_title->PlaceHolder = ew_RemoveHtml($this->msmsl_choose_us_item_title->FldCaption());

			// msmsl_choose_us_item_snippet
			$this->msmsl_choose_us_item_snippet->EditAttrs["class"] = "form-control";
			$this->msmsl_choose_us_item_snippet->EditCustomAttributes = "";
			$this->msmsl_choose_us_item_snippet->EditValue = ew_HtmlEncode($this->msmsl_choose_us_item_snippet->CurrentValue);
			$this->msmsl_choose_us_item_snippet->PlaceHolder = ew_RemoveHtml($this->msmsl_choose_us_item_snippet->FldCaption());

			// msmsl_choose_us_item_icon
			$this->msmsl_choose_us_item_icon->EditAttrs["class"] = "form-control";
			$this->msmsl_choose_us_item_icon->EditCustomAttributes = "";
			$this->msmsl_choose_us_item_icon->EditValue = $this->msmsl_choose_us_item_icon->Options(TRUE);

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// Edit refer script
			// msmsl_choose_us_item_title

			$this->msmsl_choose_us_item_title->HrefValue = "";

			// msmsl_choose_us_item_snippet
			$this->msmsl_choose_us_item_snippet->HrefValue = "";

			// msmsl_choose_us_item_icon
			$this->msmsl_choose_us_item_icon->HrefValue = "";

			// status
			$this->status->HrefValue = "";

			// sort_order
			$this->sort_order->HrefValue = "";
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
		if (!$this->msmsl_choose_us_item_title->FldIsDetailKey && !is_null($this->msmsl_choose_us_item_title->FormValue) && $this->msmsl_choose_us_item_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_choose_us_item_title->FldCaption(), $this->msmsl_choose_us_item_title->ReqErrMsg));
		}
		if (!$this->msmsl_choose_us_item_snippet->FldIsDetailKey && !is_null($this->msmsl_choose_us_item_snippet->FormValue) && $this->msmsl_choose_us_item_snippet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_choose_us_item_snippet->FldCaption(), $this->msmsl_choose_us_item_snippet->ReqErrMsg));
		}
		if (!$this->msmsl_choose_us_item_icon->FldIsDetailKey && !is_null($this->msmsl_choose_us_item_icon->FormValue) && $this->msmsl_choose_us_item_icon->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_choose_us_item_icon->FldCaption(), $this->msmsl_choose_us_item_icon->ReqErrMsg));
		}
		if ($this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!$this->sort_order->FldIsDetailKey && !is_null($this->sort_order->FormValue) && $this->sort_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sort_order->FldCaption(), $this->sort_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sort_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->sort_order->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// msmsl_choose_us_item_title
		$this->msmsl_choose_us_item_title->SetDbValueDef($rsnew, $this->msmsl_choose_us_item_title->CurrentValue, "", FALSE);

		// msmsl_choose_us_item_snippet
		$this->msmsl_choose_us_item_snippet->SetDbValueDef($rsnew, $this->msmsl_choose_us_item_snippet->CurrentValue, "", FALSE);

		// msmsl_choose_us_item_icon
		$this->msmsl_choose_us_item_icon->SetDbValueDef($rsnew, $this->msmsl_choose_us_item_icon->CurrentValue, "", FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");

		// sort_order
		$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->msmsl_choose_us_item_id->setDbValue($conn->Insert_ID());
				$rsnew['msmsl_choose_us_item_id'] = $this->msmsl_choose_us_item_id->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "msmsl_choose_us_itemslist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($msmsl_choose_us_items_add)) $msmsl_choose_us_items_add = new cmsmsl_choose_us_items_add();

// Page init
$msmsl_choose_us_items_add->Page_Init();

// Page main
$msmsl_choose_us_items_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$msmsl_choose_us_items_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmsmsl_choose_us_itemsadd = new ew_Form("fmsmsl_choose_us_itemsadd", "add");

// Validate form
fmsmsl_choose_us_itemsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_msmsl_choose_us_item_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_choose_us_items->msmsl_choose_us_item_title->FldCaption(), $msmsl_choose_us_items->msmsl_choose_us_item_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_msmsl_choose_us_item_snippet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_choose_us_items->msmsl_choose_us_item_snippet->FldCaption(), $msmsl_choose_us_items->msmsl_choose_us_item_snippet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_msmsl_choose_us_item_icon");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_choose_us_items->msmsl_choose_us_item_icon->FldCaption(), $msmsl_choose_us_items->msmsl_choose_us_item_icon->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_choose_us_items->status->FldCaption(), $msmsl_choose_us_items->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_choose_us_items->sort_order->FldCaption(), $msmsl_choose_us_items->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($msmsl_choose_us_items->sort_order->FldErrMsg()) ?>");

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
fmsmsl_choose_us_itemsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmsmsl_choose_us_itemsadd.ValidateRequired = true;
<?php } else { ?>
fmsmsl_choose_us_itemsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmsmsl_choose_us_itemsadd.Lists["x_msmsl_choose_us_item_icon"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmsmsl_choose_us_itemsadd.Lists["x_msmsl_choose_us_item_icon"].Options = <?php echo json_encode($msmsl_choose_us_items->msmsl_choose_us_item_icon->Options()) ?>;
fmsmsl_choose_us_itemsadd.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmsmsl_choose_us_itemsadd.Lists["x_status"].Options = <?php echo json_encode($msmsl_choose_us_items->status->Options()) ?>;

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
<?php $msmsl_choose_us_items_add->ShowPageHeader(); ?>
<?php
$msmsl_choose_us_items_add->ShowMessage();
?>
<form name="fmsmsl_choose_us_itemsadd" id="fmsmsl_choose_us_itemsadd" class="<?php echo $msmsl_choose_us_items_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($msmsl_choose_us_items_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $msmsl_choose_us_items_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="msmsl_choose_us_items">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($msmsl_choose_us_items->msmsl_choose_us_item_title->Visible) { // msmsl_choose_us_item_title ?>
	<div id="r_msmsl_choose_us_item_title" class="form-group">
		<label id="elh_msmsl_choose_us_items_msmsl_choose_us_item_title" for="x_msmsl_choose_us_item_title" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_choose_us_items->msmsl_choose_us_item_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_title->CellAttributes() ?>>
<span id="el_msmsl_choose_us_items_msmsl_choose_us_item_title">
<input type="text" data-table="msmsl_choose_us_items" data-field="x_msmsl_choose_us_item_title" name="x_msmsl_choose_us_item_title" id="x_msmsl_choose_us_item_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($msmsl_choose_us_items->msmsl_choose_us_item_title->getPlaceHolder()) ?>" value="<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_title->EditValue ?>"<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_title->EditAttributes() ?>>
</span>
<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_choose_us_items->msmsl_choose_us_item_snippet->Visible) { // msmsl_choose_us_item_snippet ?>
	<div id="r_msmsl_choose_us_item_snippet" class="form-group">
		<label id="elh_msmsl_choose_us_items_msmsl_choose_us_item_snippet" for="x_msmsl_choose_us_item_snippet" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_choose_us_items->msmsl_choose_us_item_snippet->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_snippet->CellAttributes() ?>>
<span id="el_msmsl_choose_us_items_msmsl_choose_us_item_snippet">
<textarea data-table="msmsl_choose_us_items" data-field="x_msmsl_choose_us_item_snippet" name="x_msmsl_choose_us_item_snippet" id="x_msmsl_choose_us_item_snippet" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($msmsl_choose_us_items->msmsl_choose_us_item_snippet->getPlaceHolder()) ?>"<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_snippet->EditAttributes() ?>><?php echo $msmsl_choose_us_items->msmsl_choose_us_item_snippet->EditValue ?></textarea>
</span>
<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_snippet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_choose_us_items->msmsl_choose_us_item_icon->Visible) { // msmsl_choose_us_item_icon ?>
	<div id="r_msmsl_choose_us_item_icon" class="form-group">
		<label id="elh_msmsl_choose_us_items_msmsl_choose_us_item_icon" for="x_msmsl_choose_us_item_icon" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_choose_us_items->msmsl_choose_us_item_icon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_icon->CellAttributes() ?>>
<span id="el_msmsl_choose_us_items_msmsl_choose_us_item_icon">
<select data-table="msmsl_choose_us_items" data-field="x_msmsl_choose_us_item_icon" data-value-separator="<?php echo ew_HtmlEncode(is_array($msmsl_choose_us_items->msmsl_choose_us_item_icon->DisplayValueSeparator) ? json_encode($msmsl_choose_us_items->msmsl_choose_us_item_icon->DisplayValueSeparator) : $msmsl_choose_us_items->msmsl_choose_us_item_icon->DisplayValueSeparator) ?>" id="x_msmsl_choose_us_item_icon" name="x_msmsl_choose_us_item_icon"<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_icon->EditAttributes() ?>>
<?php
if (is_array($msmsl_choose_us_items->msmsl_choose_us_item_icon->EditValue)) {
	$arwrk = $msmsl_choose_us_items->msmsl_choose_us_item_icon->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($msmsl_choose_us_items->msmsl_choose_us_item_icon->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_icon->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($msmsl_choose_us_items->msmsl_choose_us_item_icon->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($msmsl_choose_us_items->msmsl_choose_us_item_icon->CurrentValue) ?>" selected><?php echo $msmsl_choose_us_items->msmsl_choose_us_item_icon->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $msmsl_choose_us_items->msmsl_choose_us_item_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_choose_us_items->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_msmsl_choose_us_items_status" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_choose_us_items->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_choose_us_items->status->CellAttributes() ?>>
<span id="el_msmsl_choose_us_items_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="msmsl_choose_us_items" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($msmsl_choose_us_items->status->DisplayValueSeparator) ? json_encode($msmsl_choose_us_items->status->DisplayValueSeparator) : $msmsl_choose_us_items->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $msmsl_choose_us_items->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $msmsl_choose_us_items->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($msmsl_choose_us_items->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="msmsl_choose_us_items" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $msmsl_choose_us_items->status->EditAttributes() ?>><?php echo $msmsl_choose_us_items->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($msmsl_choose_us_items->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="msmsl_choose_us_items" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($msmsl_choose_us_items->status->CurrentValue) ?>" checked<?php echo $msmsl_choose_us_items->status->EditAttributes() ?>><?php echo $msmsl_choose_us_items->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $msmsl_choose_us_items->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_choose_us_items->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_msmsl_choose_us_items_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_choose_us_items->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_choose_us_items->sort_order->CellAttributes() ?>>
<span id="el_msmsl_choose_us_items_sort_order">
<input type="text" data-table="msmsl_choose_us_items" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($msmsl_choose_us_items->sort_order->getPlaceHolder()) ?>" value="<?php echo $msmsl_choose_us_items->sort_order->EditValue ?>"<?php echo $msmsl_choose_us_items->sort_order->EditAttributes() ?>>
</span>
<?php echo $msmsl_choose_us_items->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $msmsl_choose_us_items_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmsmsl_choose_us_itemsadd.Init();
</script>
<?php
$msmsl_choose_us_items_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$msmsl_choose_us_items_add->Page_Terminate();
?>
