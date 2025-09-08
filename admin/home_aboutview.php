<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "home_aboutinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$home_about_view = NULL; // Initialize page object first

class chome_about_view extends chome_about {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'home_about';

	// Page object name
	var $PageObjName = 'home_about_view';

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

		// Table object (home_about)
		if (!isset($GLOBALS["home_about"]) || get_class($GLOBALS["home_about"]) == "chome_about") {
			$GLOBALS["home_about"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["home_about"];
		}
		$KeyUrl = "";
		if (@$_GET["home_about_id"] <> "") {
			$this->RecKey["home_about_id"] = $_GET["home_about_id"];
			$KeyUrl .= "&amp;home_about_id=" . urlencode($this->RecKey["home_about_id"]);
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
			define("EW_TABLE_NAME", 'home_about', TRUE);

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
		$this->home_about_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $home_about;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($home_about);
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
			if (@$_GET["home_about_id"] <> "") {
				$this->home_about_id->setQueryStringValue($_GET["home_about_id"]);
				$this->RecKey["home_about_id"] = $this->home_about_id->QueryStringValue;
			} elseif (@$_POST["home_about_id"] <> "") {
				$this->home_about_id->setFormValue($_POST["home_about_id"]);
				$this->RecKey["home_about_id"] = $this->home_about_id->FormValue;
			} else {
				$sReturnUrl = "home_aboutlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "home_aboutlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "home_aboutlist.php"; // Not page request, return to list
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
		$this->home_about_id->setDbValue($rs->fields('home_about_id'));
		$this->home_about_pic->Upload->DbValue = $rs->fields('home_about_pic');
		$this->home_about_pic->CurrentValue = $this->home_about_pic->Upload->DbValue;
		$this->home_about_icon_title->setDbValue($rs->fields('home_about_icon_title'));
		$this->home_about_title->setDbValue($rs->fields('home_about_title'));
		$this->home_about_subtitle->setDbValue($rs->fields('home_about_subtitle'));
		$this->home_about_content->setDbValue($rs->fields('home_about_content'));
		$this->home_about_block1_title->setDbValue($rs->fields('home_about_block1_title'));
		$this->home_about_block1_content->setDbValue($rs->fields('home_about_block1_content'));
		$this->home_about_block2_title->setDbValue($rs->fields('home_about_block2_title'));
		$this->home_about_block2_content->setDbValue($rs->fields('home_about_block2_content'));
		$this->home_about_board_director_id->setDbValue($rs->fields('home_about_board_director_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->home_about_id->DbValue = $row['home_about_id'];
		$this->home_about_pic->Upload->DbValue = $row['home_about_pic'];
		$this->home_about_icon_title->DbValue = $row['home_about_icon_title'];
		$this->home_about_title->DbValue = $row['home_about_title'];
		$this->home_about_subtitle->DbValue = $row['home_about_subtitle'];
		$this->home_about_content->DbValue = $row['home_about_content'];
		$this->home_about_block1_title->DbValue = $row['home_about_block1_title'];
		$this->home_about_block1_content->DbValue = $row['home_about_block1_content'];
		$this->home_about_block2_title->DbValue = $row['home_about_block2_title'];
		$this->home_about_block2_content->DbValue = $row['home_about_block2_content'];
		$this->home_about_board_director_id->DbValue = $row['home_about_board_director_id'];
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
		// home_about_id
		// home_about_pic
		// home_about_icon_title
		// home_about_title
		// home_about_subtitle
		// home_about_content
		// home_about_block1_title
		// home_about_block1_content
		// home_about_block2_title
		// home_about_block2_content
		// home_about_board_director_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// home_about_id
		$this->home_about_id->ViewValue = $this->home_about_id->CurrentValue;
		$this->home_about_id->ViewCustomAttributes = "";

		// home_about_pic
		$this->home_about_pic->UploadPath = '../src/assets/images/resource';
		if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
			$this->home_about_pic->ImageWidth = 105;
			$this->home_about_pic->ImageHeight = 120;
			$this->home_about_pic->ImageAlt = $this->home_about_pic->FldAlt();
			$this->home_about_pic->ViewValue = $this->home_about_pic->Upload->DbValue;
		} else {
			$this->home_about_pic->ViewValue = "";
		}
		$this->home_about_pic->ViewCustomAttributes = "";

		// home_about_icon_title
		$this->home_about_icon_title->ViewValue = $this->home_about_icon_title->CurrentValue;
		$this->home_about_icon_title->ViewCustomAttributes = "";

		// home_about_title
		$this->home_about_title->ViewValue = $this->home_about_title->CurrentValue;
		$this->home_about_title->ViewCustomAttributes = "";

		// home_about_subtitle
		$this->home_about_subtitle->ViewValue = $this->home_about_subtitle->CurrentValue;
		$this->home_about_subtitle->ViewCustomAttributes = "";

		// home_about_content
		$this->home_about_content->ViewValue = $this->home_about_content->CurrentValue;
		$this->home_about_content->ViewCustomAttributes = "";

		// home_about_block1_title
		$this->home_about_block1_title->ViewValue = $this->home_about_block1_title->CurrentValue;
		$this->home_about_block1_title->ViewCustomAttributes = "";

		// home_about_block1_content
		$this->home_about_block1_content->ViewValue = $this->home_about_block1_content->CurrentValue;
		$this->home_about_block1_content->ViewCustomAttributes = "";

		// home_about_block2_title
		$this->home_about_block2_title->ViewValue = $this->home_about_block2_title->CurrentValue;
		$this->home_about_block2_title->ViewCustomAttributes = "";

		// home_about_block2_content
		$this->home_about_block2_content->ViewValue = $this->home_about_block2_content->CurrentValue;
		$this->home_about_block2_content->ViewCustomAttributes = "";

		// home_about_board_director_id
		$this->home_about_board_director_id->ViewValue = $this->home_about_board_director_id->CurrentValue;
		$this->home_about_board_director_id->ViewCustomAttributes = "";

			// home_about_id
			$this->home_about_id->LinkCustomAttributes = "";
			$this->home_about_id->HrefValue = "";
			$this->home_about_id->TooltipValue = "";

			// home_about_pic
			$this->home_about_pic->LinkCustomAttributes = "";
			$this->home_about_pic->UploadPath = '../src/assets/images/resource';
			if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
				$this->home_about_pic->HrefValue = ew_GetFileUploadUrl($this->home_about_pic, $this->home_about_pic->Upload->DbValue); // Add prefix/suffix
				$this->home_about_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->home_about_pic->HrefValue = ew_ConvertFullUrl($this->home_about_pic->HrefValue);
			} else {
				$this->home_about_pic->HrefValue = "";
			}
			$this->home_about_pic->HrefValue2 = $this->home_about_pic->UploadPath . $this->home_about_pic->Upload->DbValue;
			$this->home_about_pic->TooltipValue = "";
			if ($this->home_about_pic->UseColorbox) {
				$this->home_about_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->home_about_pic->LinkAttrs["data-rel"] = "home_about_x_home_about_pic";

				//$this->home_about_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->home_about_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->home_about_pic->LinkAttrs["data-container"] = "body";

				$this->home_about_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// home_about_icon_title
			$this->home_about_icon_title->LinkCustomAttributes = "";
			$this->home_about_icon_title->HrefValue = "";
			$this->home_about_icon_title->TooltipValue = "";

			// home_about_title
			$this->home_about_title->LinkCustomAttributes = "";
			$this->home_about_title->HrefValue = "";
			$this->home_about_title->TooltipValue = "";

			// home_about_subtitle
			$this->home_about_subtitle->LinkCustomAttributes = "";
			$this->home_about_subtitle->HrefValue = "";
			$this->home_about_subtitle->TooltipValue = "";

			// home_about_content
			$this->home_about_content->LinkCustomAttributes = "";
			$this->home_about_content->HrefValue = "";
			$this->home_about_content->TooltipValue = "";

			// home_about_block1_title
			$this->home_about_block1_title->LinkCustomAttributes = "";
			$this->home_about_block1_title->HrefValue = "";
			$this->home_about_block1_title->TooltipValue = "";

			// home_about_block1_content
			$this->home_about_block1_content->LinkCustomAttributes = "";
			$this->home_about_block1_content->HrefValue = "";
			$this->home_about_block1_content->TooltipValue = "";

			// home_about_block2_title
			$this->home_about_block2_title->LinkCustomAttributes = "";
			$this->home_about_block2_title->HrefValue = "";
			$this->home_about_block2_title->TooltipValue = "";

			// home_about_block2_content
			$this->home_about_block2_content->LinkCustomAttributes = "";
			$this->home_about_block2_content->HrefValue = "";
			$this->home_about_block2_content->TooltipValue = "";

			// home_about_board_director_id
			$this->home_about_board_director_id->LinkCustomAttributes = "";
			$this->home_about_board_director_id->HrefValue = "";
			$this->home_about_board_director_id->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, "home_aboutlist.php", "", $this->TableVar, TRUE);
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
if (!isset($home_about_view)) $home_about_view = new chome_about_view();

// Page init
$home_about_view->Page_Init();

// Page main
$home_about_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$home_about_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fhome_aboutview = new ew_Form("fhome_aboutview", "view");

// Form_CustomValidate event
fhome_aboutview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhome_aboutview.ValidateRequired = true;
<?php } else { ?>
fhome_aboutview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $home_about_view->ExportOptions->Render("body") ?>
<?php
	foreach ($home_about_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $home_about_view->ShowPageHeader(); ?>
<?php
$home_about_view->ShowMessage();
?>
<form name="fhome_aboutview" id="fhome_aboutview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($home_about_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $home_about_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="home_about">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($home_about->home_about_id->Visible) { // home_about_id ?>
	<tr id="r_home_about_id">
		<td><span id="elh_home_about_home_about_id"><?php echo $home_about->home_about_id->FldCaption() ?></span></td>
		<td data-name="home_about_id"<?php echo $home_about->home_about_id->CellAttributes() ?>>
<span id="el_home_about_home_about_id">
<span<?php echo $home_about->home_about_id->ViewAttributes() ?>>
<?php echo $home_about->home_about_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_pic->Visible) { // home_about_pic ?>
	<tr id="r_home_about_pic">
		<td><span id="elh_home_about_home_about_pic"><?php echo $home_about->home_about_pic->FldCaption() ?></span></td>
		<td data-name="home_about_pic"<?php echo $home_about->home_about_pic->CellAttributes() ?>>
<span id="el_home_about_home_about_pic">
<span>
<?php echo ew_GetFileViewTag($home_about->home_about_pic, $home_about->home_about_pic->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_icon_title->Visible) { // home_about_icon_title ?>
	<tr id="r_home_about_icon_title">
		<td><span id="elh_home_about_home_about_icon_title"><?php echo $home_about->home_about_icon_title->FldCaption() ?></span></td>
		<td data-name="home_about_icon_title"<?php echo $home_about->home_about_icon_title->CellAttributes() ?>>
<span id="el_home_about_home_about_icon_title">
<span<?php echo $home_about->home_about_icon_title->ViewAttributes() ?>>
<?php echo $home_about->home_about_icon_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_title->Visible) { // home_about_title ?>
	<tr id="r_home_about_title">
		<td><span id="elh_home_about_home_about_title"><?php echo $home_about->home_about_title->FldCaption() ?></span></td>
		<td data-name="home_about_title"<?php echo $home_about->home_about_title->CellAttributes() ?>>
<span id="el_home_about_home_about_title">
<span<?php echo $home_about->home_about_title->ViewAttributes() ?>>
<?php echo $home_about->home_about_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_subtitle->Visible) { // home_about_subtitle ?>
	<tr id="r_home_about_subtitle">
		<td><span id="elh_home_about_home_about_subtitle"><?php echo $home_about->home_about_subtitle->FldCaption() ?></span></td>
		<td data-name="home_about_subtitle"<?php echo $home_about->home_about_subtitle->CellAttributes() ?>>
<span id="el_home_about_home_about_subtitle">
<span<?php echo $home_about->home_about_subtitle->ViewAttributes() ?>>
<?php echo $home_about->home_about_subtitle->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_content->Visible) { // home_about_content ?>
	<tr id="r_home_about_content">
		<td><span id="elh_home_about_home_about_content"><?php echo $home_about->home_about_content->FldCaption() ?></span></td>
		<td data-name="home_about_content"<?php echo $home_about->home_about_content->CellAttributes() ?>>
<span id="el_home_about_home_about_content">
<span<?php echo $home_about->home_about_content->ViewAttributes() ?>>
<?php echo $home_about->home_about_content->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_block1_title->Visible) { // home_about_block1_title ?>
	<tr id="r_home_about_block1_title">
		<td><span id="elh_home_about_home_about_block1_title"><?php echo $home_about->home_about_block1_title->FldCaption() ?></span></td>
		<td data-name="home_about_block1_title"<?php echo $home_about->home_about_block1_title->CellAttributes() ?>>
<span id="el_home_about_home_about_block1_title">
<span<?php echo $home_about->home_about_block1_title->ViewAttributes() ?>>
<?php echo $home_about->home_about_block1_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_block1_content->Visible) { // home_about_block1_content ?>
	<tr id="r_home_about_block1_content">
		<td><span id="elh_home_about_home_about_block1_content"><?php echo $home_about->home_about_block1_content->FldCaption() ?></span></td>
		<td data-name="home_about_block1_content"<?php echo $home_about->home_about_block1_content->CellAttributes() ?>>
<span id="el_home_about_home_about_block1_content">
<span<?php echo $home_about->home_about_block1_content->ViewAttributes() ?>>
<?php echo $home_about->home_about_block1_content->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_block2_title->Visible) { // home_about_block2_title ?>
	<tr id="r_home_about_block2_title">
		<td><span id="elh_home_about_home_about_block2_title"><?php echo $home_about->home_about_block2_title->FldCaption() ?></span></td>
		<td data-name="home_about_block2_title"<?php echo $home_about->home_about_block2_title->CellAttributes() ?>>
<span id="el_home_about_home_about_block2_title">
<span<?php echo $home_about->home_about_block2_title->ViewAttributes() ?>>
<?php echo $home_about->home_about_block2_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_block2_content->Visible) { // home_about_block2_content ?>
	<tr id="r_home_about_block2_content">
		<td><span id="elh_home_about_home_about_block2_content"><?php echo $home_about->home_about_block2_content->FldCaption() ?></span></td>
		<td data-name="home_about_block2_content"<?php echo $home_about->home_about_block2_content->CellAttributes() ?>>
<span id="el_home_about_home_about_block2_content">
<span<?php echo $home_about->home_about_block2_content->ViewAttributes() ?>>
<?php echo $home_about->home_about_block2_content->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($home_about->home_about_board_director_id->Visible) { // home_about_board_director_id ?>
	<tr id="r_home_about_board_director_id">
		<td><span id="elh_home_about_home_about_board_director_id"><?php echo $home_about->home_about_board_director_id->FldCaption() ?></span></td>
		<td data-name="home_about_board_director_id"<?php echo $home_about->home_about_board_director_id->CellAttributes() ?>>
<span id="el_home_about_home_about_board_director_id">
<span<?php echo $home_about->home_about_board_director_id->ViewAttributes() ?>>
<?php echo $home_about->home_about_board_director_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fhome_aboutview.Init();
</script>
<?php
$home_about_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$home_about_view->Page_Terminate();
?>
