<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "kilowatt_aboutinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$kilowatt_about_view = NULL; // Initialize page object first

class ckilowatt_about_view extends ckilowatt_about {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'kilowatt_about';

	// Page object name
	var $PageObjName = 'kilowatt_about_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (kilowatt_about)
		if (!isset($GLOBALS["kilowatt_about"]) || get_class($GLOBALS["kilowatt_about"]) == "ckilowatt_about") {
			$GLOBALS["kilowatt_about"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["kilowatt_about"];
		}
		$KeyUrl = "";
		if (@$_GET["kilowatt_about_id"] <> "") {
			$this->RecKey["kilowatt_about_id"] = $_GET["kilowatt_about_id"];
			$KeyUrl .= "&amp;kilowatt_about_id=" . urlencode($this->RecKey["kilowatt_about_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'kilowatt_about', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		$this->kilowatt_about_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $kilowatt_about;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($kilowatt_about);
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["kilowatt_about_id"] <> "") {
				$this->kilowatt_about_id->setQueryStringValue($_GET["kilowatt_about_id"]);
				$this->RecKey["kilowatt_about_id"] = $this->kilowatt_about_id->QueryStringValue;
			} elseif (@$_POST["kilowatt_about_id"] <> "") {
				$this->kilowatt_about_id->setFormValue($_POST["kilowatt_about_id"]);
				$this->RecKey["kilowatt_about_id"] = $this->kilowatt_about_id->FormValue;
			} else {
				$sReturnUrl = "kilowatt_aboutlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "kilowatt_aboutlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "kilowatt_aboutlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->IsLoggedIn());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->kilowatt_about_id->setDbValue($rs->fields('kilowatt_about_id'));
		$this->kilowatt_about_left_pic->Upload->DbValue = $rs->fields('kilowatt_about_left_pic');
		$this->kilowatt_about_left_pic->CurrentValue = $this->kilowatt_about_left_pic->Upload->DbValue;
		$this->kilowatt_about_right_pic->Upload->DbValue = $rs->fields('kilowatt_about_right_pic');
		$this->kilowatt_about_right_pic->CurrentValue = $this->kilowatt_about_right_pic->Upload->DbValue;
		$this->kilowatt_about_experience_years->setDbValue($rs->fields('kilowatt_about_experience_years'));
		$this->kilowatt_about_icon_title->setDbValue($rs->fields('kilowatt_about_icon_title'));
		$this->kilowatt_about_title->setDbValue($rs->fields('kilowatt_about_title'));
		$this->kilowatt_about_snippet->setDbValue($rs->fields('kilowatt_about_snippet'));
		$this->kilowatt_about_full_content->setDbValue($rs->fields('kilowatt_about_full_content'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kilowatt_about_id->DbValue = $row['kilowatt_about_id'];
		$this->kilowatt_about_left_pic->Upload->DbValue = $row['kilowatt_about_left_pic'];
		$this->kilowatt_about_right_pic->Upload->DbValue = $row['kilowatt_about_right_pic'];
		$this->kilowatt_about_experience_years->DbValue = $row['kilowatt_about_experience_years'];
		$this->kilowatt_about_icon_title->DbValue = $row['kilowatt_about_icon_title'];
		$this->kilowatt_about_title->DbValue = $row['kilowatt_about_title'];
		$this->kilowatt_about_snippet->DbValue = $row['kilowatt_about_snippet'];
		$this->kilowatt_about_full_content->DbValue = $row['kilowatt_about_full_content'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// kilowatt_about_id
		// kilowatt_about_left_pic
		// kilowatt_about_right_pic
		// kilowatt_about_experience_years
		// kilowatt_about_icon_title
		// kilowatt_about_title
		// kilowatt_about_snippet
		// kilowatt_about_full_content

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kilowatt_about_id
		$this->kilowatt_about_id->ViewValue = $this->kilowatt_about_id->CurrentValue;
		$this->kilowatt_about_id->ViewCustomAttributes = "";

		// kilowatt_about_left_pic
		$this->kilowatt_about_left_pic->UploadPath = '../src/assets/images/kilowatt';
		if (!ew_Empty($this->kilowatt_about_left_pic->Upload->DbValue)) {
			$this->kilowatt_about_left_pic->ImageWidth = 80;
			$this->kilowatt_about_left_pic->ImageHeight = 120;
			$this->kilowatt_about_left_pic->ImageAlt = $this->kilowatt_about_left_pic->FldAlt();
			$this->kilowatt_about_left_pic->ViewValue = $this->kilowatt_about_left_pic->Upload->DbValue;
		} else {
			$this->kilowatt_about_left_pic->ViewValue = "";
		}
		$this->kilowatt_about_left_pic->ViewCustomAttributes = "";

		// kilowatt_about_right_pic
		$this->kilowatt_about_right_pic->UploadPath = '../src/assets/images/kilowatt';
		if (!ew_Empty($this->kilowatt_about_right_pic->Upload->DbValue)) {
			$this->kilowatt_about_right_pic->ImageWidth = 80;
			$this->kilowatt_about_right_pic->ImageHeight = 120;
			$this->kilowatt_about_right_pic->ImageAlt = $this->kilowatt_about_right_pic->FldAlt();
			$this->kilowatt_about_right_pic->ViewValue = $this->kilowatt_about_right_pic->Upload->DbValue;
		} else {
			$this->kilowatt_about_right_pic->ViewValue = "";
		}
		$this->kilowatt_about_right_pic->ViewCustomAttributes = "";

		// kilowatt_about_experience_years
		$this->kilowatt_about_experience_years->ViewValue = $this->kilowatt_about_experience_years->CurrentValue;
		$this->kilowatt_about_experience_years->ViewCustomAttributes = "";

		// kilowatt_about_icon_title
		$this->kilowatt_about_icon_title->ViewValue = $this->kilowatt_about_icon_title->CurrentValue;
		$this->kilowatt_about_icon_title->ViewCustomAttributes = "";

		// kilowatt_about_title
		$this->kilowatt_about_title->ViewValue = $this->kilowatt_about_title->CurrentValue;
		$this->kilowatt_about_title->ViewCustomAttributes = "";

		// kilowatt_about_snippet
		$this->kilowatt_about_snippet->ViewValue = $this->kilowatt_about_snippet->CurrentValue;
		$this->kilowatt_about_snippet->ViewCustomAttributes = "";

		// kilowatt_about_full_content
		$this->kilowatt_about_full_content->ViewValue = $this->kilowatt_about_full_content->CurrentValue;
		$this->kilowatt_about_full_content->ViewCustomAttributes = "";

			// kilowatt_about_id
			$this->kilowatt_about_id->LinkCustomAttributes = "";
			$this->kilowatt_about_id->HrefValue = "";
			$this->kilowatt_about_id->TooltipValue = "";

			// kilowatt_about_left_pic
			$this->kilowatt_about_left_pic->LinkCustomAttributes = "";
			$this->kilowatt_about_left_pic->UploadPath = '../src/assets/images/kilowatt';
			if (!ew_Empty($this->kilowatt_about_left_pic->Upload->DbValue)) {
				$this->kilowatt_about_left_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_about_left_pic, $this->kilowatt_about_left_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_about_left_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_about_left_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_about_left_pic->HrefValue);
			} else {
				$this->kilowatt_about_left_pic->HrefValue = "";
			}
			$this->kilowatt_about_left_pic->HrefValue2 = $this->kilowatt_about_left_pic->UploadPath . $this->kilowatt_about_left_pic->Upload->DbValue;
			$this->kilowatt_about_left_pic->TooltipValue = "";
			if ($this->kilowatt_about_left_pic->UseColorbox) {
				$this->kilowatt_about_left_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->kilowatt_about_left_pic->LinkAttrs["data-rel"] = "kilowatt_about_x_kilowatt_about_left_pic";

				//$this->kilowatt_about_left_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->kilowatt_about_left_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->kilowatt_about_left_pic->LinkAttrs["data-container"] = "body";

				$this->kilowatt_about_left_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// kilowatt_about_right_pic
			$this->kilowatt_about_right_pic->LinkCustomAttributes = "";
			$this->kilowatt_about_right_pic->UploadPath = '../src/assets/images/kilowatt';
			if (!ew_Empty($this->kilowatt_about_right_pic->Upload->DbValue)) {
				$this->kilowatt_about_right_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_about_right_pic, $this->kilowatt_about_right_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_about_right_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_about_right_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_about_right_pic->HrefValue);
			} else {
				$this->kilowatt_about_right_pic->HrefValue = "";
			}
			$this->kilowatt_about_right_pic->HrefValue2 = $this->kilowatt_about_right_pic->UploadPath . $this->kilowatt_about_right_pic->Upload->DbValue;
			$this->kilowatt_about_right_pic->TooltipValue = "";
			if ($this->kilowatt_about_right_pic->UseColorbox) {
				$this->kilowatt_about_right_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->kilowatt_about_right_pic->LinkAttrs["data-rel"] = "kilowatt_about_x_kilowatt_about_right_pic";

				//$this->kilowatt_about_right_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->kilowatt_about_right_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->kilowatt_about_right_pic->LinkAttrs["data-container"] = "body";

				$this->kilowatt_about_right_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// kilowatt_about_experience_years
			$this->kilowatt_about_experience_years->LinkCustomAttributes = "";
			$this->kilowatt_about_experience_years->HrefValue = "";
			$this->kilowatt_about_experience_years->TooltipValue = "";

			// kilowatt_about_icon_title
			$this->kilowatt_about_icon_title->LinkCustomAttributes = "";
			$this->kilowatt_about_icon_title->HrefValue = "";
			$this->kilowatt_about_icon_title->TooltipValue = "";

			// kilowatt_about_title
			$this->kilowatt_about_title->LinkCustomAttributes = "";
			$this->kilowatt_about_title->HrefValue = "";
			$this->kilowatt_about_title->TooltipValue = "";

			// kilowatt_about_snippet
			$this->kilowatt_about_snippet->LinkCustomAttributes = "";
			$this->kilowatt_about_snippet->HrefValue = "";
			$this->kilowatt_about_snippet->TooltipValue = "";

			// kilowatt_about_full_content
			$this->kilowatt_about_full_content->LinkCustomAttributes = "";
			$this->kilowatt_about_full_content->HrefValue = "";
			$this->kilowatt_about_full_content->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "kilowatt_aboutlist.php", "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($kilowatt_about_view)) $kilowatt_about_view = new ckilowatt_about_view();

// Page init
$kilowatt_about_view->Page_Init();

// Page main
$kilowatt_about_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$kilowatt_about_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fkilowatt_aboutview = new ew_Form("fkilowatt_aboutview", "view");

// Form_CustomValidate event
fkilowatt_aboutview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkilowatt_aboutview.ValidateRequired = true;
<?php } else { ?>
fkilowatt_aboutview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $kilowatt_about_view->ExportOptions->Render("body") ?>
<?php
	foreach ($kilowatt_about_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $kilowatt_about_view->ShowPageHeader(); ?>
<?php
$kilowatt_about_view->ShowMessage();
?>
<form name="fkilowatt_aboutview" id="fkilowatt_aboutview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($kilowatt_about_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $kilowatt_about_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="kilowatt_about">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($kilowatt_about->kilowatt_about_id->Visible) { // kilowatt_about_id ?>
	<tr id="r_kilowatt_about_id">
		<td><span id="elh_kilowatt_about_kilowatt_about_id"><?php echo $kilowatt_about->kilowatt_about_id->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_id"<?php echo $kilowatt_about->kilowatt_about_id->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_id">
<span<?php echo $kilowatt_about->kilowatt_about_id->ViewAttributes() ?>>
<?php echo $kilowatt_about->kilowatt_about_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_left_pic->Visible) { // kilowatt_about_left_pic ?>
	<tr id="r_kilowatt_about_left_pic">
		<td><span id="elh_kilowatt_about_kilowatt_about_left_pic"><?php echo $kilowatt_about->kilowatt_about_left_pic->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_left_pic"<?php echo $kilowatt_about->kilowatt_about_left_pic->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_left_pic">
<span>
<?php echo ew_GetFileViewTag($kilowatt_about->kilowatt_about_left_pic, $kilowatt_about->kilowatt_about_left_pic->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_right_pic->Visible) { // kilowatt_about_right_pic ?>
	<tr id="r_kilowatt_about_right_pic">
		<td><span id="elh_kilowatt_about_kilowatt_about_right_pic"><?php echo $kilowatt_about->kilowatt_about_right_pic->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_right_pic"<?php echo $kilowatt_about->kilowatt_about_right_pic->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_right_pic">
<span>
<?php echo ew_GetFileViewTag($kilowatt_about->kilowatt_about_right_pic, $kilowatt_about->kilowatt_about_right_pic->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_experience_years->Visible) { // kilowatt_about_experience_years ?>
	<tr id="r_kilowatt_about_experience_years">
		<td><span id="elh_kilowatt_about_kilowatt_about_experience_years"><?php echo $kilowatt_about->kilowatt_about_experience_years->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_experience_years"<?php echo $kilowatt_about->kilowatt_about_experience_years->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_experience_years">
<span<?php echo $kilowatt_about->kilowatt_about_experience_years->ViewAttributes() ?>>
<?php echo $kilowatt_about->kilowatt_about_experience_years->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_icon_title->Visible) { // kilowatt_about_icon_title ?>
	<tr id="r_kilowatt_about_icon_title">
		<td><span id="elh_kilowatt_about_kilowatt_about_icon_title"><?php echo $kilowatt_about->kilowatt_about_icon_title->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_icon_title"<?php echo $kilowatt_about->kilowatt_about_icon_title->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_icon_title">
<span<?php echo $kilowatt_about->kilowatt_about_icon_title->ViewAttributes() ?>>
<?php echo $kilowatt_about->kilowatt_about_icon_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_title->Visible) { // kilowatt_about_title ?>
	<tr id="r_kilowatt_about_title">
		<td><span id="elh_kilowatt_about_kilowatt_about_title"><?php echo $kilowatt_about->kilowatt_about_title->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_title"<?php echo $kilowatt_about->kilowatt_about_title->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_title">
<span<?php echo $kilowatt_about->kilowatt_about_title->ViewAttributes() ?>>
<?php echo $kilowatt_about->kilowatt_about_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_snippet->Visible) { // kilowatt_about_snippet ?>
	<tr id="r_kilowatt_about_snippet">
		<td><span id="elh_kilowatt_about_kilowatt_about_snippet"><?php echo $kilowatt_about->kilowatt_about_snippet->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_snippet"<?php echo $kilowatt_about->kilowatt_about_snippet->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_snippet">
<span<?php echo $kilowatt_about->kilowatt_about_snippet->ViewAttributes() ?>>
<?php echo $kilowatt_about->kilowatt_about_snippet->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($kilowatt_about->kilowatt_about_full_content->Visible) { // kilowatt_about_full_content ?>
	<tr id="r_kilowatt_about_full_content">
		<td><span id="elh_kilowatt_about_kilowatt_about_full_content"><?php echo $kilowatt_about->kilowatt_about_full_content->FldCaption() ?></span></td>
		<td data-name="kilowatt_about_full_content"<?php echo $kilowatt_about->kilowatt_about_full_content->CellAttributes() ?>>
<span id="el_kilowatt_about_kilowatt_about_full_content">
<span<?php echo $kilowatt_about->kilowatt_about_full_content->ViewAttributes() ?>>
<?php echo $kilowatt_about->kilowatt_about_full_content->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fkilowatt_aboutview.Init();
</script>
<?php
$kilowatt_about_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$kilowatt_about_view->Page_Terminate();
?>
