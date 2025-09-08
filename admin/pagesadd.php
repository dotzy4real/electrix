<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "pagesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$pages_add = NULL; // Initialize page object first

class cpages_add extends cpages {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'pages';

	// Page object name
	var $PageObjName = 'pages_add';

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

		// Table object (pages)
		if (!isset($GLOBALS["pages"]) || get_class($GLOBALS["pages"]) == "cpages") {
			$GLOBALS["pages"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pages"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pages', TRUE);

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
		global $EW_EXPORT, $pages;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pages);
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
			if (@$_GET["page_id"] != "") {
				$this->page_id->setQueryStringValue($_GET["page_id"]);
				$this->setKey("page_id", $this->page_id->CurrentValue); // Set up key
			} else {
				$this->setKey("page_id", ""); // Clear key
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
					$this->Page_Terminate("pageslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "pagesview.php")
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
		$this->page_banner->Upload->Index = $objForm->Index;
		$this->page_banner->Upload->UploadFile();
		$this->page_banner->CurrentValue = $this->page_banner->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->page_name->CurrentValue = NULL;
		$this->page_name->OldValue = $this->page_name->CurrentValue;
		$this->page_icon_title->CurrentValue = NULL;
		$this->page_icon_title->OldValue = $this->page_icon_title->CurrentValue;
		$this->page_title->CurrentValue = NULL;
		$this->page_title->OldValue = $this->page_title->CurrentValue;
		$this->page_breadcumb_title->CurrentValue = NULL;
		$this->page_breadcumb_title->OldValue = $this->page_breadcumb_title->CurrentValue;
		$this->page_content->CurrentValue = NULL;
		$this->page_content->OldValue = $this->page_content->CurrentValue;
		$this->page_banner->Upload->DbValue = NULL;
		$this->page_banner->OldValue = $this->page_banner->Upload->DbValue;
		$this->page_banner->CurrentValue = NULL; // Clear file related field
		$this->page_title_caption->CurrentValue = NULL;
		$this->page_title_caption->OldValue = $this->page_title_caption->CurrentValue;
		$this->page_show_title->CurrentValue = "inactive";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->page_name->FldIsDetailKey) {
			$this->page_name->setFormValue($objForm->GetValue("x_page_name"));
		}
		if (!$this->page_icon_title->FldIsDetailKey) {
			$this->page_icon_title->setFormValue($objForm->GetValue("x_page_icon_title"));
		}
		if (!$this->page_title->FldIsDetailKey) {
			$this->page_title->setFormValue($objForm->GetValue("x_page_title"));
		}
		if (!$this->page_breadcumb_title->FldIsDetailKey) {
			$this->page_breadcumb_title->setFormValue($objForm->GetValue("x_page_breadcumb_title"));
		}
		if (!$this->page_content->FldIsDetailKey) {
			$this->page_content->setFormValue($objForm->GetValue("x_page_content"));
		}
		if (!$this->page_title_caption->FldIsDetailKey) {
			$this->page_title_caption->setFormValue($objForm->GetValue("x_page_title_caption"));
		}
		if (!$this->page_show_title->FldIsDetailKey) {
			$this->page_show_title->setFormValue($objForm->GetValue("x_page_show_title"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->page_name->CurrentValue = $this->page_name->FormValue;
		$this->page_icon_title->CurrentValue = $this->page_icon_title->FormValue;
		$this->page_title->CurrentValue = $this->page_title->FormValue;
		$this->page_breadcumb_title->CurrentValue = $this->page_breadcumb_title->FormValue;
		$this->page_content->CurrentValue = $this->page_content->FormValue;
		$this->page_title_caption->CurrentValue = $this->page_title_caption->FormValue;
		$this->page_show_title->CurrentValue = $this->page_show_title->FormValue;
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
		$this->page_id->setDbValue($rs->fields('page_id'));
		$this->page_name->setDbValue($rs->fields('page_name'));
		$this->page_icon_title->setDbValue($rs->fields('page_icon_title'));
		$this->page_title->setDbValue($rs->fields('page_title'));
		$this->page_breadcumb_title->setDbValue($rs->fields('page_breadcumb_title'));
		$this->page_content->setDbValue($rs->fields('page_content'));
		$this->page_banner->Upload->DbValue = $rs->fields('page_banner');
		$this->page_banner->CurrentValue = $this->page_banner->Upload->DbValue;
		$this->page_title_caption->setDbValue($rs->fields('page_title_caption'));
		$this->page_show_title->setDbValue($rs->fields('page_show_title'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->page_id->DbValue = $row['page_id'];
		$this->page_name->DbValue = $row['page_name'];
		$this->page_icon_title->DbValue = $row['page_icon_title'];
		$this->page_title->DbValue = $row['page_title'];
		$this->page_breadcumb_title->DbValue = $row['page_breadcumb_title'];
		$this->page_content->DbValue = $row['page_content'];
		$this->page_banner->Upload->DbValue = $row['page_banner'];
		$this->page_title_caption->DbValue = $row['page_title_caption'];
		$this->page_show_title->DbValue = $row['page_show_title'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("page_id")) <> "")
			$this->page_id->CurrentValue = $this->getKey("page_id"); // page_id
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
		// page_id
		// page_name
		// page_icon_title
		// page_title
		// page_breadcumb_title
		// page_content
		// page_banner
		// page_title_caption
		// page_show_title

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// page_id
		$this->page_id->ViewValue = $this->page_id->CurrentValue;
		$this->page_id->ViewCustomAttributes = "";

		// page_name
		$this->page_name->ViewValue = $this->page_name->CurrentValue;
		$this->page_name->ViewCustomAttributes = "";

		// page_icon_title
		$this->page_icon_title->ViewValue = $this->page_icon_title->CurrentValue;
		$this->page_icon_title->ViewCustomAttributes = "";

		// page_title
		$this->page_title->ViewValue = $this->page_title->CurrentValue;
		$this->page_title->ViewCustomAttributes = "";

		// page_breadcumb_title
		$this->page_breadcumb_title->ViewValue = $this->page_breadcumb_title->CurrentValue;
		$this->page_breadcumb_title->ViewCustomAttributes = "";

		// page_content
		$this->page_content->ViewValue = $this->page_content->CurrentValue;
		$this->page_content->ViewCustomAttributes = "";

		// page_banner
		$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
		if (!ew_Empty($this->page_banner->Upload->DbValue)) {
			$this->page_banner->ImageWidth = 120;
			$this->page_banner->ImageHeight = 65;
			$this->page_banner->ImageAlt = $this->page_banner->FldAlt();
			$this->page_banner->ViewValue = $this->page_banner->Upload->DbValue;
		} else {
			$this->page_banner->ViewValue = "";
		}
		$this->page_banner->ViewCustomAttributes = "";

		// page_title_caption
		$this->page_title_caption->ViewValue = $this->page_title_caption->CurrentValue;
		$this->page_title_caption->ViewCustomAttributes = "";

		// page_show_title
		if (strval($this->page_show_title->CurrentValue) <> "") {
			$this->page_show_title->ViewValue = $this->page_show_title->OptionCaption($this->page_show_title->CurrentValue);
		} else {
			$this->page_show_title->ViewValue = NULL;
		}
		$this->page_show_title->ViewCustomAttributes = "";

			// page_name
			$this->page_name->LinkCustomAttributes = "";
			$this->page_name->HrefValue = "";
			$this->page_name->TooltipValue = "";

			// page_icon_title
			$this->page_icon_title->LinkCustomAttributes = "";
			$this->page_icon_title->HrefValue = "";
			$this->page_icon_title->TooltipValue = "";

			// page_title
			$this->page_title->LinkCustomAttributes = "";
			$this->page_title->HrefValue = "";
			$this->page_title->TooltipValue = "";

			// page_breadcumb_title
			$this->page_breadcumb_title->LinkCustomAttributes = "";
			$this->page_breadcumb_title->HrefValue = "";
			$this->page_breadcumb_title->TooltipValue = "";

			// page_content
			$this->page_content->LinkCustomAttributes = "";
			$this->page_content->HrefValue = "";
			$this->page_content->TooltipValue = "";

			// page_banner
			$this->page_banner->LinkCustomAttributes = "";
			$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
			if (!ew_Empty($this->page_banner->Upload->DbValue)) {
				$this->page_banner->HrefValue = ew_GetFileUploadUrl($this->page_banner, $this->page_banner->Upload->DbValue); // Add prefix/suffix
				$this->page_banner->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->page_banner->HrefValue = ew_ConvertFullUrl($this->page_banner->HrefValue);
			} else {
				$this->page_banner->HrefValue = "";
			}
			$this->page_banner->HrefValue2 = $this->page_banner->UploadPath . $this->page_banner->Upload->DbValue;
			$this->page_banner->TooltipValue = "";
			if ($this->page_banner->UseColorbox) {
				$this->page_banner->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->page_banner->LinkAttrs["data-rel"] = "pages_x_page_banner";

				//$this->page_banner->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->page_banner->LinkAttrs["data-placement"] = "bottom";
				//$this->page_banner->LinkAttrs["data-container"] = "body";

				$this->page_banner->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// page_title_caption
			$this->page_title_caption->LinkCustomAttributes = "";
			$this->page_title_caption->HrefValue = "";
			$this->page_title_caption->TooltipValue = "";

			// page_show_title
			$this->page_show_title->LinkCustomAttributes = "";
			$this->page_show_title->HrefValue = "";
			$this->page_show_title->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// page_name
			$this->page_name->EditAttrs["class"] = "form-control";
			$this->page_name->EditCustomAttributes = "";
			$this->page_name->EditValue = ew_HtmlEncode($this->page_name->CurrentValue);
			$this->page_name->PlaceHolder = ew_RemoveHtml($this->page_name->FldCaption());

			// page_icon_title
			$this->page_icon_title->EditAttrs["class"] = "form-control";
			$this->page_icon_title->EditCustomAttributes = "";
			$this->page_icon_title->EditValue = ew_HtmlEncode($this->page_icon_title->CurrentValue);
			$this->page_icon_title->PlaceHolder = ew_RemoveHtml($this->page_icon_title->FldCaption());

			// page_title
			$this->page_title->EditAttrs["class"] = "form-control";
			$this->page_title->EditCustomAttributes = "";
			$this->page_title->EditValue = ew_HtmlEncode($this->page_title->CurrentValue);
			$this->page_title->PlaceHolder = ew_RemoveHtml($this->page_title->FldCaption());

			// page_breadcumb_title
			$this->page_breadcumb_title->EditAttrs["class"] = "form-control";
			$this->page_breadcumb_title->EditCustomAttributes = "";
			$this->page_breadcumb_title->EditValue = ew_HtmlEncode($this->page_breadcumb_title->CurrentValue);
			$this->page_breadcumb_title->PlaceHolder = ew_RemoveHtml($this->page_breadcumb_title->FldCaption());

			// page_content
			$this->page_content->EditAttrs["class"] = "form-control";
			$this->page_content->EditCustomAttributes = "";
			$this->page_content->EditValue = ew_HtmlEncode($this->page_content->CurrentValue);
			$this->page_content->PlaceHolder = ew_RemoveHtml($this->page_content->FldCaption());

			// page_banner
			$this->page_banner->EditAttrs["class"] = "form-control";
			$this->page_banner->EditCustomAttributes = "";
			$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
			if (!ew_Empty($this->page_banner->Upload->DbValue)) {
				$this->page_banner->ImageWidth = 120;
				$this->page_banner->ImageHeight = 65;
				$this->page_banner->ImageAlt = $this->page_banner->FldAlt();
				$this->page_banner->EditValue = $this->page_banner->Upload->DbValue;
			} else {
				$this->page_banner->EditValue = "";
			}
			if (!ew_Empty($this->page_banner->CurrentValue))
				$this->page_banner->Upload->FileName = $this->page_banner->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->page_banner);

			// page_title_caption
			$this->page_title_caption->EditAttrs["class"] = "form-control";
			$this->page_title_caption->EditCustomAttributes = "";
			$this->page_title_caption->EditValue = ew_HtmlEncode($this->page_title_caption->CurrentValue);
			$this->page_title_caption->PlaceHolder = ew_RemoveHtml($this->page_title_caption->FldCaption());

			// page_show_title
			$this->page_show_title->EditCustomAttributes = "";
			$this->page_show_title->EditValue = $this->page_show_title->Options(FALSE);

			// Edit refer script
			// page_name

			$this->page_name->HrefValue = "";

			// page_icon_title
			$this->page_icon_title->HrefValue = "";

			// page_title
			$this->page_title->HrefValue = "";

			// page_breadcumb_title
			$this->page_breadcumb_title->HrefValue = "";

			// page_content
			$this->page_content->HrefValue = "";

			// page_banner
			$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
			if (!ew_Empty($this->page_banner->Upload->DbValue)) {
				$this->page_banner->HrefValue = ew_GetFileUploadUrl($this->page_banner, $this->page_banner->Upload->DbValue); // Add prefix/suffix
				$this->page_banner->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->page_banner->HrefValue = ew_ConvertFullUrl($this->page_banner->HrefValue);
			} else {
				$this->page_banner->HrefValue = "";
			}
			$this->page_banner->HrefValue2 = $this->page_banner->UploadPath . $this->page_banner->Upload->DbValue;

			// page_title_caption
			$this->page_title_caption->HrefValue = "";

			// page_show_title
			$this->page_show_title->HrefValue = "";
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
		if (!$this->page_name->FldIsDetailKey && !is_null($this->page_name->FormValue) && $this->page_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_name->FldCaption(), $this->page_name->ReqErrMsg));
		}
		if (!$this->page_title->FldIsDetailKey && !is_null($this->page_title->FormValue) && $this->page_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_title->FldCaption(), $this->page_title->ReqErrMsg));
		}
		if (!$this->page_breadcumb_title->FldIsDetailKey && !is_null($this->page_breadcumb_title->FormValue) && $this->page_breadcumb_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_breadcumb_title->FldCaption(), $this->page_breadcumb_title->ReqErrMsg));
		}
		if ($this->page_banner->Upload->FileName == "" && !$this->page_banner->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_banner->FldCaption(), $this->page_banner->ReqErrMsg));
		}
		if ($this->page_show_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_show_title->FldCaption(), $this->page_show_title->ReqErrMsg));
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
			$this->page_banner->OldUploadPath = '../src/assets/images/resource/pagebanners';
			$this->page_banner->UploadPath = $this->page_banner->OldUploadPath;
		}
		$rsnew = array();

		// page_name
		$this->page_name->SetDbValueDef($rsnew, $this->page_name->CurrentValue, "", FALSE);

		// page_icon_title
		$this->page_icon_title->SetDbValueDef($rsnew, $this->page_icon_title->CurrentValue, NULL, FALSE);

		// page_title
		$this->page_title->SetDbValueDef($rsnew, $this->page_title->CurrentValue, "", FALSE);

		// page_breadcumb_title
		$this->page_breadcumb_title->SetDbValueDef($rsnew, $this->page_breadcumb_title->CurrentValue, "", FALSE);

		// page_content
		$this->page_content->SetDbValueDef($rsnew, $this->page_content->CurrentValue, NULL, FALSE);

		// page_banner
		if (!$this->page_banner->Upload->KeepFile) {
			$this->page_banner->Upload->DbValue = ""; // No need to delete old file
			if ($this->page_banner->Upload->FileName == "") {
				$rsnew['page_banner'] = NULL;
			} else {
				$rsnew['page_banner'] = $this->page_banner->Upload->FileName;
			}
			$this->page_banner->ImageWidth = 1600; // Resize width
			$this->page_banner->ImageHeight = 833; // Resize height
		}

		// page_title_caption
		$this->page_title_caption->SetDbValueDef($rsnew, $this->page_title_caption->CurrentValue, NULL, FALSE);

		// page_show_title
		$this->page_show_title->SetDbValueDef($rsnew, $this->page_show_title->CurrentValue, "", strval($this->page_show_title->CurrentValue) == "");
		if (!$this->page_banner->Upload->KeepFile) {
			$this->page_banner->UploadPath = '../src/assets/images/resource/pagebanners';
			if (!ew_Empty($this->page_banner->Upload->Value)) {
				$rsnew['page_banner'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->page_banner->UploadPath), $rsnew['page_banner']); // Get new file name
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
				$this->page_id->setDbValue($conn->Insert_ID());
				$rsnew['page_id'] = $this->page_id->DbValue;
				if (!$this->page_banner->Upload->KeepFile) {
					if (!ew_Empty($this->page_banner->Upload->Value)) {
						$this->page_banner->Upload->Resize($this->page_banner->ImageWidth, $this->page_banner->ImageHeight);
						$this->page_banner->Upload->SaveToFile($this->page_banner->UploadPath, $rsnew['page_banner'], TRUE);
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

		// page_banner
		ew_CleanUploadTempPath($this->page_banner, $this->page_banner->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "pageslist.php", "", $this->TableVar, TRUE);
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
if (!isset($pages_add)) $pages_add = new cpages_add();

// Page init
$pages_add->Page_Init();

// Page main
$pages_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pages_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpagesadd = new ew_Form("fpagesadd", "add");

// Validate form
fpagesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_page_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pages->page_name->FldCaption(), $pages->page_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pages->page_title->FldCaption(), $pages->page_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_breadcumb_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pages->page_breadcumb_title->FldCaption(), $pages->page_breadcumb_title->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_page_banner");
			elm = this.GetElements("fn_x" + infix + "_page_banner");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $pages->page_banner->FldCaption(), $pages->page_banner->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_show_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pages->page_show_title->FldCaption(), $pages->page_show_title->ReqErrMsg)) ?>");

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
fpagesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpagesadd.ValidateRequired = true;
<?php } else { ?>
fpagesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpagesadd.Lists["x_page_show_title"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpagesadd.Lists["x_page_show_title"].Options = <?php echo json_encode($pages->page_show_title->Options()) ?>;

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
<?php $pages_add->ShowPageHeader(); ?>
<?php
$pages_add->ShowMessage();
?>
<form name="fpagesadd" id="fpagesadd" class="<?php echo $pages_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pages_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pages_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pages">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($pages->page_name->Visible) { // page_name ?>
	<div id="r_page_name" class="form-group">
		<label id="elh_pages_page_name" for="x_page_name" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_name->CellAttributes() ?>>
<span id="el_pages_page_name">
<input type="text" data-table="pages" data-field="x_page_name" name="x_page_name" id="x_page_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pages->page_name->getPlaceHolder()) ?>" value="<?php echo $pages->page_name->EditValue ?>"<?php echo $pages->page_name->EditAttributes() ?>>
</span>
<?php echo $pages->page_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_icon_title->Visible) { // page_icon_title ?>
	<div id="r_page_icon_title" class="form-group">
		<label id="elh_pages_page_icon_title" for="x_page_icon_title" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_icon_title->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_icon_title->CellAttributes() ?>>
<span id="el_pages_page_icon_title">
<input type="text" data-table="pages" data-field="x_page_icon_title" name="x_page_icon_title" id="x_page_icon_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pages->page_icon_title->getPlaceHolder()) ?>" value="<?php echo $pages->page_icon_title->EditValue ?>"<?php echo $pages->page_icon_title->EditAttributes() ?>>
</span>
<?php echo $pages->page_icon_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_title->Visible) { // page_title ?>
	<div id="r_page_title" class="form-group">
		<label id="elh_pages_page_title" for="x_page_title" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_title->CellAttributes() ?>>
<span id="el_pages_page_title">
<input type="text" data-table="pages" data-field="x_page_title" name="x_page_title" id="x_page_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pages->page_title->getPlaceHolder()) ?>" value="<?php echo $pages->page_title->EditValue ?>"<?php echo $pages->page_title->EditAttributes() ?>>
</span>
<?php echo $pages->page_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_breadcumb_title->Visible) { // page_breadcumb_title ?>
	<div id="r_page_breadcumb_title" class="form-group">
		<label id="elh_pages_page_breadcumb_title" for="x_page_breadcumb_title" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_breadcumb_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_breadcumb_title->CellAttributes() ?>>
<span id="el_pages_page_breadcumb_title">
<input type="text" data-table="pages" data-field="x_page_breadcumb_title" name="x_page_breadcumb_title" id="x_page_breadcumb_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pages->page_breadcumb_title->getPlaceHolder()) ?>" value="<?php echo $pages->page_breadcumb_title->EditValue ?>"<?php echo $pages->page_breadcumb_title->EditAttributes() ?>>
</span>
<?php echo $pages->page_breadcumb_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_content->Visible) { // page_content ?>
	<div id="r_page_content" class="form-group">
		<label id="elh_pages_page_content" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_content->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_content->CellAttributes() ?>>
<span id="el_pages_page_content">
<?php ew_AppendClass($pages->page_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="pages" data-field="x_page_content" name="x_page_content" id="x_page_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($pages->page_content->getPlaceHolder()) ?>"<?php echo $pages->page_content->EditAttributes() ?>><?php echo $pages->page_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fpagesadd", "x_page_content", 35, 4, <?php echo ($pages->page_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $pages->page_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_banner->Visible) { // page_banner ?>
	<div id="r_page_banner" class="form-group">
		<label id="elh_pages_page_banner" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_banner->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_banner->CellAttributes() ?>>
<span id="el_pages_page_banner">
<div id="fd_x_page_banner">
<span title="<?php echo $pages->page_banner->FldTitle() ? $pages->page_banner->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($pages->page_banner->ReadOnly || $pages->page_banner->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="pages" data-field="x_page_banner" name="x_page_banner" id="x_page_banner"<?php echo $pages->page_banner->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_page_banner" id= "fn_x_page_banner" value="<?php echo $pages->page_banner->Upload->FileName ?>">
<input type="hidden" name="fa_x_page_banner" id= "fa_x_page_banner" value="0">
<input type="hidden" name="fs_x_page_banner" id= "fs_x_page_banner" value="255">
<input type="hidden" name="fx_x_page_banner" id= "fx_x_page_banner" value="<?php echo $pages->page_banner->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_page_banner" id= "fm_x_page_banner" value="<?php echo $pages->page_banner->UploadMaxFileSize ?>">
</div>
<table id="ft_x_page_banner" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $pages->page_banner->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_title_caption->Visible) { // page_title_caption ?>
	<div id="r_page_title_caption" class="form-group">
		<label id="elh_pages_page_title_caption" for="x_page_title_caption" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_title_caption->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_title_caption->CellAttributes() ?>>
<span id="el_pages_page_title_caption">
<input type="text" data-table="pages" data-field="x_page_title_caption" name="x_page_title_caption" id="x_page_title_caption" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pages->page_title_caption->getPlaceHolder()) ?>" value="<?php echo $pages->page_title_caption->EditValue ?>"<?php echo $pages->page_title_caption->EditAttributes() ?>>
</span>
<?php echo $pages->page_title_caption->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pages->page_show_title->Visible) { // page_show_title ?>
	<div id="r_page_show_title" class="form-group">
		<label id="elh_pages_page_show_title" class="col-sm-2 control-label ewLabel"><?php echo $pages->page_show_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pages->page_show_title->CellAttributes() ?>>
<span id="el_pages_page_show_title">
<div id="tp_x_page_show_title" class="ewTemplate"><input type="radio" data-table="pages" data-field="x_page_show_title" data-value-separator="<?php echo ew_HtmlEncode(is_array($pages->page_show_title->DisplayValueSeparator) ? json_encode($pages->page_show_title->DisplayValueSeparator) : $pages->page_show_title->DisplayValueSeparator) ?>" name="x_page_show_title" id="x_page_show_title" value="{value}"<?php echo $pages->page_show_title->EditAttributes() ?>></div>
<div id="dsl_x_page_show_title" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $pages->page_show_title->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pages->page_show_title->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="pages" data-field="x_page_show_title" name="x_page_show_title" id="x_page_show_title_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $pages->page_show_title->EditAttributes() ?>><?php echo $pages->page_show_title->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($pages->page_show_title->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="pages" data-field="x_page_show_title" name="x_page_show_title" id="x_page_show_title_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($pages->page_show_title->CurrentValue) ?>" checked<?php echo $pages->page_show_title->EditAttributes() ?>><?php echo $pages->page_show_title->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $pages->page_show_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pages_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpagesadd.Init();
</script>
<?php
$pages_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pages_add->Page_Terminate();
?>
