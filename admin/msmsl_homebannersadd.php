<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "msmsl_homebannersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$msmsl_homebanners_add = NULL; // Initialize page object first

class cmsmsl_homebanners_add extends cmsmsl_homebanners {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'msmsl_homebanners';

	// Page object name
	var $PageObjName = 'msmsl_homebanners_add';

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

		// Table object (msmsl_homebanners)
		if (!isset($GLOBALS["msmsl_homebanners"]) || get_class($GLOBALS["msmsl_homebanners"]) == "cmsmsl_homebanners") {
			$GLOBALS["msmsl_homebanners"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["msmsl_homebanners"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'msmsl_homebanners', TRUE);

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
		global $EW_EXPORT, $msmsl_homebanners;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($msmsl_homebanners);
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
			if (@$_GET["msmsl_homebanner_id"] != "") {
				$this->msmsl_homebanner_id->setQueryStringValue($_GET["msmsl_homebanner_id"]);
				$this->setKey("msmsl_homebanner_id", $this->msmsl_homebanner_id->CurrentValue); // Set up key
			} else {
				$this->setKey("msmsl_homebanner_id", ""); // Clear key
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
					$this->Page_Terminate("msmsl_homebannerslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "msmsl_homebannersview.php")
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
		$this->msmsl_homebanner_pic->Upload->Index = $objForm->Index;
		$this->msmsl_homebanner_pic->Upload->UploadFile();
		$this->msmsl_homebanner_pic->CurrentValue = $this->msmsl_homebanner_pic->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->msmsl_homebanner_top_title->CurrentValue = NULL;
		$this->msmsl_homebanner_top_title->OldValue = $this->msmsl_homebanner_top_title->CurrentValue;
		$this->msmsl_homebanner_main_title->CurrentValue = NULL;
		$this->msmsl_homebanner_main_title->OldValue = $this->msmsl_homebanner_main_title->CurrentValue;
		$this->msmsl_homebanner_low_title->CurrentValue = NULL;
		$this->msmsl_homebanner_low_title->OldValue = $this->msmsl_homebanner_low_title->CurrentValue;
		$this->msmsl_homebanner_pic->Upload->DbValue = NULL;
		$this->msmsl_homebanner_pic->OldValue = $this->msmsl_homebanner_pic->Upload->DbValue;
		$this->msmsl_homebanner_pic->CurrentValue = NULL; // Clear file related field
		$this->msmsl_homebanner_button_text->CurrentValue = NULL;
		$this->msmsl_homebanner_button_text->OldValue = $this->msmsl_homebanner_button_text->CurrentValue;
		$this->msmsl_homebanner_banner_link->CurrentValue = NULL;
		$this->msmsl_homebanner_banner_link->OldValue = $this->msmsl_homebanner_banner_link->CurrentValue;
		$this->sort_order->CurrentValue = NULL;
		$this->sort_order->OldValue = $this->sort_order->CurrentValue;
		$this->status->CurrentValue = "active";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->msmsl_homebanner_top_title->FldIsDetailKey) {
			$this->msmsl_homebanner_top_title->setFormValue($objForm->GetValue("x_msmsl_homebanner_top_title"));
		}
		if (!$this->msmsl_homebanner_main_title->FldIsDetailKey) {
			$this->msmsl_homebanner_main_title->setFormValue($objForm->GetValue("x_msmsl_homebanner_main_title"));
		}
		if (!$this->msmsl_homebanner_low_title->FldIsDetailKey) {
			$this->msmsl_homebanner_low_title->setFormValue($objForm->GetValue("x_msmsl_homebanner_low_title"));
		}
		if (!$this->msmsl_homebanner_button_text->FldIsDetailKey) {
			$this->msmsl_homebanner_button_text->setFormValue($objForm->GetValue("x_msmsl_homebanner_button_text"));
		}
		if (!$this->msmsl_homebanner_banner_link->FldIsDetailKey) {
			$this->msmsl_homebanner_banner_link->setFormValue($objForm->GetValue("x_msmsl_homebanner_banner_link"));
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
		$this->LoadOldRecord();
		$this->msmsl_homebanner_top_title->CurrentValue = $this->msmsl_homebanner_top_title->FormValue;
		$this->msmsl_homebanner_main_title->CurrentValue = $this->msmsl_homebanner_main_title->FormValue;
		$this->msmsl_homebanner_low_title->CurrentValue = $this->msmsl_homebanner_low_title->FormValue;
		$this->msmsl_homebanner_button_text->CurrentValue = $this->msmsl_homebanner_button_text->FormValue;
		$this->msmsl_homebanner_banner_link->CurrentValue = $this->msmsl_homebanner_banner_link->FormValue;
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
		$this->msmsl_homebanner_id->setDbValue($rs->fields('msmsl_homebanner_id'));
		$this->msmsl_homebanner_top_title->setDbValue($rs->fields('msmsl_homebanner_top_title'));
		$this->msmsl_homebanner_main_title->setDbValue($rs->fields('msmsl_homebanner_main_title'));
		$this->msmsl_homebanner_low_title->setDbValue($rs->fields('msmsl_homebanner_low_title'));
		$this->msmsl_homebanner_pic->Upload->DbValue = $rs->fields('msmsl_homebanner_pic');
		$this->msmsl_homebanner_pic->CurrentValue = $this->msmsl_homebanner_pic->Upload->DbValue;
		$this->msmsl_homebanner_button_text->setDbValue($rs->fields('msmsl_homebanner_button_text'));
		$this->msmsl_homebanner_banner_link->setDbValue($rs->fields('msmsl_homebanner_banner_link'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->msmsl_homebanner_id->DbValue = $row['msmsl_homebanner_id'];
		$this->msmsl_homebanner_top_title->DbValue = $row['msmsl_homebanner_top_title'];
		$this->msmsl_homebanner_main_title->DbValue = $row['msmsl_homebanner_main_title'];
		$this->msmsl_homebanner_low_title->DbValue = $row['msmsl_homebanner_low_title'];
		$this->msmsl_homebanner_pic->Upload->DbValue = $row['msmsl_homebanner_pic'];
		$this->msmsl_homebanner_button_text->DbValue = $row['msmsl_homebanner_button_text'];
		$this->msmsl_homebanner_banner_link->DbValue = $row['msmsl_homebanner_banner_link'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("msmsl_homebanner_id")) <> "")
			$this->msmsl_homebanner_id->CurrentValue = $this->getKey("msmsl_homebanner_id"); // msmsl_homebanner_id
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
		// msmsl_homebanner_id
		// msmsl_homebanner_top_title
		// msmsl_homebanner_main_title
		// msmsl_homebanner_low_title
		// msmsl_homebanner_pic
		// msmsl_homebanner_button_text
		// msmsl_homebanner_banner_link
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// msmsl_homebanner_id
		$this->msmsl_homebanner_id->ViewValue = $this->msmsl_homebanner_id->CurrentValue;
		$this->msmsl_homebanner_id->ViewCustomAttributes = "";

		// msmsl_homebanner_top_title
		$this->msmsl_homebanner_top_title->ViewValue = $this->msmsl_homebanner_top_title->CurrentValue;
		$this->msmsl_homebanner_top_title->ViewCustomAttributes = "";

		// msmsl_homebanner_main_title
		$this->msmsl_homebanner_main_title->ViewValue = $this->msmsl_homebanner_main_title->CurrentValue;
		$this->msmsl_homebanner_main_title->ViewCustomAttributes = "";

		// msmsl_homebanner_low_title
		$this->msmsl_homebanner_low_title->ViewValue = $this->msmsl_homebanner_low_title->CurrentValue;
		$this->msmsl_homebanner_low_title->ViewCustomAttributes = "";

		// msmsl_homebanner_pic
		$this->msmsl_homebanner_pic->UploadPath = '../src/assets/images/msms/homebanners';
		if (!ew_Empty($this->msmsl_homebanner_pic->Upload->DbValue)) {
			$this->msmsl_homebanner_pic->ImageWidth = 120;
			$this->msmsl_homebanner_pic->ImageHeight = 65;
			$this->msmsl_homebanner_pic->ImageAlt = $this->msmsl_homebanner_pic->FldAlt();
			$this->msmsl_homebanner_pic->ViewValue = $this->msmsl_homebanner_pic->Upload->DbValue;
		} else {
			$this->msmsl_homebanner_pic->ViewValue = "";
		}
		$this->msmsl_homebanner_pic->ViewCustomAttributes = "";

		// msmsl_homebanner_button_text
		$this->msmsl_homebanner_button_text->ViewValue = $this->msmsl_homebanner_button_text->CurrentValue;
		$this->msmsl_homebanner_button_text->ViewCustomAttributes = "";

		// msmsl_homebanner_banner_link
		$this->msmsl_homebanner_banner_link->ViewValue = $this->msmsl_homebanner_banner_link->CurrentValue;
		$this->msmsl_homebanner_banner_link->ViewCustomAttributes = "";

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

			// msmsl_homebanner_top_title
			$this->msmsl_homebanner_top_title->LinkCustomAttributes = "";
			$this->msmsl_homebanner_top_title->HrefValue = "";
			$this->msmsl_homebanner_top_title->TooltipValue = "";

			// msmsl_homebanner_main_title
			$this->msmsl_homebanner_main_title->LinkCustomAttributes = "";
			$this->msmsl_homebanner_main_title->HrefValue = "";
			$this->msmsl_homebanner_main_title->TooltipValue = "";

			// msmsl_homebanner_low_title
			$this->msmsl_homebanner_low_title->LinkCustomAttributes = "";
			$this->msmsl_homebanner_low_title->HrefValue = "";
			$this->msmsl_homebanner_low_title->TooltipValue = "";

			// msmsl_homebanner_pic
			$this->msmsl_homebanner_pic->LinkCustomAttributes = "";
			$this->msmsl_homebanner_pic->UploadPath = '../src/assets/images/msms/homebanners';
			if (!ew_Empty($this->msmsl_homebanner_pic->Upload->DbValue)) {
				$this->msmsl_homebanner_pic->HrefValue = ew_GetFileUploadUrl($this->msmsl_homebanner_pic, $this->msmsl_homebanner_pic->Upload->DbValue); // Add prefix/suffix
				$this->msmsl_homebanner_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->msmsl_homebanner_pic->HrefValue = ew_ConvertFullUrl($this->msmsl_homebanner_pic->HrefValue);
			} else {
				$this->msmsl_homebanner_pic->HrefValue = "";
			}
			$this->msmsl_homebanner_pic->HrefValue2 = $this->msmsl_homebanner_pic->UploadPath . $this->msmsl_homebanner_pic->Upload->DbValue;
			$this->msmsl_homebanner_pic->TooltipValue = "";
			if ($this->msmsl_homebanner_pic->UseColorbox) {
				$this->msmsl_homebanner_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->msmsl_homebanner_pic->LinkAttrs["data-rel"] = "msmsl_homebanners_x_msmsl_homebanner_pic";

				//$this->msmsl_homebanner_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->msmsl_homebanner_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->msmsl_homebanner_pic->LinkAttrs["data-container"] = "body";

				$this->msmsl_homebanner_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// msmsl_homebanner_button_text
			$this->msmsl_homebanner_button_text->LinkCustomAttributes = "";
			$this->msmsl_homebanner_button_text->HrefValue = "";
			$this->msmsl_homebanner_button_text->TooltipValue = "";

			// msmsl_homebanner_banner_link
			$this->msmsl_homebanner_banner_link->LinkCustomAttributes = "";
			$this->msmsl_homebanner_banner_link->HrefValue = "";
			$this->msmsl_homebanner_banner_link->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// msmsl_homebanner_top_title
			$this->msmsl_homebanner_top_title->EditAttrs["class"] = "form-control";
			$this->msmsl_homebanner_top_title->EditCustomAttributes = "";
			$this->msmsl_homebanner_top_title->EditValue = ew_HtmlEncode($this->msmsl_homebanner_top_title->CurrentValue);
			$this->msmsl_homebanner_top_title->PlaceHolder = ew_RemoveHtml($this->msmsl_homebanner_top_title->FldCaption());

			// msmsl_homebanner_main_title
			$this->msmsl_homebanner_main_title->EditAttrs["class"] = "form-control";
			$this->msmsl_homebanner_main_title->EditCustomAttributes = "";
			$this->msmsl_homebanner_main_title->EditValue = ew_HtmlEncode($this->msmsl_homebanner_main_title->CurrentValue);
			$this->msmsl_homebanner_main_title->PlaceHolder = ew_RemoveHtml($this->msmsl_homebanner_main_title->FldCaption());

			// msmsl_homebanner_low_title
			$this->msmsl_homebanner_low_title->EditAttrs["class"] = "form-control";
			$this->msmsl_homebanner_low_title->EditCustomAttributes = "";
			$this->msmsl_homebanner_low_title->EditValue = ew_HtmlEncode($this->msmsl_homebanner_low_title->CurrentValue);
			$this->msmsl_homebanner_low_title->PlaceHolder = ew_RemoveHtml($this->msmsl_homebanner_low_title->FldCaption());

			// msmsl_homebanner_pic
			$this->msmsl_homebanner_pic->EditAttrs["class"] = "form-control";
			$this->msmsl_homebanner_pic->EditCustomAttributes = "";
			$this->msmsl_homebanner_pic->UploadPath = '../src/assets/images/msms/homebanners';
			if (!ew_Empty($this->msmsl_homebanner_pic->Upload->DbValue)) {
				$this->msmsl_homebanner_pic->ImageWidth = 120;
				$this->msmsl_homebanner_pic->ImageHeight = 65;
				$this->msmsl_homebanner_pic->ImageAlt = $this->msmsl_homebanner_pic->FldAlt();
				$this->msmsl_homebanner_pic->EditValue = $this->msmsl_homebanner_pic->Upload->DbValue;
			} else {
				$this->msmsl_homebanner_pic->EditValue = "";
			}
			if (!ew_Empty($this->msmsl_homebanner_pic->CurrentValue))
				$this->msmsl_homebanner_pic->Upload->FileName = $this->msmsl_homebanner_pic->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->msmsl_homebanner_pic);

			// msmsl_homebanner_button_text
			$this->msmsl_homebanner_button_text->EditAttrs["class"] = "form-control";
			$this->msmsl_homebanner_button_text->EditCustomAttributes = "";
			$this->msmsl_homebanner_button_text->EditValue = ew_HtmlEncode($this->msmsl_homebanner_button_text->CurrentValue);
			$this->msmsl_homebanner_button_text->PlaceHolder = ew_RemoveHtml($this->msmsl_homebanner_button_text->FldCaption());

			// msmsl_homebanner_banner_link
			$this->msmsl_homebanner_banner_link->EditAttrs["class"] = "form-control";
			$this->msmsl_homebanner_banner_link->EditCustomAttributes = "";
			$this->msmsl_homebanner_banner_link->EditValue = ew_HtmlEncode($this->msmsl_homebanner_banner_link->CurrentValue);
			$this->msmsl_homebanner_banner_link->PlaceHolder = ew_RemoveHtml($this->msmsl_homebanner_banner_link->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// msmsl_homebanner_top_title

			$this->msmsl_homebanner_top_title->HrefValue = "";

			// msmsl_homebanner_main_title
			$this->msmsl_homebanner_main_title->HrefValue = "";

			// msmsl_homebanner_low_title
			$this->msmsl_homebanner_low_title->HrefValue = "";

			// msmsl_homebanner_pic
			$this->msmsl_homebanner_pic->UploadPath = '../src/assets/images/msms/homebanners';
			if (!ew_Empty($this->msmsl_homebanner_pic->Upload->DbValue)) {
				$this->msmsl_homebanner_pic->HrefValue = ew_GetFileUploadUrl($this->msmsl_homebanner_pic, $this->msmsl_homebanner_pic->Upload->DbValue); // Add prefix/suffix
				$this->msmsl_homebanner_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->msmsl_homebanner_pic->HrefValue = ew_ConvertFullUrl($this->msmsl_homebanner_pic->HrefValue);
			} else {
				$this->msmsl_homebanner_pic->HrefValue = "";
			}
			$this->msmsl_homebanner_pic->HrefValue2 = $this->msmsl_homebanner_pic->UploadPath . $this->msmsl_homebanner_pic->Upload->DbValue;

			// msmsl_homebanner_button_text
			$this->msmsl_homebanner_button_text->HrefValue = "";

			// msmsl_homebanner_banner_link
			$this->msmsl_homebanner_banner_link->HrefValue = "";

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
		if (!$this->msmsl_homebanner_top_title->FldIsDetailKey && !is_null($this->msmsl_homebanner_top_title->FormValue) && $this->msmsl_homebanner_top_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_homebanner_top_title->FldCaption(), $this->msmsl_homebanner_top_title->ReqErrMsg));
		}
		if (!$this->msmsl_homebanner_main_title->FldIsDetailKey && !is_null($this->msmsl_homebanner_main_title->FormValue) && $this->msmsl_homebanner_main_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_homebanner_main_title->FldCaption(), $this->msmsl_homebanner_main_title->ReqErrMsg));
		}
		if (!$this->msmsl_homebanner_low_title->FldIsDetailKey && !is_null($this->msmsl_homebanner_low_title->FormValue) && $this->msmsl_homebanner_low_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_homebanner_low_title->FldCaption(), $this->msmsl_homebanner_low_title->ReqErrMsg));
		}
		if ($this->msmsl_homebanner_pic->Upload->FileName == "" && !$this->msmsl_homebanner_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_homebanner_pic->FldCaption(), $this->msmsl_homebanner_pic->ReqErrMsg));
		}
		if (!$this->msmsl_homebanner_button_text->FldIsDetailKey && !is_null($this->msmsl_homebanner_button_text->FormValue) && $this->msmsl_homebanner_button_text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->msmsl_homebanner_button_text->FldCaption(), $this->msmsl_homebanner_button_text->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->msmsl_homebanner_pic->OldUploadPath = '../src/assets/images/msms/homebanners';
			$this->msmsl_homebanner_pic->UploadPath = $this->msmsl_homebanner_pic->OldUploadPath;
		}
		$rsnew = array();

		// msmsl_homebanner_top_title
		$this->msmsl_homebanner_top_title->SetDbValueDef($rsnew, $this->msmsl_homebanner_top_title->CurrentValue, "", FALSE);

		// msmsl_homebanner_main_title
		$this->msmsl_homebanner_main_title->SetDbValueDef($rsnew, $this->msmsl_homebanner_main_title->CurrentValue, "", FALSE);

		// msmsl_homebanner_low_title
		$this->msmsl_homebanner_low_title->SetDbValueDef($rsnew, $this->msmsl_homebanner_low_title->CurrentValue, "", FALSE);

		// msmsl_homebanner_pic
		if (!$this->msmsl_homebanner_pic->Upload->KeepFile) {
			$this->msmsl_homebanner_pic->Upload->DbValue = ""; // No need to delete old file
			if ($this->msmsl_homebanner_pic->Upload->FileName == "") {
				$rsnew['msmsl_homebanner_pic'] = NULL;
			} else {
				$rsnew['msmsl_homebanner_pic'] = $this->msmsl_homebanner_pic->Upload->FileName;
			}
			$this->msmsl_homebanner_pic->ImageWidth = 1600; // Resize width
			$this->msmsl_homebanner_pic->ImageHeight = 836; // Resize height
		}

		// msmsl_homebanner_button_text
		$this->msmsl_homebanner_button_text->SetDbValueDef($rsnew, $this->msmsl_homebanner_button_text->CurrentValue, "", FALSE);

		// msmsl_homebanner_banner_link
		$this->msmsl_homebanner_banner_link->SetDbValueDef($rsnew, $this->msmsl_homebanner_banner_link->CurrentValue, NULL, FALSE);

		// sort_order
		$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");
		if (!$this->msmsl_homebanner_pic->Upload->KeepFile) {
			$this->msmsl_homebanner_pic->UploadPath = '../src/assets/images/msms/homebanners';
			if (!ew_Empty($this->msmsl_homebanner_pic->Upload->Value)) {
				$rsnew['msmsl_homebanner_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->msmsl_homebanner_pic->UploadPath), $rsnew['msmsl_homebanner_pic']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->msmsl_homebanner_id->setDbValue($conn->Insert_ID());
				$rsnew['msmsl_homebanner_id'] = $this->msmsl_homebanner_id->DbValue;
				if (!$this->msmsl_homebanner_pic->Upload->KeepFile) {
					if (!ew_Empty($this->msmsl_homebanner_pic->Upload->Value)) {
						$this->msmsl_homebanner_pic->Upload->Resize($this->msmsl_homebanner_pic->ImageWidth, $this->msmsl_homebanner_pic->ImageHeight);
						$this->msmsl_homebanner_pic->Upload->SaveToFile($this->msmsl_homebanner_pic->UploadPath, $rsnew['msmsl_homebanner_pic'], TRUE);
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
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// msmsl_homebanner_pic
		ew_CleanUploadTempPath($this->msmsl_homebanner_pic, $this->msmsl_homebanner_pic->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "msmsl_homebannerslist.php", "", $this->TableVar, TRUE);
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
if (!isset($msmsl_homebanners_add)) $msmsl_homebanners_add = new cmsmsl_homebanners_add();

// Page init
$msmsl_homebanners_add->Page_Init();

// Page main
$msmsl_homebanners_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$msmsl_homebanners_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmsmsl_homebannersadd = new ew_Form("fmsmsl_homebannersadd", "add");

// Validate form
fmsmsl_homebannersadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_msmsl_homebanner_top_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->msmsl_homebanner_top_title->FldCaption(), $msmsl_homebanners->msmsl_homebanner_top_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_msmsl_homebanner_main_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->msmsl_homebanner_main_title->FldCaption(), $msmsl_homebanners->msmsl_homebanner_main_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_msmsl_homebanner_low_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->msmsl_homebanner_low_title->FldCaption(), $msmsl_homebanners->msmsl_homebanner_low_title->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_msmsl_homebanner_pic");
			elm = this.GetElements("fn_x" + infix + "_msmsl_homebanner_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->msmsl_homebanner_pic->FldCaption(), $msmsl_homebanners->msmsl_homebanner_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_msmsl_homebanner_button_text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->msmsl_homebanner_button_text->FldCaption(), $msmsl_homebanners->msmsl_homebanner_button_text->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->sort_order->FldCaption(), $msmsl_homebanners->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($msmsl_homebanners->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $msmsl_homebanners->status->FldCaption(), $msmsl_homebanners->status->ReqErrMsg)) ?>");

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
fmsmsl_homebannersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmsmsl_homebannersadd.ValidateRequired = true;
<?php } else { ?>
fmsmsl_homebannersadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmsmsl_homebannersadd.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmsmsl_homebannersadd.Lists["x_status"].Options = <?php echo json_encode($msmsl_homebanners->status->Options()) ?>;

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
<?php $msmsl_homebanners_add->ShowPageHeader(); ?>
<?php
$msmsl_homebanners_add->ShowMessage();
?>
<form name="fmsmsl_homebannersadd" id="fmsmsl_homebannersadd" class="<?php echo $msmsl_homebanners_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($msmsl_homebanners_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $msmsl_homebanners_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="msmsl_homebanners">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($msmsl_homebanners->msmsl_homebanner_top_title->Visible) { // msmsl_homebanner_top_title ?>
	<div id="r_msmsl_homebanner_top_title" class="form-group">
		<label id="elh_msmsl_homebanners_msmsl_homebanner_top_title" for="x_msmsl_homebanner_top_title" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->msmsl_homebanner_top_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->msmsl_homebanner_top_title->CellAttributes() ?>>
<span id="el_msmsl_homebanners_msmsl_homebanner_top_title">
<input type="text" data-table="msmsl_homebanners" data-field="x_msmsl_homebanner_top_title" name="x_msmsl_homebanner_top_title" id="x_msmsl_homebanner_top_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($msmsl_homebanners->msmsl_homebanner_top_title->getPlaceHolder()) ?>" value="<?php echo $msmsl_homebanners->msmsl_homebanner_top_title->EditValue ?>"<?php echo $msmsl_homebanners->msmsl_homebanner_top_title->EditAttributes() ?>>
</span>
<?php echo $msmsl_homebanners->msmsl_homebanner_top_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->msmsl_homebanner_main_title->Visible) { // msmsl_homebanner_main_title ?>
	<div id="r_msmsl_homebanner_main_title" class="form-group">
		<label id="elh_msmsl_homebanners_msmsl_homebanner_main_title" for="x_msmsl_homebanner_main_title" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->msmsl_homebanner_main_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->msmsl_homebanner_main_title->CellAttributes() ?>>
<span id="el_msmsl_homebanners_msmsl_homebanner_main_title">
<input type="text" data-table="msmsl_homebanners" data-field="x_msmsl_homebanner_main_title" name="x_msmsl_homebanner_main_title" id="x_msmsl_homebanner_main_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($msmsl_homebanners->msmsl_homebanner_main_title->getPlaceHolder()) ?>" value="<?php echo $msmsl_homebanners->msmsl_homebanner_main_title->EditValue ?>"<?php echo $msmsl_homebanners->msmsl_homebanner_main_title->EditAttributes() ?>>
</span>
<?php echo $msmsl_homebanners->msmsl_homebanner_main_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->msmsl_homebanner_low_title->Visible) { // msmsl_homebanner_low_title ?>
	<div id="r_msmsl_homebanner_low_title" class="form-group">
		<label id="elh_msmsl_homebanners_msmsl_homebanner_low_title" for="x_msmsl_homebanner_low_title" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->msmsl_homebanner_low_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->msmsl_homebanner_low_title->CellAttributes() ?>>
<span id="el_msmsl_homebanners_msmsl_homebanner_low_title">
<input type="text" data-table="msmsl_homebanners" data-field="x_msmsl_homebanner_low_title" name="x_msmsl_homebanner_low_title" id="x_msmsl_homebanner_low_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($msmsl_homebanners->msmsl_homebanner_low_title->getPlaceHolder()) ?>" value="<?php echo $msmsl_homebanners->msmsl_homebanner_low_title->EditValue ?>"<?php echo $msmsl_homebanners->msmsl_homebanner_low_title->EditAttributes() ?>>
</span>
<?php echo $msmsl_homebanners->msmsl_homebanner_low_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->msmsl_homebanner_pic->Visible) { // msmsl_homebanner_pic ?>
	<div id="r_msmsl_homebanner_pic" class="form-group">
		<label id="elh_msmsl_homebanners_msmsl_homebanner_pic" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->msmsl_homebanner_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->msmsl_homebanner_pic->CellAttributes() ?>>
<span id="el_msmsl_homebanners_msmsl_homebanner_pic">
<div id="fd_x_msmsl_homebanner_pic">
<span title="<?php echo $msmsl_homebanners->msmsl_homebanner_pic->FldTitle() ? $msmsl_homebanners->msmsl_homebanner_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($msmsl_homebanners->msmsl_homebanner_pic->ReadOnly || $msmsl_homebanners->msmsl_homebanner_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="msmsl_homebanners" data-field="x_msmsl_homebanner_pic" name="x_msmsl_homebanner_pic" id="x_msmsl_homebanner_pic"<?php echo $msmsl_homebanners->msmsl_homebanner_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_msmsl_homebanner_pic" id= "fn_x_msmsl_homebanner_pic" value="<?php echo $msmsl_homebanners->msmsl_homebanner_pic->Upload->FileName ?>">
<input type="hidden" name="fa_x_msmsl_homebanner_pic" id= "fa_x_msmsl_homebanner_pic" value="0">
<input type="hidden" name="fs_x_msmsl_homebanner_pic" id= "fs_x_msmsl_homebanner_pic" value="255">
<input type="hidden" name="fx_x_msmsl_homebanner_pic" id= "fx_x_msmsl_homebanner_pic" value="<?php echo $msmsl_homebanners->msmsl_homebanner_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_msmsl_homebanner_pic" id= "fm_x_msmsl_homebanner_pic" value="<?php echo $msmsl_homebanners->msmsl_homebanner_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_msmsl_homebanner_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $msmsl_homebanners->msmsl_homebanner_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->msmsl_homebanner_button_text->Visible) { // msmsl_homebanner_button_text ?>
	<div id="r_msmsl_homebanner_button_text" class="form-group">
		<label id="elh_msmsl_homebanners_msmsl_homebanner_button_text" for="x_msmsl_homebanner_button_text" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->msmsl_homebanner_button_text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->msmsl_homebanner_button_text->CellAttributes() ?>>
<span id="el_msmsl_homebanners_msmsl_homebanner_button_text">
<input type="text" data-table="msmsl_homebanners" data-field="x_msmsl_homebanner_button_text" name="x_msmsl_homebanner_button_text" id="x_msmsl_homebanner_button_text" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($msmsl_homebanners->msmsl_homebanner_button_text->getPlaceHolder()) ?>" value="<?php echo $msmsl_homebanners->msmsl_homebanner_button_text->EditValue ?>"<?php echo $msmsl_homebanners->msmsl_homebanner_button_text->EditAttributes() ?>>
</span>
<?php echo $msmsl_homebanners->msmsl_homebanner_button_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->msmsl_homebanner_banner_link->Visible) { // msmsl_homebanner_banner_link ?>
	<div id="r_msmsl_homebanner_banner_link" class="form-group">
		<label id="elh_msmsl_homebanners_msmsl_homebanner_banner_link" for="x_msmsl_homebanner_banner_link" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->msmsl_homebanner_banner_link->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->msmsl_homebanner_banner_link->CellAttributes() ?>>
<span id="el_msmsl_homebanners_msmsl_homebanner_banner_link">
<input type="text" data-table="msmsl_homebanners" data-field="x_msmsl_homebanner_banner_link" name="x_msmsl_homebanner_banner_link" id="x_msmsl_homebanner_banner_link" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($msmsl_homebanners->msmsl_homebanner_banner_link->getPlaceHolder()) ?>" value="<?php echo $msmsl_homebanners->msmsl_homebanner_banner_link->EditValue ?>"<?php echo $msmsl_homebanners->msmsl_homebanner_banner_link->EditAttributes() ?>>
</span>
<?php echo $msmsl_homebanners->msmsl_homebanner_banner_link->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_msmsl_homebanners_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->sort_order->CellAttributes() ?>>
<span id="el_msmsl_homebanners_sort_order">
<input type="text" data-table="msmsl_homebanners" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($msmsl_homebanners->sort_order->getPlaceHolder()) ?>" value="<?php echo $msmsl_homebanners->sort_order->EditValue ?>"<?php echo $msmsl_homebanners->sort_order->EditAttributes() ?>>
</span>
<?php echo $msmsl_homebanners->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($msmsl_homebanners->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_msmsl_homebanners_status" class="col-sm-2 control-label ewLabel"><?php echo $msmsl_homebanners->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $msmsl_homebanners->status->CellAttributes() ?>>
<span id="el_msmsl_homebanners_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="msmsl_homebanners" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($msmsl_homebanners->status->DisplayValueSeparator) ? json_encode($msmsl_homebanners->status->DisplayValueSeparator) : $msmsl_homebanners->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $msmsl_homebanners->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $msmsl_homebanners->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($msmsl_homebanners->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="msmsl_homebanners" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $msmsl_homebanners->status->EditAttributes() ?>><?php echo $msmsl_homebanners->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($msmsl_homebanners->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="msmsl_homebanners" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($msmsl_homebanners->status->CurrentValue) ?>" checked<?php echo $msmsl_homebanners->status->EditAttributes() ?>><?php echo $msmsl_homebanners->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $msmsl_homebanners->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $msmsl_homebanners_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmsmsl_homebannersadd.Init();
</script>
<?php
$msmsl_homebanners_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$msmsl_homebanners_add->Page_Terminate();
?>
