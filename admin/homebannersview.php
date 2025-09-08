<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "homebannersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$homebanners_view = NULL; // Initialize page object first

class chomebanners_view extends chomebanners {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'homebanners';

	// Page object name
	var $PageObjName = 'homebanners_view';

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

		// Table object (homebanners)
		if (!isset($GLOBALS["homebanners"]) || get_class($GLOBALS["homebanners"]) == "chomebanners") {
			$GLOBALS["homebanners"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["homebanners"];
		}
		$KeyUrl = "";
		if (@$_GET["homebanner_id"] <> "") {
			$this->RecKey["homebanner_id"] = $_GET["homebanner_id"];
			$KeyUrl .= "&amp;homebanner_id=" . urlencode($this->RecKey["homebanner_id"]);
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
			define("EW_TABLE_NAME", 'homebanners', TRUE);

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
		$this->homebanner_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $homebanners;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($homebanners);
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
			if (@$_GET["homebanner_id"] <> "") {
				$this->homebanner_id->setQueryStringValue($_GET["homebanner_id"]);
				$this->RecKey["homebanner_id"] = $this->homebanner_id->QueryStringValue;
			} elseif (@$_POST["homebanner_id"] <> "") {
				$this->homebanner_id->setFormValue($_POST["homebanner_id"]);
				$this->RecKey["homebanner_id"] = $this->homebanner_id->FormValue;
			} else {
				$sReturnUrl = "homebannerslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "homebannerslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "homebannerslist.php"; // Not page request, return to list
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

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->IsLoggedIn());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->IsLoggedIn());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->IsLoggedIn());

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
		$this->homebanner_id->setDbValue($rs->fields('homebanner_id'));
		$this->homebanner_subtitle->setDbValue($rs->fields('homebanner_subtitle'));
		$this->homebanner_maintitle->setDbValue($rs->fields('homebanner_maintitle'));
		$this->homebanner_pic->Upload->DbValue = $rs->fields('homebanner_pic');
		$this->homebanner_pic->CurrentValue = $this->homebanner_pic->Upload->DbValue;
		$this->homebanner_button_text->setDbValue($rs->fields('homebanner_button_text'));
		$this->homebanner_button_link->setDbValue($rs->fields('homebanner_button_link'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->homebanner_id->DbValue = $row['homebanner_id'];
		$this->homebanner_subtitle->DbValue = $row['homebanner_subtitle'];
		$this->homebanner_maintitle->DbValue = $row['homebanner_maintitle'];
		$this->homebanner_pic->Upload->DbValue = $row['homebanner_pic'];
		$this->homebanner_button_text->DbValue = $row['homebanner_button_text'];
		$this->homebanner_button_link->DbValue = $row['homebanner_button_link'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
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
		// homebanner_id
		// homebanner_subtitle
		// homebanner_maintitle
		// homebanner_pic
		// homebanner_button_text
		// homebanner_button_link
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// homebanner_id
		$this->homebanner_id->ViewValue = $this->homebanner_id->CurrentValue;
		$this->homebanner_id->ViewCustomAttributes = "";

		// homebanner_subtitle
		$this->homebanner_subtitle->ViewValue = $this->homebanner_subtitle->CurrentValue;
		$this->homebanner_subtitle->ViewCustomAttributes = "";

		// homebanner_maintitle
		$this->homebanner_maintitle->ViewValue = $this->homebanner_maintitle->CurrentValue;
		$this->homebanner_maintitle->ViewCustomAttributes = "";

		// homebanner_pic
		$this->homebanner_pic->UploadPath = '../src/assets/images/resource/homebanners';
		if (!ew_Empty($this->homebanner_pic->Upload->DbValue)) {
			$this->homebanner_pic->ImageWidth = 120;
			$this->homebanner_pic->ImageHeight = 65;
			$this->homebanner_pic->ImageAlt = $this->homebanner_pic->FldAlt();
			$this->homebanner_pic->ViewValue = $this->homebanner_pic->Upload->DbValue;
		} else {
			$this->homebanner_pic->ViewValue = "";
		}
		$this->homebanner_pic->ViewCustomAttributes = "";

		// homebanner_button_text
		$this->homebanner_button_text->ViewValue = $this->homebanner_button_text->CurrentValue;
		$this->homebanner_button_text->ViewCustomAttributes = "";

		// homebanner_button_link
		$this->homebanner_button_link->ViewValue = $this->homebanner_button_link->CurrentValue;
		$this->homebanner_button_link->ViewCustomAttributes = "";

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

			// homebanner_id
			$this->homebanner_id->LinkCustomAttributes = "";
			$this->homebanner_id->HrefValue = "";
			$this->homebanner_id->TooltipValue = "";

			// homebanner_subtitle
			$this->homebanner_subtitle->LinkCustomAttributes = "";
			$this->homebanner_subtitle->HrefValue = "";
			$this->homebanner_subtitle->TooltipValue = "";

			// homebanner_maintitle
			$this->homebanner_maintitle->LinkCustomAttributes = "";
			$this->homebanner_maintitle->HrefValue = "";
			$this->homebanner_maintitle->TooltipValue = "";

			// homebanner_pic
			$this->homebanner_pic->LinkCustomAttributes = "";
			$this->homebanner_pic->UploadPath = '../src/assets/images/resource/homebanners';
			if (!ew_Empty($this->homebanner_pic->Upload->DbValue)) {
				$this->homebanner_pic->HrefValue = ew_GetFileUploadUrl($this->homebanner_pic, $this->homebanner_pic->Upload->DbValue); // Add prefix/suffix
				$this->homebanner_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->homebanner_pic->HrefValue = ew_ConvertFullUrl($this->homebanner_pic->HrefValue);
			} else {
				$this->homebanner_pic->HrefValue = "";
			}
			$this->homebanner_pic->HrefValue2 = $this->homebanner_pic->UploadPath . $this->homebanner_pic->Upload->DbValue;
			$this->homebanner_pic->TooltipValue = "";
			if ($this->homebanner_pic->UseColorbox) {
				$this->homebanner_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->homebanner_pic->LinkAttrs["data-rel"] = "homebanners_x_homebanner_pic";

				//$this->homebanner_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->homebanner_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->homebanner_pic->LinkAttrs["data-container"] = "body";

				$this->homebanner_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// homebanner_button_text
			$this->homebanner_button_text->LinkCustomAttributes = "";
			$this->homebanner_button_text->HrefValue = "";
			$this->homebanner_button_text->TooltipValue = "";

			// homebanner_button_link
			$this->homebanner_button_link->LinkCustomAttributes = "";
			$this->homebanner_button_link->HrefValue = "";
			$this->homebanner_button_link->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, "homebannerslist.php", "", $this->TableVar, TRUE);
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
if (!isset($homebanners_view)) $homebanners_view = new chomebanners_view();

// Page init
$homebanners_view->Page_Init();

// Page main
$homebanners_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$homebanners_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fhomebannersview = new ew_Form("fhomebannersview", "view");

// Form_CustomValidate event
fhomebannersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhomebannersview.ValidateRequired = true;
<?php } else { ?>
fhomebannersview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhomebannersview.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhomebannersview.Lists["x_status"].Options = <?php echo json_encode($homebanners->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $homebanners_view->ExportOptions->Render("body") ?>
<?php
	foreach ($homebanners_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $homebanners_view->ShowPageHeader(); ?>
<?php
$homebanners_view->ShowMessage();
?>
<form name="fhomebannersview" id="fhomebannersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($homebanners_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $homebanners_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="homebanners">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($homebanners->homebanner_id->Visible) { // homebanner_id ?>
	<tr id="r_homebanner_id">
		<td><span id="elh_homebanners_homebanner_id"><?php echo $homebanners->homebanner_id->FldCaption() ?></span></td>
		<td data-name="homebanner_id"<?php echo $homebanners->homebanner_id->CellAttributes() ?>>
<span id="el_homebanners_homebanner_id">
<span<?php echo $homebanners->homebanner_id->ViewAttributes() ?>>
<?php echo $homebanners->homebanner_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->homebanner_subtitle->Visible) { // homebanner_subtitle ?>
	<tr id="r_homebanner_subtitle">
		<td><span id="elh_homebanners_homebanner_subtitle"><?php echo $homebanners->homebanner_subtitle->FldCaption() ?></span></td>
		<td data-name="homebanner_subtitle"<?php echo $homebanners->homebanner_subtitle->CellAttributes() ?>>
<span id="el_homebanners_homebanner_subtitle">
<span<?php echo $homebanners->homebanner_subtitle->ViewAttributes() ?>>
<?php echo $homebanners->homebanner_subtitle->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->homebanner_maintitle->Visible) { // homebanner_maintitle ?>
	<tr id="r_homebanner_maintitle">
		<td><span id="elh_homebanners_homebanner_maintitle"><?php echo $homebanners->homebanner_maintitle->FldCaption() ?></span></td>
		<td data-name="homebanner_maintitle"<?php echo $homebanners->homebanner_maintitle->CellAttributes() ?>>
<span id="el_homebanners_homebanner_maintitle">
<span<?php echo $homebanners->homebanner_maintitle->ViewAttributes() ?>>
<?php echo $homebanners->homebanner_maintitle->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->homebanner_pic->Visible) { // homebanner_pic ?>
	<tr id="r_homebanner_pic">
		<td><span id="elh_homebanners_homebanner_pic"><?php echo $homebanners->homebanner_pic->FldCaption() ?></span></td>
		<td data-name="homebanner_pic"<?php echo $homebanners->homebanner_pic->CellAttributes() ?>>
<span id="el_homebanners_homebanner_pic">
<span>
<?php echo ew_GetFileViewTag($homebanners->homebanner_pic, $homebanners->homebanner_pic->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->homebanner_button_text->Visible) { // homebanner_button_text ?>
	<tr id="r_homebanner_button_text">
		<td><span id="elh_homebanners_homebanner_button_text"><?php echo $homebanners->homebanner_button_text->FldCaption() ?></span></td>
		<td data-name="homebanner_button_text"<?php echo $homebanners->homebanner_button_text->CellAttributes() ?>>
<span id="el_homebanners_homebanner_button_text">
<span<?php echo $homebanners->homebanner_button_text->ViewAttributes() ?>>
<?php echo $homebanners->homebanner_button_text->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->homebanner_button_link->Visible) { // homebanner_button_link ?>
	<tr id="r_homebanner_button_link">
		<td><span id="elh_homebanners_homebanner_button_link"><?php echo $homebanners->homebanner_button_link->FldCaption() ?></span></td>
		<td data-name="homebanner_button_link"<?php echo $homebanners->homebanner_button_link->CellAttributes() ?>>
<span id="el_homebanners_homebanner_button_link">
<span<?php echo $homebanners->homebanner_button_link->ViewAttributes() ?>>
<?php echo $homebanners->homebanner_button_link->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->sort_order->Visible) { // sort_order ?>
	<tr id="r_sort_order">
		<td><span id="elh_homebanners_sort_order"><?php echo $homebanners->sort_order->FldCaption() ?></span></td>
		<td data-name="sort_order"<?php echo $homebanners->sort_order->CellAttributes() ?>>
<span id="el_homebanners_sort_order">
<span<?php echo $homebanners->sort_order->ViewAttributes() ?>>
<?php echo $homebanners->sort_order->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($homebanners->status->Visible) { // status ?>
	<tr id="r_status">
		<td><span id="elh_homebanners_status"><?php echo $homebanners->status->FldCaption() ?></span></td>
		<td data-name="status"<?php echo $homebanners->status->CellAttributes() ?>>
<span id="el_homebanners_status">
<span<?php echo $homebanners->status->ViewAttributes() ?>>
<?php echo $homebanners->status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fhomebannersview.Init();
</script>
<?php
$homebanners_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$homebanners_view->Page_Terminate();
?>
