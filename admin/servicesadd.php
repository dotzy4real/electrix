<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "servicesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$services_add = NULL; // Initialize page object first

class cservices_add extends cservices {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'services';

	// Page object name
	var $PageObjName = 'services_add';

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

		// Table object (services)
		if (!isset($GLOBALS["services"]) || get_class($GLOBALS["services"]) == "cservices") {
			$GLOBALS["services"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["services"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'services', TRUE);

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
		global $EW_EXPORT, $services;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($services);
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
			if (@$_GET["service_id"] != "") {
				$this->service_id->setQueryStringValue($_GET["service_id"]);
				$this->setKey("service_id", $this->service_id->CurrentValue); // Set up key
			} else {
				$this->setKey("service_id", ""); // Clear key
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
					$this->Page_Terminate("serviceslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "servicesview.php")
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
		$this->service_small_pic->Upload->Index = $objForm->Index;
		$this->service_small_pic->Upload->UploadFile();
		$this->service_small_pic->CurrentValue = $this->service_small_pic->Upload->FileName;
		$this->service_large_pic->Upload->Index = $objForm->Index;
		$this->service_large_pic->Upload->UploadFile();
		$this->service_large_pic->CurrentValue = $this->service_large_pic->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->service_small_pic->Upload->DbValue = NULL;
		$this->service_small_pic->OldValue = $this->service_small_pic->Upload->DbValue;
		$this->service_small_pic->CurrentValue = NULL; // Clear file related field
		$this->service_large_pic->Upload->DbValue = NULL;
		$this->service_large_pic->OldValue = $this->service_large_pic->Upload->DbValue;
		$this->service_large_pic->CurrentValue = NULL; // Clear file related field
		$this->service_title->CurrentValue = NULL;
		$this->service_title->OldValue = $this->service_title->CurrentValue;
		$this->service_content->CurrentValue = NULL;
		$this->service_content->OldValue = $this->service_content->CurrentValue;
		$this->service_icon->CurrentValue = NULL;
		$this->service_icon->OldValue = $this->service_icon->CurrentValue;
		$this->sort_order->CurrentValue = NULL;
		$this->sort_order->OldValue = $this->sort_order->CurrentValue;
		$this->status->CurrentValue = "active";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->service_title->FldIsDetailKey) {
			$this->service_title->setFormValue($objForm->GetValue("x_service_title"));
		}
		if (!$this->service_content->FldIsDetailKey) {
			$this->service_content->setFormValue($objForm->GetValue("x_service_content"));
		}
		if (!$this->service_icon->FldIsDetailKey) {
			$this->service_icon->setFormValue($objForm->GetValue("x_service_icon"));
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
		$this->service_title->CurrentValue = $this->service_title->FormValue;
		$this->service_content->CurrentValue = $this->service_content->FormValue;
		$this->service_icon->CurrentValue = $this->service_icon->FormValue;
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
		$this->service_id->setDbValue($rs->fields('service_id'));
		$this->service_small_pic->Upload->DbValue = $rs->fields('service_small_pic');
		$this->service_small_pic->CurrentValue = $this->service_small_pic->Upload->DbValue;
		$this->service_large_pic->Upload->DbValue = $rs->fields('service_large_pic');
		$this->service_large_pic->CurrentValue = $this->service_large_pic->Upload->DbValue;
		$this->service_title->setDbValue($rs->fields('service_title'));
		$this->service_content->setDbValue($rs->fields('service_content'));
		$this->service_icon->setDbValue($rs->fields('service_icon'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->service_id->DbValue = $row['service_id'];
		$this->service_small_pic->Upload->DbValue = $row['service_small_pic'];
		$this->service_large_pic->Upload->DbValue = $row['service_large_pic'];
		$this->service_title->DbValue = $row['service_title'];
		$this->service_content->DbValue = $row['service_content'];
		$this->service_icon->DbValue = $row['service_icon'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("service_id")) <> "")
			$this->service_id->CurrentValue = $this->getKey("service_id"); // service_id
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
		// service_id
		// service_small_pic
		// service_large_pic
		// service_title
		// service_content
		// service_icon
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// service_id
		$this->service_id->ViewValue = $this->service_id->CurrentValue;
		$this->service_id->ViewCustomAttributes = "";

		// service_small_pic
		$this->service_small_pic->UploadPath = '../src/assets/images/resource/services';
		if (!ew_Empty($this->service_small_pic->Upload->DbValue)) {
			$this->service_small_pic->ImageWidth = 120;
			$this->service_small_pic->ImageHeight = 75;
			$this->service_small_pic->ImageAlt = $this->service_small_pic->FldAlt();
			$this->service_small_pic->ViewValue = $this->service_small_pic->Upload->DbValue;
		} else {
			$this->service_small_pic->ViewValue = "";
		}
		$this->service_small_pic->ViewCustomAttributes = "";

		// service_large_pic
		$this->service_large_pic->UploadPath = '../src/assets/images/resource/services';
		if (!ew_Empty($this->service_large_pic->Upload->DbValue)) {
			$this->service_large_pic->ImageWidth = 120;
			$this->service_large_pic->ImageHeight = 75;
			$this->service_large_pic->ImageAlt = $this->service_large_pic->FldAlt();
			$this->service_large_pic->ViewValue = $this->service_large_pic->Upload->DbValue;
		} else {
			$this->service_large_pic->ViewValue = "";
		}
		$this->service_large_pic->ViewCustomAttributes = "";

		// service_title
		$this->service_title->ViewValue = $this->service_title->CurrentValue;
		$this->service_title->ViewCustomAttributes = "";

		// service_content
		$this->service_content->ViewValue = $this->service_content->CurrentValue;
		$this->service_content->ViewCustomAttributes = "";

		// service_icon
		if (strval($this->service_icon->CurrentValue) <> "") {
			$this->service_icon->ViewValue = $this->service_icon->OptionCaption($this->service_icon->CurrentValue);
		} else {
			$this->service_icon->ViewValue = NULL;
		}
		$this->service_icon->ViewCustomAttributes = "";

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

			// service_small_pic
			$this->service_small_pic->LinkCustomAttributes = "";
			$this->service_small_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_small_pic->Upload->DbValue)) {
				$this->service_small_pic->HrefValue = ew_GetFileUploadUrl($this->service_small_pic, $this->service_small_pic->Upload->DbValue); // Add prefix/suffix
				$this->service_small_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->service_small_pic->HrefValue = ew_ConvertFullUrl($this->service_small_pic->HrefValue);
			} else {
				$this->service_small_pic->HrefValue = "";
			}
			$this->service_small_pic->HrefValue2 = $this->service_small_pic->UploadPath . $this->service_small_pic->Upload->DbValue;
			$this->service_small_pic->TooltipValue = "";
			if ($this->service_small_pic->UseColorbox) {
				$this->service_small_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->service_small_pic->LinkAttrs["data-rel"] = "services_x_service_small_pic";

				//$this->service_small_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->service_small_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->service_small_pic->LinkAttrs["data-container"] = "body";

				$this->service_small_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// service_large_pic
			$this->service_large_pic->LinkCustomAttributes = "";
			$this->service_large_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_large_pic->Upload->DbValue)) {
				$this->service_large_pic->HrefValue = ew_GetFileUploadUrl($this->service_large_pic, $this->service_large_pic->Upload->DbValue); // Add prefix/suffix
				$this->service_large_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->service_large_pic->HrefValue = ew_ConvertFullUrl($this->service_large_pic->HrefValue);
			} else {
				$this->service_large_pic->HrefValue = "";
			}
			$this->service_large_pic->HrefValue2 = $this->service_large_pic->UploadPath . $this->service_large_pic->Upload->DbValue;
			$this->service_large_pic->TooltipValue = "";
			if ($this->service_large_pic->UseColorbox) {
				$this->service_large_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->service_large_pic->LinkAttrs["data-rel"] = "services_x_service_large_pic";

				//$this->service_large_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->service_large_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->service_large_pic->LinkAttrs["data-container"] = "body";

				$this->service_large_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// service_title
			$this->service_title->LinkCustomAttributes = "";
			$this->service_title->HrefValue = "";
			$this->service_title->TooltipValue = "";

			// service_content
			$this->service_content->LinkCustomAttributes = "";
			$this->service_content->HrefValue = "";
			$this->service_content->TooltipValue = "";

			// service_icon
			$this->service_icon->LinkCustomAttributes = "";
			$this->service_icon->HrefValue = "";
			$this->service_icon->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// service_small_pic
			$this->service_small_pic->EditAttrs["class"] = "form-control";
			$this->service_small_pic->EditCustomAttributes = "";
			$this->service_small_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_small_pic->Upload->DbValue)) {
				$this->service_small_pic->ImageWidth = 120;
				$this->service_small_pic->ImageHeight = 75;
				$this->service_small_pic->ImageAlt = $this->service_small_pic->FldAlt();
				$this->service_small_pic->EditValue = $this->service_small_pic->Upload->DbValue;
			} else {
				$this->service_small_pic->EditValue = "";
			}
			if (!ew_Empty($this->service_small_pic->CurrentValue))
				$this->service_small_pic->Upload->FileName = $this->service_small_pic->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->service_small_pic);

