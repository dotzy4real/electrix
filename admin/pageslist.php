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

$pages_list = NULL; // Initialize page object first

class cpages_list extends cpages {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'pages';

	// Page object name
	var $PageObjName = 'pages_list';

	// Grid form hidden field names
	var $FormName = 'fpageslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (pages)
		if (!isset($GLOBALS["pages"]) || get_class($GLOBALS["pages"]) == "cpages") {
			$GLOBALS["pages"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pages"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pagesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pagesdelete.php";
		$this->MultiUpdateUrl = "pagesupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pages', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fpageslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->page_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->page_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->page_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->page_id->AdvancedSearch->ToJSON(), ","); // Field page_id
		$sFilterList = ew_Concat($sFilterList, $this->page_name->AdvancedSearch->ToJSON(), ","); // Field page_name
		$sFilterList = ew_Concat($sFilterList, $this->page_icon_title->AdvancedSearch->ToJSON(), ","); // Field page_icon_title
		$sFilterList = ew_Concat($sFilterList, $this->page_title->AdvancedSearch->ToJSON(), ","); // Field page_title
		$sFilterList = ew_Concat($sFilterList, $this->page_breadcumb_title->AdvancedSearch->ToJSON(), ","); // Field page_breadcumb_title
		$sFilterList = ew_Concat($sFilterList, $this->page_content->AdvancedSearch->ToJSON(), ","); // Field page_content
		$sFilterList = ew_Concat($sFilterList, $this->page_banner->AdvancedSearch->ToJSON(), ","); // Field page_banner
		$sFilterList = ew_Concat($sFilterList, $this->page_title_caption->AdvancedSearch->ToJSON(), ","); // Field page_title_caption
		$sFilterList = ew_Concat($sFilterList, $this->page_show_title->AdvancedSearch->ToJSON(), ","); // Field page_show_title
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field page_id
		$this->page_id->AdvancedSearch->SearchValue = @$filter["x_page_id"];
		$this->page_id->AdvancedSearch->SearchOperator = @$filter["z_page_id"];
		$this->page_id->AdvancedSearch->SearchCondition = @$filter["v_page_id"];
		$this->page_id->AdvancedSearch->SearchValue2 = @$filter["y_page_id"];
		$this->page_id->AdvancedSearch->SearchOperator2 = @$filter["w_page_id"];
		$this->page_id->AdvancedSearch->Save();

		// Field page_name
		$this->page_name->AdvancedSearch->SearchValue = @$filter["x_page_name"];
		$this->page_name->AdvancedSearch->SearchOperator = @$filter["z_page_name"];
		$this->page_name->AdvancedSearch->SearchCondition = @$filter["v_page_name"];
		$this->page_name->AdvancedSearch->SearchValue2 = @$filter["y_page_name"];
		$this->page_name->AdvancedSearch->SearchOperator2 = @$filter["w_page_name"];
		$this->page_name->AdvancedSearch->Save();

		// Field page_icon_title
		$this->page_icon_title->AdvancedSearch->SearchValue = @$filter["x_page_icon_title"];
		$this->page_icon_title->AdvancedSearch->SearchOperator = @$filter["z_page_icon_title"];
		$this->page_icon_title->AdvancedSearch->SearchCondition = @$filter["v_page_icon_title"];
		$this->page_icon_title->AdvancedSearch->SearchValue2 = @$filter["y_page_icon_title"];
		$this->page_icon_title->AdvancedSearch->SearchOperator2 = @$filter["w_page_icon_title"];
		$this->page_icon_title->AdvancedSearch->Save();

		// Field page_title
		$this->page_title->AdvancedSearch->SearchValue = @$filter["x_page_title"];
		$this->page_title->AdvancedSearch->SearchOperator = @$filter["z_page_title"];
		$this->page_title->AdvancedSearch->SearchCondition = @$filter["v_page_title"];
		$this->page_title->AdvancedSearch->SearchValue2 = @$filter["y_page_title"];
		$this->page_title->AdvancedSearch->SearchOperator2 = @$filter["w_page_title"];
		$this->page_title->AdvancedSearch->Save();

		// Field page_breadcumb_title
		$this->page_breadcumb_title->AdvancedSearch->SearchValue = @$filter["x_page_breadcumb_title"];
		$this->page_breadcumb_title->AdvancedSearch->SearchOperator = @$filter["z_page_breadcumb_title"];
		$this->page_breadcumb_title->AdvancedSearch->SearchCondition = @$filter["v_page_breadcumb_title"];
		$this->page_breadcumb_title->AdvancedSearch->SearchValue2 = @$filter["y_page_breadcumb_title"];
		$this->page_breadcumb_title->AdvancedSearch->SearchOperator2 = @$filter["w_page_breadcumb_title"];
		$this->page_breadcumb_title->AdvancedSearch->Save();

		// Field page_content
		$this->page_content->AdvancedSearch->SearchValue = @$filter["x_page_content"];
		$this->page_content->AdvancedSearch->SearchOperator = @$filter["z_page_content"];
		$this->page_content->AdvancedSearch->SearchCondition = @$filter["v_page_content"];
		$this->page_content->AdvancedSearch->SearchValue2 = @$filter["y_page_content"];
		$this->page_content->AdvancedSearch->SearchOperator2 = @$filter["w_page_content"];
		$this->page_content->AdvancedSearch->Save();

		// Field page_banner
		$this->page_banner->AdvancedSearch->SearchValue = @$filter["x_page_banner"];
		$this->page_banner->AdvancedSearch->SearchOperator = @$filter["z_page_banner"];
		$this->page_banner->AdvancedSearch->SearchCondition = @$filter["v_page_banner"];
		$this->page_banner->AdvancedSearch->SearchValue2 = @$filter["y_page_banner"];
		$this->page_banner->AdvancedSearch->SearchOperator2 = @$filter["w_page_banner"];
		$this->page_banner->AdvancedSearch->Save();

		// Field page_title_caption
		$this->page_title_caption->AdvancedSearch->SearchValue = @$filter["x_page_title_caption"];
		$this->page_title_caption->AdvancedSearch->SearchOperator = @$filter["z_page_title_caption"];
		$this->page_title_caption->AdvancedSearch->SearchCondition = @$filter["v_page_title_caption"];
		$this->page_title_caption->AdvancedSearch->SearchValue2 = @$filter["y_page_title_caption"];
		$this->page_title_caption->AdvancedSearch->SearchOperator2 = @$filter["w_page_title_caption"];
		$this->page_title_caption->AdvancedSearch->Save();

		// Field page_show_title
		$this->page_show_title->AdvancedSearch->SearchValue = @$filter["x_page_show_title"];
		$this->page_show_title->AdvancedSearch->SearchOperator = @$filter["z_page_show_title"];
		$this->page_show_title->AdvancedSearch->SearchCondition = @$filter["v_page_show_title"];
		$this->page_show_title->AdvancedSearch->SearchValue2 = @$filter["y_page_show_title"];
		$this->page_show_title->AdvancedSearch->SearchOperator2 = @$filter["w_page_show_title"];
		$this->page_show_title->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->page_id, $Default, FALSE); // page_id
		$this->BuildSearchSql($sWhere, $this->page_name, $Default, FALSE); // page_name
		$this->BuildSearchSql($sWhere, $this->page_icon_title, $Default, FALSE); // page_icon_title
		$this->BuildSearchSql($sWhere, $this->page_title, $Default, FALSE); // page_title
		$this->BuildSearchSql($sWhere, $this->page_breadcumb_title, $Default, FALSE); // page_breadcumb_title
		$this->BuildSearchSql($sWhere, $this->page_content, $Default, FALSE); // page_content
		$this->BuildSearchSql($sWhere, $this->page_banner, $Default, FALSE); // page_banner
		$this->BuildSearchSql($sWhere, $this->page_title_caption, $Default, FALSE); // page_title_caption
		$this->BuildSearchSql($sWhere, $this->page_show_title, $Default, FALSE); // page_show_title

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->page_id->AdvancedSearch->Save(); // page_id
			$this->page_name->AdvancedSearch->Save(); // page_name
			$this->page_icon_title->AdvancedSearch->Save(); // page_icon_title
			$this->page_title->AdvancedSearch->Save(); // page_title
			$this->page_breadcumb_title->AdvancedSearch->Save(); // page_breadcumb_title
			$this->page_content->AdvancedSearch->Save(); // page_content
			$this->page_banner->AdvancedSearch->Save(); // page_banner
			$this->page_title_caption->AdvancedSearch->Save(); // page_title_caption
			$this->page_show_title->AdvancedSearch->Save(); // page_show_title
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->page_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->page_icon_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->page_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->page_breadcumb_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->page_content, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->page_banner, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->page_title_caption, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->page_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_icon_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_breadcumb_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_content->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_banner->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_title_caption->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_show_title->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->page_id->AdvancedSearch->UnsetSession();
		$this->page_name->AdvancedSearch->UnsetSession();
		$this->page_icon_title->AdvancedSearch->UnsetSession();
		$this->page_title->AdvancedSearch->UnsetSession();
		$this->page_breadcumb_title->AdvancedSearch->UnsetSession();
		$this->page_content->AdvancedSearch->UnsetSession();
		$this->page_banner->AdvancedSearch->UnsetSession();
		$this->page_title_caption->AdvancedSearch->UnsetSession();
		$this->page_show_title->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->page_id->AdvancedSearch->Load();
		$this->page_name->AdvancedSearch->Load();
		$this->page_icon_title->AdvancedSearch->Load();
		$this->page_title->AdvancedSearch->Load();
		$this->page_breadcumb_title->AdvancedSearch->Load();
		$this->page_content->AdvancedSearch->Load();
		$this->page_banner->AdvancedSearch->Load();
		$this->page_title_caption->AdvancedSearch->Load();
		$this->page_show_title->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->page_id); // page_id
			$this->UpdateSort($this->page_name); // page_name
			$this->UpdateSort($this->page_icon_title); // page_icon_title
			$this->UpdateSort($this->page_title); // page_title
			$this->UpdateSort($this->page_breadcumb_title); // page_breadcumb_title
			$this->UpdateSort($this->page_banner); // page_banner
			$this->UpdateSort($this->page_title_caption); // page_title_caption
			$this->UpdateSort($this->page_show_title); // page_show_title
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->page_id->setSort("");
				$this->page_name->setSort("");
				$this->page_icon_title->setSort("");
				$this->page_title->setSort("");
				$this->page_breadcumb_title->setSort("");
				$this->page_banner->setSort("");
				$this->page_title_caption->setSort("");
				$this->page_show_title->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt) {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->page_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpageslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpageslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpageslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpageslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// page_id

		$this->page_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_id"]);
		if ($this->page_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_id->AdvancedSearch->SearchOperator = @$_GET["z_page_id"];

		// page_name
		$this->page_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_name"]);
		if ($this->page_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_name->AdvancedSearch->SearchOperator = @$_GET["z_page_name"];

		// page_icon_title
		$this->page_icon_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_icon_title"]);
		if ($this->page_icon_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_icon_title->AdvancedSearch->SearchOperator = @$_GET["z_page_icon_title"];

		// page_title
		$this->page_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_title"]);
		if ($this->page_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_title->AdvancedSearch->SearchOperator = @$_GET["z_page_title"];

		// page_breadcumb_title
		$this->page_breadcumb_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_breadcumb_title"]);
		if ($this->page_breadcumb_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_breadcumb_title->AdvancedSearch->SearchOperator = @$_GET["z_page_breadcumb_title"];

		// page_content
		$this->page_content->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_content"]);
		if ($this->page_content->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_content->AdvancedSearch->SearchOperator = @$_GET["z_page_content"];

		// page_banner
		$this->page_banner->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_banner"]);
		if ($this->page_banner->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_banner->AdvancedSearch->SearchOperator = @$_GET["z_page_banner"];

		// page_title_caption
		$this->page_title_caption->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_title_caption"]);
		if ($this->page_title_caption->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_title_caption->AdvancedSearch->SearchOperator = @$_GET["z_page_title_caption"];

		// page_show_title
		$this->page_show_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_page_show_title"]);
		if ($this->page_show_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->page_show_title->AdvancedSearch->SearchOperator = @$_GET["z_page_show_title"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// page_id
			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";
			$this->page_id->TooltipValue = "";

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
				$this->page_banner->LinkAttrs["data-rel"] = "pages_x" . $this->RowCnt . "_page_banner";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// page_id
			$this->page_id->EditAttrs["class"] = "form-control";
			$this->page_id->EditCustomAttributes = "";
			$this->page_id->EditValue = ew_HtmlEncode($this->page_id->AdvancedSearch->SearchValue);
			$this->page_id->PlaceHolder = ew_RemoveHtml($this->page_id->FldCaption());

			// page_name
			$this->page_name->EditAttrs["class"] = "form-control";
			$this->page_name->EditCustomAttributes = "";
			$this->page_name->EditValue = ew_HtmlEncode($this->page_name->AdvancedSearch->SearchValue);
			$this->page_name->PlaceHolder = ew_RemoveHtml($this->page_name->FldCaption());

			// page_icon_title
			$this->page_icon_title->EditAttrs["class"] = "form-control";
			$this->page_icon_title->EditCustomAttributes = "";
			$this->page_icon_title->EditValue = ew_HtmlEncode($this->page_icon_title->AdvancedSearch->SearchValue);
			$this->page_icon_title->PlaceHolder = ew_RemoveHtml($this->page_icon_title->FldCaption());

			// page_title
			$this->page_title->EditAttrs["class"] = "form-control";
			$this->page_title->EditCustomAttributes = "";
			$this->page_title->EditValue = ew_HtmlEncode($this->page_title->AdvancedSearch->SearchValue);
			$this->page_title->PlaceHolder = ew_RemoveHtml($this->page_title->FldCaption());

			// page_breadcumb_title
			$this->page_breadcumb_title->EditAttrs["class"] = "form-control";
			$this->page_breadcumb_title->EditCustomAttributes = "";
			$this->page_breadcumb_title->EditValue = ew_HtmlEncode($this->page_breadcumb_title->AdvancedSearch->SearchValue);
			$this->page_breadcumb_title->PlaceHolder = ew_RemoveHtml($this->page_breadcumb_title->FldCaption());

			// page_banner
			$this->page_banner->EditAttrs["class"] = "form-control";
			$this->page_banner->EditCustomAttributes = "";
			$this->page_banner->EditValue = ew_HtmlEncode($this->page_banner->AdvancedSearch->SearchValue);
			$this->page_banner->PlaceHolder = ew_RemoveHtml($this->page_banner->FldCaption());

			// page_title_caption
			$this->page_title_caption->EditAttrs["class"] = "form-control";
			$this->page_title_caption->EditCustomAttributes = "";
			$this->page_title_caption->EditValue = ew_HtmlEncode($this->page_title_caption->AdvancedSearch->SearchValue);
			$this->page_title_caption->PlaceHolder = ew_RemoveHtml($this->page_title_caption->FldCaption());

			// page_show_title
			$this->page_show_title->EditCustomAttributes = "";
			$this->page_show_title->EditValue = $this->page_show_title->Options(FALSE);
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->page_id->AdvancedSearch->Load();
		$this->page_name->AdvancedSearch->Load();
		$this->page_icon_title->AdvancedSearch->Load();
		$this->page_title->AdvancedSearch->Load();
		$this->page_breadcumb_title->AdvancedSearch->Load();
		$this->page_content->AdvancedSearch->Load();
		$this->page_banner->AdvancedSearch->Load();
		$this->page_title_caption->AdvancedSearch->Load();
		$this->page_show_title->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($pages_list)) $pages_list = new cpages_list();

// Page init
$pages_list->Page_Init();

// Page main
$pages_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pages_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpageslist = new ew_Form("fpageslist", "list");
fpageslist.FormKeyCountName = '<?php echo $pages_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpageslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpageslist.ValidateRequired = true;
<?php } else { ?>
fpageslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpageslist.Lists["x_page_show_title"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpageslist.Lists["x_page_show_title"].Options = <?php echo json_encode($pages->page_show_title->Options()) ?>;

// Form object for search
var CurrentSearchForm = fpageslistsrch = new ew_Form("fpageslistsrch");

// Validate function for search
fpageslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fpageslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpageslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fpageslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fpageslistsrch.Lists["x_page_show_title"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpageslistsrch.Lists["x_page_show_title"].Options = <?php echo json_encode($pages->page_show_title->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($pages_list->TotalRecs > 0 && $pages_list->ExportOptions->Visible()) { ?>
<?php $pages_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pages_list->SearchOptions->Visible()) { ?>
<?php $pages_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pages_list->FilterOptions->Visible()) { ?>
<?php $pages_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $pages_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pages_list->TotalRecs <= 0)
			$pages_list->TotalRecs = $pages->SelectRecordCount();
	} else {
		if (!$pages_list->Recordset && ($pages_list->Recordset = $pages_list->LoadRecordset()))
			$pages_list->TotalRecs = $pages_list->Recordset->RecordCount();
	}
	$pages_list->StartRec = 1;
	if ($pages_list->DisplayRecs <= 0 || ($pages->Export <> "" && $pages->ExportAll)) // Display all records
		$pages_list->DisplayRecs = $pages_list->TotalRecs;
	if (!($pages->Export <> "" && $pages->ExportAll))
		$pages_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pages_list->Recordset = $pages_list->LoadRecordset($pages_list->StartRec-1, $pages_list->DisplayRecs);

	// Set no record found message
	if ($pages->CurrentAction == "" && $pages_list->TotalRecs == 0) {
		if ($pages_list->SearchWhere == "0=101")
			$pages_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pages_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pages_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($pages->Export == "" && $pages->CurrentAction == "") { ?>
<form name="fpageslistsrch" id="fpageslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pages_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpageslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pages">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$pages_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$pages->RowType = EW_ROWTYPE_SEARCH;

// Render row
$pages->ResetAttrs();
$pages_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($pages->page_show_title->Visible) { // page_show_title ?>
	<div id="xsc_page_show_title" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $pages->page_show_title->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_page_show_title" id="z_page_show_title" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_page_show_title" class="ewTemplate"><input type="radio" data-table="pages" data-field="x_page_show_title" data-value-separator="<?php echo ew_HtmlEncode(is_array($pages->page_show_title->DisplayValueSeparator) ? json_encode($pages->page_show_title->DisplayValueSeparator) : $pages->page_show_title->DisplayValueSeparator) ?>" name="x_page_show_title" id="x_page_show_title" value="{value}"<?php echo $pages->page_show_title->EditAttributes() ?>></div>
<div id="dsl_x_page_show_title" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $pages->page_show_title->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pages->page_show_title->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
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
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pages_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pages_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pages_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pages_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pages_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pages_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pages_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pages_list->ShowPageHeader(); ?>
<?php
$pages_list->ShowMessage();
?>
<?php if ($pages_list->TotalRecs > 0 || $pages->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="fpageslist" id="fpageslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pages_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pages_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pages">
<div id="gmp_pages" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($pages_list->TotalRecs > 0) { ?>
<table id="tbl_pageslist" class="table ewTable">
<?php echo $pages->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$pages_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pages_list->RenderListOptions();

// Render list options (header, left)
$pages_list->ListOptions->Render("header", "left");
?>
<?php if ($pages->page_id->Visible) { // page_id ?>
	<?php if ($pages->SortUrl($pages->page_id) == "") { ?>
		<th data-name="page_id"><div id="elh_pages_page_id" class="pages_page_id"><div class="ewTableHeaderCaption"><?php echo $pages->page_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_id) ?>',1);"><div id="elh_pages_page_id" class="pages_page_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_name->Visible) { // page_name ?>
	<?php if ($pages->SortUrl($pages->page_name) == "") { ?>
		<th data-name="page_name"><div id="elh_pages_page_name" class="pages_page_name"><div class="ewTableHeaderCaption"><?php echo $pages->page_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_name) ?>',1);"><div id="elh_pages_page_name" class="pages_page_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_icon_title->Visible) { // page_icon_title ?>
	<?php if ($pages->SortUrl($pages->page_icon_title) == "") { ?>
		<th data-name="page_icon_title"><div id="elh_pages_page_icon_title" class="pages_page_icon_title"><div class="ewTableHeaderCaption"><?php echo $pages->page_icon_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_icon_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_icon_title) ?>',1);"><div id="elh_pages_page_icon_title" class="pages_page_icon_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_icon_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_icon_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_icon_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_title->Visible) { // page_title ?>
	<?php if ($pages->SortUrl($pages->page_title) == "") { ?>
		<th data-name="page_title"><div id="elh_pages_page_title" class="pages_page_title"><div class="ewTableHeaderCaption"><?php echo $pages->page_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_title) ?>',1);"><div id="elh_pages_page_title" class="pages_page_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_breadcumb_title->Visible) { // page_breadcumb_title ?>
	<?php if ($pages->SortUrl($pages->page_breadcumb_title) == "") { ?>
		<th data-name="page_breadcumb_title"><div id="elh_pages_page_breadcumb_title" class="pages_page_breadcumb_title"><div class="ewTableHeaderCaption"><?php echo $pages->page_breadcumb_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_breadcumb_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_breadcumb_title) ?>',1);"><div id="elh_pages_page_breadcumb_title" class="pages_page_breadcumb_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_breadcumb_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_breadcumb_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_breadcumb_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_banner->Visible) { // page_banner ?>
	<?php if ($pages->SortUrl($pages->page_banner) == "") { ?>
		<th data-name="page_banner"><div id="elh_pages_page_banner" class="pages_page_banner"><div class="ewTableHeaderCaption"><?php echo $pages->page_banner->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_banner"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_banner) ?>',1);"><div id="elh_pages_page_banner" class="pages_page_banner">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_banner->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_banner->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_banner->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_title_caption->Visible) { // page_title_caption ?>
	<?php if ($pages->SortUrl($pages->page_title_caption) == "") { ?>
		<th data-name="page_title_caption"><div id="elh_pages_page_title_caption" class="pages_page_title_caption"><div class="ewTableHeaderCaption"><?php echo $pages->page_title_caption->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_title_caption"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_title_caption) ?>',1);"><div id="elh_pages_page_title_caption" class="pages_page_title_caption">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_title_caption->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_title_caption->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_title_caption->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pages->page_show_title->Visible) { // page_show_title ?>
	<?php if ($pages->SortUrl($pages->page_show_title) == "") { ?>
		<th data-name="page_show_title"><div id="elh_pages_page_show_title" class="pages_page_show_title"><div class="ewTableHeaderCaption"><?php echo $pages->page_show_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_show_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pages->SortUrl($pages->page_show_title) ?>',1);"><div id="elh_pages_page_show_title" class="pages_page_show_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pages->page_show_title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pages->page_show_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pages->page_show_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pages_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pages->ExportAll && $pages->Export <> "") {
	$pages_list->StopRec = $pages_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pages_list->TotalRecs > $pages_list->StartRec + $pages_list->DisplayRecs - 1)
		$pages_list->StopRec = $pages_list->StartRec + $pages_list->DisplayRecs - 1;
	else
		$pages_list->StopRec = $pages_list->TotalRecs;
}
$pages_list->RecCnt = $pages_list->StartRec - 1;
if ($pages_list->Recordset && !$pages_list->Recordset->EOF) {
	$pages_list->Recordset->MoveFirst();
	$bSelectLimit = $pages_list->UseSelectLimit;
	if (!$bSelectLimit && $pages_list->StartRec > 1)
		$pages_list->Recordset->Move($pages_list->StartRec - 1);
} elseif (!$pages->AllowAddDeleteRow && $pages_list->StopRec == 0) {
	$pages_list->StopRec = $pages->GridAddRowCount;
}

// Initialize aggregate
$pages->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pages->ResetAttrs();
$pages_list->RenderRow();
while ($pages_list->RecCnt < $pages_list->StopRec) {
	$pages_list->RecCnt++;
	if (intval($pages_list->RecCnt) >= intval($pages_list->StartRec)) {
		$pages_list->RowCnt++;

		// Set up key count
		$pages_list->KeyCount = $pages_list->RowIndex;

		// Init row class and style
		$pages->ResetAttrs();
		$pages->CssClass = "";
		if ($pages->CurrentAction == "gridadd") {
		} else {
			$pages_list->LoadRowValues($pages_list->Recordset); // Load row values
		}
		$pages->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pages->RowAttrs = array_merge($pages->RowAttrs, array('data-rowindex'=>$pages_list->RowCnt, 'id'=>'r' . $pages_list->RowCnt . '_pages', 'data-rowtype'=>$pages->RowType));

		// Render row
		$pages_list->RenderRow();

		// Render list options
		$pages_list->RenderListOptions();
?>
	<tr<?php echo $pages->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pages_list->ListOptions->Render("body", "left", $pages_list->RowCnt);
?>
	<?php if ($pages->page_id->Visible) { // page_id ?>
		<td data-name="page_id"<?php echo $pages->page_id->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_id" class="pages_page_id">
<span<?php echo $pages->page_id->ViewAttributes() ?>>
<?php echo $pages->page_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $pages_list->PageObjName . "_row_" . $pages_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pages->page_name->Visible) { // page_name ?>
		<td data-name="page_name"<?php echo $pages->page_name->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_name" class="pages_page_name">
<span<?php echo $pages->page_name->ViewAttributes() ?>>
<?php echo $pages->page_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pages->page_icon_title->Visible) { // page_icon_title ?>
		<td data-name="page_icon_title"<?php echo $pages->page_icon_title->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_icon_title" class="pages_page_icon_title">
<span<?php echo $pages->page_icon_title->ViewAttributes() ?>>
<?php echo $pages->page_icon_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pages->page_title->Visible) { // page_title ?>
		<td data-name="page_title"<?php echo $pages->page_title->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_title" class="pages_page_title">
<span<?php echo $pages->page_title->ViewAttributes() ?>>
<?php echo $pages->page_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pages->page_breadcumb_title->Visible) { // page_breadcumb_title ?>
		<td data-name="page_breadcumb_title"<?php echo $pages->page_breadcumb_title->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_breadcumb_title" class="pages_page_breadcumb_title">
<span<?php echo $pages->page_breadcumb_title->ViewAttributes() ?>>
<?php echo $pages->page_breadcumb_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pages->page_banner->Visible) { // page_banner ?>
		<td data-name="page_banner"<?php echo $pages->page_banner->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_banner" class="pages_page_banner">
<span>
<?php echo ew_GetFileViewTag($pages->page_banner, $pages->page_banner->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($pages->page_title_caption->Visible) { // page_title_caption ?>
		<td data-name="page_title_caption"<?php echo $pages->page_title_caption->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_title_caption" class="pages_page_title_caption">
<span<?php echo $pages->page_title_caption->ViewAttributes() ?>>
<?php echo $pages->page_title_caption->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pages->page_show_title->Visible) { // page_show_title ?>
		<td data-name="page_show_title"<?php echo $pages->page_show_title->CellAttributes() ?>>
<span id="el<?php echo $pages_list->RowCnt ?>_pages_page_show_title" class="pages_page_show_title">
<span<?php echo $pages->page_show_title->ViewAttributes() ?>>
<?php echo $pages->page_show_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pages_list->ListOptions->Render("body", "right", $pages_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pages->CurrentAction <> "gridadd")
		$pages_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pages->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pages_list->Recordset)
	$pages_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($pages->CurrentAction <> "gridadd" && $pages->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pages_list->Pager)) $pages_list->Pager = new cPrevNextPager($pages_list->StartRec, $pages_list->DisplayRecs, $pages_list->TotalRecs) ?>
<?php if ($pages_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pages_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pages_list->PageUrl() ?>start=<?php echo $pages_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pages_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pages_list->PageUrl() ?>start=<?php echo $pages_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pages_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pages_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pages_list->PageUrl() ?>start=<?php echo $pages_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pages_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pages_list->PageUrl() ?>start=<?php echo $pages_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pages_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pages_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pages_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pages_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pages_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($pages_list->TotalRecs == 0 && $pages->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pages_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fpageslistsrch.Init();
fpageslistsrch.FilterList = <?php echo $pages_list->GetFilterList() ?>;
fpageslist.Init();
</script>
<?php
$pages_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pages_list->Page_Terminate();
?>
