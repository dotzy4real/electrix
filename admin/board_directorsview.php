<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "board_directorsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$board_directors_view = NULL; // Initialize page object first

class cboard_directors_view extends cboard_directors {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'board_directors';

	// Page object name
	var $PageObjName = 'board_directors_view';

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

		// Table object (board_directors)
		if (!isset($GLOBALS["board_directors"]) || get_class($GLOBALS["board_directors"]) == "cboard_directors") {
			$GLOBALS["board_directors"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["board_directors"];
		}
		$KeyUrl = "";
		if (@$_GET["board_director_id"] <> "") {
			$this->RecKey["board_director_id"] = $_GET["board_director_id"];
			$KeyUrl .= "&amp;board_director_id=" . urlencode($this->RecKey["board_director_id"]);
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
			define("EW_TABLE_NAME", 'board_directors', TRUE);

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
		$this->board_director_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $board_directors;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($board_directors);
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
			if (@$_GET["board_director_id"] <> "") {
				$this->board_director_id->setQueryStringValue($_GET["board_director_id"]);
				$this->RecKey["board_director_id"] = $this->board_director_id->QueryStringValue;
			} elseif (@$_POST["board_director_id"] <> "") {
				$this->board_director_id->setFormValue($_POST["board_director_id"]);
				$this->RecKey["board_director_id"] = $this->board_director_id->FormValue;
			} else {
				$sReturnUrl = "board_directorslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "board_directorslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "board_directorslist.php"; // Not page request, return to list
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
		$this->board_director_id->setDbValue($rs->fields('board_director_id'));
		$this->board_director_pic->Upload->DbValue = $rs->fields('board_director_pic');
		$this->board_director_pic->CurrentValue = $this->board_director_pic->Upload->DbValue;
		$this->board_director_name->setDbValue($rs->fields('board_director_name'));
		$this->board_director_designation->setDbValue($rs->fields('board_director_designation'));
		$this->board_director_content->setDbValue($rs->fields('board_director_content'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
		$this->board_director_linkedin->setDbValue($rs->fields('board_director_linkedin'));
		$this->board_director_facebook->setDbValue($rs->fields('board_director_facebook'));
		$this->board_director_twitter->setDbValue($rs->fields('board_director_twitter'));
		$this->board_director_email->setDbValue($rs->fields('board_director_email'));
		$this->board_director_phone->setDbValue($rs->fields('board_director_phone'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->board_director_id->DbValue = $row['board_director_id'];
		$this->board_director_pic->Upload->DbValue = $row['board_director_pic'];
		$this->board_director_name->DbValue = $row['board_director_name'];
		$this->board_director_designation->DbValue = $row['board_director_designation'];
		$this->board_director_content->DbValue = $row['board_director_content'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
		$this->board_director_linkedin->DbValue = $row['board_director_linkedin'];
		$this->board_director_facebook->DbValue = $row['board_director_facebook'];
		$this->board_director_twitter->DbValue = $row['board_director_twitter'];
		$this->board_director_email->DbValue = $row['board_director_email'];
		$this->board_director_phone->DbValue = $row['board_director_phone'];
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
		// board_director_id
		// board_director_pic
		// board_director_name
		// board_director_designation
		// board_director_content
		// sort_order
		// status
		// board_director_linkedin
		// board_director_facebook
		// board_director_twitter
		// board_director_email
		// board_director_phone

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// board_director_id
		$this->board_director_id->ViewValue = $this->board_director_id->CurrentValue;
		$this->board_director_id->ViewCustomAttributes = "";

		// board_director_pic
		$this->board_director_pic->UploadPath = '../src/assets/images/resource/board_members';
		if (!ew_Empty($this->board_director_pic->Upload->DbValue)) {
			$this->board_director_pic->ImageWidth = 105;
			$this->board_director_pic->ImageHeight = 120;
			$this->board_director_pic->ImageAlt = $this->board_director_pic->FldAlt();
			$this->board_director_pic->ViewValue = $this->board_director_pic->Upload->DbValue;
		} else {
			$this->board_director_pic->ViewValue = "";
		}
		$this->board_director_pic->ViewCustomAttributes = "";

		// board_director_name
		$this->board_director_name->ViewValue = $this->board_director_name->CurrentValue;
		$this->board_director_name->ViewCustomAttributes = "";

		// board_director_designation
		$this->board_director_designation->ViewValue = $this->board_director_designation->CurrentValue;
		$this->board_director_designation->ViewCustomAttributes = "";

		// board_director_content
		$this->board_director_content->ViewValue = $this->board_director_content->CurrentValue;
		$this->board_director_content->ViewCustomAttributes = "";

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

		// board_director_linkedin
		$this->board_director_linkedin->ViewValue = $this->board_director_linkedin->CurrentValue;
		$this->board_director_linkedin->ViewCustomAttributes = "";

		// board_director_facebook
		$this->board_director_facebook->ViewValue = $this->board_director_facebook->CurrentValue;
		$this->board_director_facebook->ViewCustomAttributes = "";

		// board_director_twitter
		$this->board_director_twitter->ViewValue = $this->board_director_twitter->CurrentValue;
		$this->board_director_twitter->ViewCustomAttributes = "";

		// board_director_email
		$this->board_director_email->ViewValue = $this->board_director_email->CurrentValue;
		$this->board_director_email->ViewCustomAttributes = "";

		// board_director_phone
		$this->board_director_phone->ViewValue = $this->board_director_phone->CurrentValue;
		$this->board_director_phone->ViewCustomAttributes = "";

			// board_director_id
			$this->board_director_id->LinkCustomAttributes = "";
			$this->board_director_id->HrefValue = "";
			$this->board_director_id->TooltipValue = "";

			// board_director_pic
			$this->board_director_pic->LinkCustomAttributes = "";
			$this->board_director_pic->UploadPath = '../src/assets/images/resource/board_members';
			if (!ew_Empty($this->board_director_pic->Upload->DbValue)) {
				$this->board_director_pic->HrefValue = ew_GetFileUploadUrl($this->board_director_pic, $this->board_director_pic->Upload->DbValue); // Add prefix/suffix
				$this->board_director_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->board_director_pic->HrefValue = ew_ConvertFullUrl($this->board_director_pic->HrefValue);
			} else {
				$this->board_director_pic->HrefValue = "";
			}
			$this->board_director_pic->HrefValue2 = $this->board_director_pic->UploadPath . $this->board_director_pic->Upload->DbValue;
			$this->board_director_pic->TooltipValue = "";
			if ($this->board_director_pic->UseColorbox) {
				$this->board_director_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->board_director_pic->LinkAttrs["data-rel"] = "board_directors_x_board_director_pic";

				//$this->board_director_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->board_director_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->board_director_pic->LinkAttrs["data-container"] = "body";

				$this->board_director_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// board_director_name
			$this->board_director_name->LinkCustomAttributes = "";
			$this->board_director_name->HrefValue = "";
			$this->board_director_name->TooltipValue = "";

			// board_director_designation
			$this->board_director_designation->LinkCustomAttributes = "";
			$this->board_director_designation->HrefValue = "";
			$this->board_director_designation->TooltipValue = "";

			// board_director_content
			$this->board_director_content->LinkCustomAttributes = "";
			$this->board_director_content->HrefValue = "";
			$this->board_director_content->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// board_director_linkedin
			$this->board_director_linkedin->LinkCustomAttributes = "";
			$this->board_director_linkedin->HrefValue = "";
			$this->board_director_linkedin->TooltipValue = "";

			// board_director_facebook
			$this->board_director_facebook->LinkCustomAttributes = "";
			$this->board_director_facebook->HrefValue = "";
			$this->board_director_facebook->TooltipValue = "";

			// board_director_twitter
			$this->board_director_twitter->LinkCustomAttributes = "";
			$this->board_director_twitter->HrefValue = "";
			$this->board_director_twitter->TooltipValue = "";

			// board_director_email
			$this->board_director_email->LinkCustomAttributes = "";
			$this->board_director_email->HrefValue = "";
			$this->board_director_email->TooltipValue = "";

			// board_director_phone
			$this->board_director_phone->LinkCustomAttributes = "";
			$this->board_director_phone->HrefValue = "";
			$this->board_director_phone->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, "board_directorslist.php", "", $this->TableVar, TRUE);
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
if (!isset($board_directors_view)) $board_directors_view = new cboard_directors_view();

// Page init
$board_directors_view->Page_Init();

// Page main
$board_directors_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$board_directors_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fboard_directorsview = new ew_Form("fboard_directorsview", "view");

// Form_CustomValidate event
fboard_directorsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fboard_directorsview.ValidateRequired = true;
<?php } else { ?>
fboard_directorsview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fboard_directorsview.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fboard_directorsview.Lists["x_status"].Options = <?php echo json_encode($board_directors->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $board_directors_view->ExportOptions->Render("body") ?>
<?php
	foreach ($board_directors_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $board_directors_view->ShowPageHeader(); ?>
<?php
$board_directors_view->ShowMessage();
?>
<form name="fboard_directorsview" id="fboard_directorsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($board_directors_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $board_directors_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="board_directors">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($board_directors->board_director_id->Visible) { // board_director_id ?>
	<tr id="r_board_director_id">
		<td><span id="elh_board_directors_board_director_id"><?php echo $board_directors->board_director_id->FldCaption() ?></span></td>
		<td data-name="board_director_id"<?php echo $board_directors->board_director_id->CellAttributes() ?>>
<span id="el_board_directors_board_director_id">
<span<?php echo $board_directors->board_director_id->ViewAttributes() ?>>
<?php echo $board_directors->board_director_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_pic->Visible) { // board_director_pic ?>
	<tr id="r_board_director_pic">
		<td><span id="elh_board_directors_board_director_pic"><?php echo $board_directors->board_director_pic->FldCaption() ?></span></td>
		<td data-name="board_director_pic"<?php echo $board_directors->board_director_pic->CellAttributes() ?>>
<span id="el_board_directors_board_director_pic">
<span>
<?php echo ew_GetFileViewTag($board_directors->board_director_pic, $board_directors->board_director_pic->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_name->Visible) { // board_director_name ?>
	<tr id="r_board_director_name">
		<td><span id="elh_board_directors_board_director_name"><?php echo $board_directors->board_director_name->FldCaption() ?></span></td>
		<td data-name="board_director_name"<?php echo $board_directors->board_director_name->CellAttributes() ?>>
<span id="el_board_directors_board_director_name">
<span<?php echo $board_directors->board_director_name->ViewAttributes() ?>>
<?php echo $board_directors->board_director_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_designation->Visible) { // board_director_designation ?>
	<tr id="r_board_director_designation">
		<td><span id="elh_board_directors_board_director_designation"><?php echo $board_directors->board_director_designation->FldCaption() ?></span></td>
		<td data-name="board_director_designation"<?php echo $board_directors->board_director_designation->CellAttributes() ?>>
<span id="el_board_directors_board_director_designation">
<span<?php echo $board_directors->board_director_designation->ViewAttributes() ?>>
<?php echo $board_directors->board_director_designation->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_content->Visible) { // board_director_content ?>
	<tr id="r_board_director_content">
		<td><span id="elh_board_directors_board_director_content"><?php echo $board_directors->board_director_content->FldCaption() ?></span></td>
		<td data-name="board_director_content"<?php echo $board_directors->board_director_content->CellAttributes() ?>>
<span id="el_board_directors_board_director_content">
<span<?php echo $board_directors->board_director_content->ViewAttributes() ?>>
<?php echo $board_directors->board_director_content->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->sort_order->Visible) { // sort_order ?>
	<tr id="r_sort_order">
		<td><span id="elh_board_directors_sort_order"><?php echo $board_directors->sort_order->FldCaption() ?></span></td>
		<td data-name="sort_order"<?php echo $board_directors->sort_order->CellAttributes() ?>>
<span id="el_board_directors_sort_order">
<span<?php echo $board_directors->sort_order->ViewAttributes() ?>>
<?php echo $board_directors->sort_order->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->status->Visible) { // status ?>
	<tr id="r_status">
		<td><span id="elh_board_directors_status"><?php echo $board_directors->status->FldCaption() ?></span></td>
		<td data-name="status"<?php echo $board_directors->status->CellAttributes() ?>>
<span id="el_board_directors_status">
<span<?php echo $board_directors->status->ViewAttributes() ?>>
<?php echo $board_directors->status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_linkedin->Visible) { // board_director_linkedin ?>
	<tr id="r_board_director_linkedin">
		<td><span id="elh_board_directors_board_director_linkedin"><?php echo $board_directors->board_director_linkedin->FldCaption() ?></span></td>
		<td data-name="board_director_linkedin"<?php echo $board_directors->board_director_linkedin->CellAttributes() ?>>
<span id="el_board_directors_board_director_linkedin">
<span<?php echo $board_directors->board_director_linkedin->ViewAttributes() ?>>
<?php echo $board_directors->board_director_linkedin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_facebook->Visible) { // board_director_facebook ?>
	<tr id="r_board_director_facebook">
		<td><span id="elh_board_directors_board_director_facebook"><?php echo $board_directors->board_director_facebook->FldCaption() ?></span></td>
		<td data-name="board_director_facebook"<?php echo $board_directors->board_director_facebook->CellAttributes() ?>>
<span id="el_board_directors_board_director_facebook">
<span<?php echo $board_directors->board_director_facebook->ViewAttributes() ?>>
<?php echo $board_directors->board_director_facebook->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_twitter->Visible) { // board_director_twitter ?>
	<tr id="r_board_director_twitter">
		<td><span id="elh_board_directors_board_director_twitter"><?php echo $board_directors->board_director_twitter->FldCaption() ?></span></td>
		<td data-name="board_director_twitter"<?php echo $board_directors->board_director_twitter->CellAttributes() ?>>
<span id="el_board_directors_board_director_twitter">
<span<?php echo $board_directors->board_director_twitter->ViewAttributes() ?>>
<?php echo $board_directors->board_director_twitter->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_email->Visible) { // board_director_email ?>
	<tr id="r_board_director_email">
		<td><span id="elh_board_directors_board_director_email"><?php echo $board_directors->board_director_email->FldCaption() ?></span></td>
		<td data-name="board_director_email"<?php echo $board_directors->board_director_email->CellAttributes() ?>>
<span id="el_board_directors_board_director_email">
<span<?php echo $board_directors->board_director_email->ViewAttributes() ?>>
<?php echo $board_directors->board_director_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($board_directors->board_director_phone->Visible) { // board_director_phone ?>
	<tr id="r_board_director_phone">
		<td><span id="elh_board_directors_board_director_phone"><?php echo $board_directors->board_director_phone->FldCaption() ?></span></td>
		<td data-name="board_director_phone"<?php echo $board_directors->board_director_phone->CellAttributes() ?>>
<span id="el_board_directors_board_director_phone">
<span<?php echo $board_directors->board_director_phone->ViewAttributes() ?>>
<?php echo $board_directors->board_director_phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fboard_directorsview.Init();
</script>
<?php
$board_directors_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$board_directors_view->Page_Terminate();
?>