			// service_large_pic
			$this->service_large_pic->EditAttrs["class"] = "form-control";
			$this->service_large_pic->EditCustomAttributes = "";
			$this->service_large_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_large_pic->Upload->DbValue)) {
				$this->service_large_pic->ImageWidth = 120;
				$this->service_large_pic->ImageHeight = 75;
				$this->service_large_pic->ImageAlt = $this->service_large_pic->FldAlt();
				$this->service_large_pic->EditValue = $this->service_large_pic->Upload->DbValue;
			} else {
				$this->service_large_pic->EditValue = "";
			}
			if (!ew_Empty($this->service_large_pic->CurrentValue))
				$this->service_large_pic->Upload->FileName = $this->service_large_pic->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->service_large_pic);

			// service_title
			$this->service_title->EditAttrs["class"] = "form-control";
			$this->service_title->EditCustomAttributes = "";
			$this->service_title->EditValue = ew_HtmlEncode($this->service_title->CurrentValue);
			$this->service_title->PlaceHolder = ew_RemoveHtml($this->service_title->FldCaption());

			// service_content
			$this->service_content->EditAttrs["class"] = "form-control";
			$this->service_content->EditCustomAttributes = "";
			$this->service_content->EditValue = ew_HtmlEncode($this->service_content->CurrentValue);
			$this->service_content->PlaceHolder = ew_RemoveHtml($this->service_content->FldCaption());

			// service_icon
			$this->service_icon->EditAttrs["class"] = "form-control";
			$this->service_icon->EditCustomAttributes = "";
			$this->service_icon->EditValue = $this->service_icon->Options(TRUE);

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// service_small_pic

			$this->service_small_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_small_pic->Upload->DbValue)) {
				$this->service_small_pic->HrefValue = ew_GetFileUploadUrl($this->service_small_pic, $this->service_small_pic->Upload->DbValue); // Add prefix/suffix
				$this->service_small_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->service_small_pic->HrefValue = ew_ConvertFullUrl($this->service_small_pic->HrefValue);
			} else {
				$this->service_small_pic->HrefValue = "";
			}
			$this->service_small_pic->HrefValue2 = $this->service_small_pic->UploadPath . $this->service_small_pic->Upload->DbValue;

			// service_large_pic
			$this->service_large_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_large_pic->Upload->DbValue)) {
				$this->service_large_pic->HrefValue = ew_GetFileUploadUrl($this->service_large_pic, $this->service_large_pic->Upload->DbValue); // Add prefix/suffix
				$this->service_large_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->service_large_pic->HrefValue = ew_ConvertFullUrl($this->service_large_pic->HrefValue);
			} else {
				$this->service_large_pic->HrefValue = "";
			}
			$this->service_large_pic->HrefValue2 = $this->service_large_pic->UploadPath . $this->service_large_pic->Upload->DbValue;

			// service_title
			$this->service_title->HrefValue = "";

			// service_content
			$this->service_content->HrefValue = "";

			// service_icon
			$this->service_icon->HrefValue = "";

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
		if ($this->service_small_pic->Upload->FileName == "" && !$this->service_small_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->service_small_pic->FldCaption(), $this->service_small_pic->ReqErrMsg));
		}
		if ($this->service_large_pic->Upload->FileName == "" && !$this->service_large_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->service_large_pic->FldCaption(), $this->service_large_pic->ReqErrMsg));
		}
		if (!$this->service_title->FldIsDetailKey && !is_null($this->service_title->FormValue) && $this->service_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->service_title->FldCaption(), $this->service_title->ReqErrMsg));
		}
		if (!$this->service_content->FldIsDetailKey && !is_null($this->service_content->FormValue) && $this->service_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->service_content->FldCaption(), $this->service_content->ReqErrMsg));
		}
		if (!$this->service_icon->FldIsDetailKey && !is_null($this->service_icon->FormValue) && $this->service_icon->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->service_icon->FldCaption(), $this->service_icon->ReqErrMsg));
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
			$this->service_small_pic->OldUploadPath = '../src/assets/images/resource/services';
			$this->service_small_pic->UploadPath = $this->service_small_pic->OldUploadPath;
			$this->service_large_pic->OldUploadPath = '../src/assets/images/resource/services';
			$this->service_large_pic->UploadPath = $this->service_large_pic->OldUploadPath;
		}
		$rsnew = array();

		// service_small_pic
		if (!$this->service_small_pic->Upload->KeepFile) {
			$this->service_small_pic->Upload->DbValue = ""; // No need to delete old file
			if ($this->service_small_pic->Upload->FileName == "") {
				$rsnew['service_small_pic'] = NULL;
			} else {
				$rsnew['service_small_pic'] = $this->service_small_pic->Upload->FileName;
			}
			$this->service_small_pic->ImageWidth = 380; // Resize width
			$this->service_small_pic->ImageHeight = 210; // Resize height
		}

		// service_large_pic
		if (!$this->service_large_pic->Upload->KeepFile) {
			$this->service_large_pic->Upload->DbValue = ""; // No need to delete old file
			if ($this->service_large_pic->Upload->FileName == "") {
				$rsnew['service_large_pic'] = NULL;
			} else {
				$rsnew['service_large_pic'] = $this->service_large_pic->Upload->FileName;
			}
			$this->service_large_pic->ImageWidth = 796; // Resize width
			$this->service_large_pic->ImageHeight = 440; // Resize height
		}

		// service_title
		$this->service_title->SetDbValueDef($rsnew, $this->service_title->CurrentValue, "", FALSE);

		// service_content
		$this->service_content->SetDbValueDef($rsnew, $this->service_content->CurrentValue, "", FALSE);

		// service_icon
		$this->service_icon->SetDbValueDef($rsnew, $this->service_icon->CurrentValue, "", FALSE);

		// sort_order
		$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");
		if (!$this->service_small_pic->Upload->KeepFile) {
			$this->service_small_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_small_pic->Upload->Value)) {
				$rsnew['service_small_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->service_small_pic->UploadPath), $rsnew['service_small_pic']); // Get new file name
			}
		}
		if (!$this->service_large_pic->Upload->KeepFile) {
			$this->service_large_pic->UploadPath = '../src/assets/images/resource/services';
			if (!ew_Empty($this->service_large_pic->Upload->Value)) {
				$rsnew['service_large_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->service_large_pic->UploadPath), $rsnew['service_large_pic']); // Get new file name
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
				$this->service_id->setDbValue($conn->Insert_ID());
				$rsnew['service_id'] = $this->service_id->DbValue;
				if (!$this->service_small_pic->Upload->KeepFile) {
					if (!ew_Empty($this->service_small_pic->Upload->Value)) {
						$this->service_small_pic->Upload->Resize($this->service_small_pic->ImageWidth, $this->service_small_pic->ImageHeight);
						$this->service_small_pic->Upload->SaveToFile($this->service_small_pic->UploadPath, $rsnew['service_small_pic'], TRUE);
					}
				}
				if (!$this->service_large_pic->Upload->KeepFile) {
					if (!ew_Empty($this->service_large_pic->Upload->Value)) {
						$this->service_large_pic->Upload->Resize($this->service_large_pic->ImageWidth, $this->service_large_pic->ImageHeight);
						$this->service_large_pic->Upload->SaveToFile($this->service_large_pic->UploadPath, $rsnew['service_large_pic'], TRUE);
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

		// service_small_pic
		ew_CleanUploadTempPath($this->service_small_pic, $this->service_small_pic->Upload->Index);

		// service_large_pic
		ew_CleanUploadTempPath($this->service_large_pic, $this->service_large_pic->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "serviceslist.php", "", $this->TableVar, TRUE);
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
if (!isset($services_add)) $services_add = new cservices_add();

// Page init
$services_add->Page_Init();

// Page main
$services_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$services_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fservicesadd = new ew_Form("fservicesadd", "add");

// Validate form
fservicesadd.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_service_small_pic");
			elm = this.GetElements("fn_x" + infix + "_service_small_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $services->service_small_pic->FldCaption(), $services->service_small_pic->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_service_large_pic");
			elm = this.GetElements("fn_x" + infix + "_service_large_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $services->service_large_pic->FldCaption(), $services->service_large_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_service_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $services->service_title->FldCaption(), $services->service_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_service_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $services->service_content->FldCaption(), $services->service_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_service_icon");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $services->service_icon->FldCaption(), $services->service_icon->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $services->sort_order->FldCaption(), $services->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($services->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $services->status->FldCaption(), $services->status->ReqErrMsg)) ?>");

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
fservicesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fservicesadd.ValidateRequired = true;
<?php } else { ?>
fservicesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fservicesadd.Lists["x_service_icon"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fservicesadd.Lists["x_service_icon"].Options = <?php echo json_encode($services->service_icon->Options()) ?>;
fservicesadd.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fservicesadd.Lists["x_status"].Options = <?php echo json_encode($services->status->Options()) ?>;

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
<?php $services_add->ShowPageHeader(); ?>
<?php
$services_add->ShowMessage();
?>
<form name="fservicesadd" id="fservicesadd" class="<?php echo $services_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($services_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $services_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="services">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($services->service_small_pic->Visible) { // service_small_pic ?>
	<div id="r_service_small_pic" class="form-group">
		<label id="elh_services_service_small_pic" class="col-sm-2 control-label ewLabel"><?php echo $services->service_small_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_small_pic->CellAttributes() ?>>
<span id="el_services_service_small_pic">
<div id="fd_x_service_small_pic">
<span title="<?php echo $services->service_small_pic->FldTitle() ? $services->service_small_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($services->service_small_pic->ReadOnly || $services->service_small_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="services" data-field="x_service_small_pic" name="x_service_small_pic" id="x_service_small_pic"<?php echo $services->service_small_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_service_small_pic" id= "fn_x_service_small_pic" value="<?php echo $services->service_small_pic->Upload->FileName ?>">
<input type="hidden" name="fa_x_service_small_pic" id= "fa_x_service_small_pic" value="0">
<input type="hidden" name="fs_x_service_small_pic" id= "fs_x_service_small_pic" value="255">
<input type="hidden" name="fx_x_service_small_pic" id= "fx_x_service_small_pic" value="<?php echo $services->service_small_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_service_small_pic" id= "fm_x_service_small_pic" value="<?php echo $services->service_small_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_service_small_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $services->service_small_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_large_pic->Visible) { // service_large_pic ?>
	<div id="r_service_large_pic" class="form-group">
		<label id="elh_services_service_large_pic" class="col-sm-2 control-label ewLabel"><?php echo $services->service_large_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_large_pic->CellAttributes() ?>>
<span id="el_services_service_large_pic">
<div id="fd_x_service_large_pic">
<span title="<?php echo $services->service_large_pic->FldTitle() ? $services->service_large_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($services->service_large_pic->ReadOnly || $services->service_large_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="services" data-field="x_service_large_pic" name="x_service_large_pic" id="x_service_large_pic"<?php echo $services->service_large_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_service_large_pic" id= "fn_x_service_large_pic" value="<?php echo $services->service_large_pic->Upload->FileName ?>">
<input type="hidden" name="fa_x_service_large_pic" id= "fa_x_service_large_pic" value="0">
<input type="hidden" name="fs_x_service_large_pic" id= "fs_x_service_large_pic" value="255">
<input type="hidden" name="fx_x_service_large_pic" id= "fx_x_service_large_pic" value="<?php echo $services->service_large_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_service_large_pic" id= "fm_x_service_large_pic" value="<?php echo $services->service_large_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_service_large_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $services->service_large_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_title->Visible) { // service_title ?>
	<div id="r_service_title" class="form-group">
		<label id="elh_services_service_title" for="x_service_title" class="col-sm-2 control-label ewLabel"><?php echo $services->service_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_title->CellAttributes() ?>>
<span id="el_services_service_title">
<input type="text" data-table="services" data-field="x_service_title" name="x_service_title" id="x_service_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($services->service_title->getPlaceHolder()) ?>" value="<?php echo $services->service_title->EditValue ?>"<?php echo $services->service_title->EditAttributes() ?>>
</span>
<?php echo $services->service_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_content->Visible) { // service_content ?>
	<div id="r_service_content" class="form-group">
		<label id="elh_services_service_content" class="col-sm-2 control-label ewLabel"><?php echo $services->service_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_content->CellAttributes() ?>>
<span id="el_services_service_content">
<?php ew_AppendClass($services->service_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="services" data-field="x_service_content" name="x_service_content" id="x_service_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($services->service_content->getPlaceHolder()) ?>"<?php echo $services->service_content->EditAttributes() ?>><?php echo $services->service_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fservicesadd", "x_service_content", 35, 4, <?php echo ($services->service_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $services->service_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_icon->Visible) { // service_icon ?>
	<div id="r_service_icon" class="form-group">
		<label id="elh_services_service_icon" for="x_service_icon" class="col-sm-2 control-label ewLabel"><?php echo $services->service_icon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_icon->CellAttributes() ?>>
<span id="el_services_service_icon">
<select data-table="services" data-field="x_service_icon" data-value-separator="<?php echo ew_HtmlEncode(is_array($services->service_icon->DisplayValueSeparator) ? json_encode($services->service_icon->DisplayValueSeparator) : $services->service_icon->DisplayValueSeparator) ?>" id="x_service_icon" name="x_service_icon"<?php echo $services->service_icon->EditAttributes() ?>>
<?php
if (is_array($services->service_icon->EditValue)) {
	$arwrk = $services->service_icon->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($services->service_icon->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $services->service_icon->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($services->service_icon->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($services->service_icon->CurrentValue) ?>" selected><?php echo $services->service_icon->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $services->service_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_services_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $services->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->sort_order->CellAttributes() ?>>
<span id="el_services_sort_order">
<input type="text" data-table="services" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($services->sort_order->getPlaceHolder()) ?>" value="<?php echo $services->sort_order->EditValue ?>"<?php echo $services->sort_order->EditAttributes() ?>>
</span>
<?php echo $services->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_services_status" class="col-sm-2 control-label ewLabel"><?php echo $services->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $services->status->CellAttributes() ?>>
<span id="el_services_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="services" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($services->status->DisplayValueSeparator) ? json_encode($services->status->DisplayValueSeparator) : $services->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $services->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $services->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($services->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="services" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $services->status->EditAttributes() ?>><?php echo $services->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($services->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="services" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($services->status->CurrentValue) ?>" checked<?php echo $services->status->EditAttributes() ?>><?php echo $services->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $services->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $services_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fservicesadd.Init();
</script>
<?php
$services_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$services_add->Page_Terminate();
?>
