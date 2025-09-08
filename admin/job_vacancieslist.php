<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "job_vacanciesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$job_vacancies_list = NULL; // Initialize page object first

class cjob_vacancies_list extends cjob_vacancies {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'job_vacancies';

	// Page object name
	var $PageObjName = 'job_vacancies_list';

	// Grid form hidden field names
	var $FormName = 'fjob_vacancieslist';
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

		// Table object (job_vacancies)
		if (!isset($GLOBALS["job_vacancies"]) || get_class($GLOBALS["job_vacancies"]) == "cjob_vacancies") {
			$GLOBALS["job_vacancies"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["job_vacancies"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "job_vacanciesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "job_vacanciesdelete.php";
		$this->MultiUpdateUrl = "job_vacanciesupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'job_vacancies', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fjob_vacancieslistsrch";

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
		$this->job_vacancy_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $job_vacancies;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($job_vacancies);
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
			$this->job_vacancy_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->job_vacancy_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->job_vacancy_id->AdvancedSearch->ToJSON(), ","); // Field job_vacancy_id
		$sFilterList = ew_Concat($sFilterList, $this->job_vacancy_title->AdvancedSearch->ToJSON(), ","); // Field job_vacancy_title
		$sFilterList = ew_Concat($sFilterList, $this->job_vacancy_description->AdvancedSearch->ToJSON(), ","); // Field job_vacancy_description
		$sFilterList = ew_Concat($sFilterList, $this->job_vacancy_date_posted->AdvancedSearch->ToJSON(), ","); // Field job_vacancy_date_posted
		$sFilterList = ew_Concat($sFilterList, $this->job_vacancy_expiry_date->AdvancedSearch->ToJSON(), ","); // Field job_vacancy_expiry_date
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJSON(), ","); // Field status
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

		// Field job_vacancy_id
		$this->job_vacancy_id->AdvancedSearch->SearchValue = @$filter["x_job_vacancy_id"];
		$this->job_vacancy_id->AdvancedSearch->SearchOperator = @$filter["z_job_vacancy_id"];
		$this->job_vacancy_id->AdvancedSearch->SearchCondition = @$filter["v_job_vacancy_id"];
		$this->job_vacancy_id->AdvancedSearch->SearchValue2 = @$filter["y_job_vacancy_id"];
		$this->job_vacancy_id->AdvancedSearch->SearchOperator2 = @$filter["w_job_vacancy_id"];
		$this->job_vacancy_id->AdvancedSearch->Save();

		// Field job_vacancy_title
		$this->job_vacancy_title->AdvancedSearch->SearchValue = @$filter["x_job_vacancy_title"];
		$this->job_vacancy_title->AdvancedSearch->SearchOperator = @$filter["z_job_vacancy_title"];
		$this->job_vacancy_title->AdvancedSearch->SearchCondition = @$filter["v_job_vacancy_title"];
		$this->job_vacancy_title->AdvancedSearch->SearchValue2 = @$filter["y_job_vacancy_title"];
		$this->job_vacancy_title->AdvancedSearch->SearchOperator2 = @$filter["w_job_vacancy_title"];
		$this->job_vacancy_title->AdvancedSearch->Save();

		// Field job_vacancy_description
		$this->job_vacancy_description->AdvancedSearch->SearchValue = @$filter["x_job_vacancy_description"];
		$this->job_vacancy_description->AdvancedSearch->SearchOperator = @$filter["z_job_vacancy_description"];
		$this->job_vacancy_description->AdvancedSearch->SearchCondition = @$filter["v_job_vacancy_description"];
		$this->job_vacancy_description->AdvancedSearch->SearchValue2 = @$filter["y_job_vacancy_description"];
		$this->job_vacancy_description->AdvancedSearch->SearchOperator2 = @$filter["w_job_vacancy_description"];
		$this->job_vacancy_description->AdvancedSearch->Save();

		// Field job_vacancy_date_posted
		$this->job_vacancy_date_posted->AdvancedSearch->SearchValue = @$filter["x_job_vacancy_date_posted"];
		$this->job_vacancy_date_posted->AdvancedSearch->SearchOperator = @$filter["z_job_vacancy_date_posted"];
		$this->job_vacancy_date_posted->AdvancedSearch->SearchCondition = @$filter["v_job_vacancy_date_posted"];
		$this->job_vacancy_date_posted->AdvancedSearch->SearchValue2 = @$filter["y_job_vacancy_date_posted"];
		$this->job_vacancy_date_posted->AdvancedSearch->SearchOperator2 = @$filter["w_job_vacancy_date_posted"];
		$this->job_vacancy_date_posted->AdvancedSearch->Save();

		// Field job_vacancy_expiry_date
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchValue = @$filter["x_job_vacancy_expiry_date"];
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchOperator = @$filter["z_job_vacancy_expiry_date"];
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchCondition = @$filter["v_job_vacancy_expiry_date"];
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchValue2 = @$filter["y_job_vacancy_expiry_date"];
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchOperator2 = @$filter["w_job_vacancy_expiry_date"];
		$this->job_vacancy_expiry_date->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->job_vacancy_id, $Default, FALSE); // job_vacancy_id
		$this->BuildSearchSql($sWhere, $this->job_vacancy_title, $Default, FALSE); // job_vacancy_title
		$this->BuildSearchSql($sWhere, $this->job_vacancy_description, $Default, FALSE); // job_vacancy_description
		$this->BuildSearchSql($sWhere, $this->job_vacancy_date_posted, $Default, FALSE); // job_vacancy_date_posted
		$this->BuildSearchSql($sWhere, $this->job_vacancy_expiry_date, $Default, FALSE); // job_vacancy_expiry_date
		$this->BuildSearchSql($sWhere, $this->status, $Default, FALSE); // status

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->job_vacancy_id->AdvancedSearch->Save(); // job_vacancy_id
			$this->job_vacancy_title->AdvancedSearch->Save(); // job_vacancy_title
			$this->job_vacancy_description->AdvancedSearch->Save(); // job_vacancy_description
			$this->job_vacancy_date_posted->AdvancedSearch->Save(); // job_vacancy_date_posted
			$this->job_vacancy_expiry_date->AdvancedSearch->Save(); // job_vacancy_expiry_date
			$this->status->AdvancedSearch->Save(); // status
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
		$this->BuildBasicSearchSQL($sWhere, $this->job_vacancy_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->job_vacancy_description, $arKeywords, $type);
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
		if ($this->job_vacancy_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->job_vacancy_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->job_vacancy_description->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->job_vacancy_date_posted->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->job_vacancy_expiry_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->status->AdvancedSearch->IssetSession())
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
		$this->job_vacancy_id->AdvancedSearch->UnsetSession();
		$this->job_vacancy_title->AdvancedSearch->UnsetSession();
		$this->job_vacancy_description->AdvancedSearch->UnsetSession();
		$this->job_vacancy_date_posted->AdvancedSearch->UnsetSession();
		$this->job_vacancy_expiry_date->AdvancedSearch->UnsetSession();
		$this->status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->job_vacancy_id->AdvancedSearch->Load();
		$this->job_vacancy_title->AdvancedSearch->Load();
		$this->job_vacancy_description->AdvancedSearch->Load();
		$this->job_vacancy_date_posted->AdvancedSearch->Load();
		$this->job_vacancy_expiry_date->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->job_vacancy_id); // job_vacancy_id
			$this->UpdateSort($this->job_vacancy_title); // job_vacancy_title
			$this->UpdateSort($this->job_vacancy_date_posted); // job_vacancy_date_posted
			$this->UpdateSort($this->job_vacancy_expiry_date); // job_vacancy_expiry_date
			$this->UpdateSort($this->status); // status
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
				$this->job_vacancy_id->setSort("");
				$this->job_vacancy_title->setSort("");
				$this->job_vacancy_date_posted->setSort("");
				$this->job_vacancy_expiry_date->setSort("");
				$this->status->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->job_vacancy_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fjob_vacancieslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fjob_vacancieslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fjob_vacancieslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fjob_vacancieslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		// job_vacancy_id

		$this->job_vacancy_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_job_vacancy_id"]);
		if ($this->job_vacancy_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->job_vacancy_id->AdvancedSearch->SearchOperator = @$_GET["z_job_vacancy_id"];

		// job_vacancy_title
		$this->job_vacancy_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_job_vacancy_title"]);
		if ($this->job_vacancy_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->job_vacancy_title->AdvancedSearch->SearchOperator = @$_GET["z_job_vacancy_title"];

		// job_vacancy_description
		$this->job_vacancy_description->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_job_vacancy_description"]);
		if ($this->job_vacancy_description->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->job_vacancy_description->AdvancedSearch->SearchOperator = @$_GET["z_job_vacancy_description"];

		// job_vacancy_date_posted
		$this->job_vacancy_date_posted->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_job_vacancy_date_posted"]);
		if ($this->job_vacancy_date_posted->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->job_vacancy_date_posted->AdvancedSearch->SearchOperator = @$_GET["z_job_vacancy_date_posted"];

		// job_vacancy_expiry_date
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_job_vacancy_expiry_date"]);
		if ($this->job_vacancy_expiry_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->job_vacancy_expiry_date->AdvancedSearch->SearchOperator = @$_GET["z_job_vacancy_expiry_date"];

		// status
		$this->status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_status"]);
		if ($this->status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->status->AdvancedSearch->SearchOperator = @$_GET["z_status"];
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
		$this->job_vacancy_id->setDbValue($rs->fields('job_vacancy_id'));
		$this->job_vacancy_title->setDbValue($rs->fields('job_vacancy_title'));
		$this->job_vacancy_description->setDbValue($rs->fields('job_vacancy_description'));
		$this->job_vacancy_date_posted->setDbValue($rs->fields('job_vacancy_date_posted'));
		$this->job_vacancy_expiry_date->setDbValue($rs->fields('job_vacancy_expiry_date'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->job_vacancy_id->DbValue = $row['job_vacancy_id'];
		$this->job_vacancy_title->DbValue = $row['job_vacancy_title'];
		$this->job_vacancy_description->DbValue = $row['job_vacancy_description'];
		$this->job_vacancy_date_posted->DbValue = $row['job_vacancy_date_posted'];
		$this->job_vacancy_expiry_date->DbValue = $row['job_vacancy_expiry_date'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("job_vacancy_id")) <> "")
			$this->job_vacancy_id->CurrentValue = $this->getKey("job_vacancy_id"); // job_vacancy_id
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
		// job_vacancy_id
		// job_vacancy_title
		// job_vacancy_description
		// job_vacancy_date_posted
		// job_vacancy_expiry_date
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// job_vacancy_id
		$this->job_vacancy_id->ViewValue = $this->job_vacancy_id->CurrentValue;
		$this->job_vacancy_id->ViewCustomAttributes = "";

		// job_vacancy_title
		$this->job_vacancy_title->ViewValue = $this->job_vacancy_title->CurrentValue;
		$this->job_vacancy_title->ViewCustomAttributes = "";

		// job_vacancy_date_posted
		$this->job_vacancy_date_posted->ViewValue = $this->job_vacancy_date_posted->CurrentValue;
		$this->job_vacancy_date_posted->ViewValue = ew_FormatDateTime($this->job_vacancy_date_posted->ViewValue, 5);
		$this->job_vacancy_date_posted->ViewCustomAttributes = "";

		// job_vacancy_expiry_date
		$this->job_vacancy_expiry_date->ViewValue = $this->job_vacancy_expiry_date->CurrentValue;
		$this->job_vacancy_expiry_date->ViewValue = ew_FormatDateTime($this->job_vacancy_expiry_date->ViewValue, 5);
		$this->job_vacancy_expiry_date->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

			// job_vacancy_id
			$this->job_vacancy_id->LinkCustomAttributes = "";
			$this->job_vacancy_id->HrefValue = "";
			$this->job_vacancy_id->TooltipValue = "";

			// job_vacancy_title
			$this->job_vacancy_title->LinkCustomAttributes = "";
			$this->job_vacancy_title->HrefValue = "";
			$this->job_vacancy_title->TooltipValue = "";

			// job_vacancy_date_posted
			$this->job_vacancy_date_posted->LinkCustomAttributes = "";
			$this->job_vacancy_date_posted->HrefValue = "";
			$this->job_vacancy_date_posted->TooltipValue = "";

			// job_vacancy_expiry_date
			$this->job_vacancy_expiry_date->LinkCustomAttributes = "";
			$this->job_vacancy_expiry_date->HrefValue = "";
			$this->job_vacancy_expiry_date->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// job_vacancy_id
			$this->job_vacancy_id->EditAttrs["class"] = "form-control";
			$this->job_vacancy_id->EditCustomAttributes = "";
			$this->job_vacancy_id->EditValue = ew_HtmlEncode($this->job_vacancy_id->AdvancedSearch->SearchValue);
			$this->job_vacancy_id->PlaceHolder = ew_RemoveHtml($this->job_vacancy_id->FldCaption());

			// job_vacancy_title
			$this->job_vacancy_title->EditAttrs["class"] = "form-control";
			$this->job_vacancy_title->EditCustomAttributes = "";
			$this->job_vacancy_title->EditValue = ew_HtmlEncode($this->job_vacancy_title->AdvancedSearch->SearchValue);
			$this->job_vacancy_title->PlaceHolder = ew_RemoveHtml($this->job_vacancy_title->FldCaption());

			// job_vacancy_date_posted
			$this->job_vacancy_date_posted->EditAttrs["class"] = "form-control";
			$this->job_vacancy_date_posted->EditCustomAttributes = "";
			$this->job_vacancy_date_posted->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->job_vacancy_date_posted->AdvancedSearch->SearchValue, 5), 5));
			$this->job_vacancy_date_posted->PlaceHolder = ew_RemoveHtml($this->job_vacancy_date_posted->FldCaption());

			// job_vacancy_expiry_date
			$this->job_vacancy_expiry_date->EditAttrs["class"] = "form-control";
			$this->job_vacancy_expiry_date->EditCustomAttributes = "";
			$this->job_vacancy_expiry_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->job_vacancy_expiry_date->AdvancedSearch->SearchValue, 5), 5));
			$this->job_vacancy_expiry_date->PlaceHolder = ew_RemoveHtml($this->job_vacancy_expiry_date->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);
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
		$this->job_vacancy_id->AdvancedSearch->Load();
		$this->job_vacancy_title->AdvancedSearch->Load();
		$this->job_vacancy_description->AdvancedSearch->Load();
		$this->job_vacancy_date_posted->AdvancedSearch->Load();
		$this->job_vacancy_expiry_date->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
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
if (!isset($job_vacancies_list)) $job_vacancies_list = new cjob_vacancies_list();

// Page init
$job_vacancies_list->Page_Init();

// Page main
$job_vacancies_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$job_vacancies_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fjob_vacancieslist = new ew_Form("fjob_vacancieslist", "list");
fjob_vacancieslist.FormKeyCountName = '<?php echo $job_vacancies_list->FormKeyCountName ?>';

// Form_CustomValidate event
fjob_vacancieslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fjob_vacancieslist.ValidateRequired = true;
<?php } else { ?>
fjob_vacancieslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fjob_vacancieslist.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fjob_vacancieslist.Lists["x_status"].Options = <?php echo json_encode($job_vacancies->status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fjob_vacancieslistsrch = new ew_Form("fjob_vacancieslistsrch");

// Validate function for search
fjob_vacancieslistsrch.Validate = function(fobj) {
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
fjob_vacancieslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fjob_vacancieslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fjob_vacancieslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fjob_vacancieslistsrch.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fjob_vacancieslistsrch.Lists["x_status"].Options = <?php echo json_encode($job_vacancies->status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($job_vacancies_list->TotalRecs > 0 && $job_vacancies_list->ExportOptions->Visible()) { ?>
<?php $job_vacancies_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($job_vacancies_list->SearchOptions->Visible()) { ?>
<?php $job_vacancies_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($job_vacancies_list->FilterOptions->Visible()) { ?>
<?php $job_vacancies_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $job_vacancies_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($job_vacancies_list->TotalRecs <= 0)
			$job_vacancies_list->TotalRecs = $job_vacancies->SelectRecordCount();
	} else {
		if (!$job_vacancies_list->Recordset && ($job_vacancies_list->Recordset = $job_vacancies_list->LoadRecordset()))
			$job_vacancies_list->TotalRecs = $job_vacancies_list->Recordset->RecordCount();
	}
	$job_vacancies_list->StartRec = 1;
	if ($job_vacancies_list->DisplayRecs <= 0 || ($job_vacancies->Export <> "" && $job_vacancies->ExportAll)) // Display all records
		$job_vacancies_list->DisplayRecs = $job_vacancies_list->TotalRecs;
	if (!($job_vacancies->Export <> "" && $job_vacancies->ExportAll))
		$job_vacancies_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$job_vacancies_list->Recordset = $job_vacancies_list->LoadRecordset($job_vacancies_list->StartRec-1, $job_vacancies_list->DisplayRecs);

	// Set no record found message
	if ($job_vacancies->CurrentAction == "" && $job_vacancies_list->TotalRecs == 0) {
		if ($job_vacancies_list->SearchWhere == "0=101")
			$job_vacancies_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$job_vacancies_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$job_vacancies_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($job_vacancies->Export == "" && $job_vacancies->CurrentAction == "") { ?>
<form name="fjob_vacancieslistsrch" id="fjob_vacancieslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($job_vacancies_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fjob_vacancieslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="job_vacancies">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$job_vacancies_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$job_vacancies->RowType = EW_ROWTYPE_SEARCH;

// Render row
$job_vacancies->ResetAttrs();
$job_vacancies_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($job_vacancies->status->Visible) { // status ?>
	<div id="xsc_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $job_vacancies->status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status" id="z_status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="job_vacancies" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($job_vacancies->status->DisplayValueSeparator) ? json_encode($job_vacancies->status->DisplayValueSeparator) : $job_vacancies->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $job_vacancies->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $job_vacancies->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($job_vacancies->status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="job_vacancies" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $job_vacancies->status->EditAttributes() ?>><?php echo $job_vacancies->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($job_vacancies->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="job_vacancies" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($job_vacancies->status->CurrentValue) ?>" checked<?php echo $job_vacancies->status->EditAttributes() ?>><?php echo $job_vacancies->status->CurrentValue ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($job_vacancies_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($job_vacancies_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $job_vacancies_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($job_vacancies_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($job_vacancies_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($job_vacancies_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($job_vacancies_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $job_vacancies_list->ShowPageHeader(); ?>
<?php
$job_vacancies_list->ShowMessage();
?>
<?php if ($job_vacancies_list->TotalRecs > 0 || $job_vacancies->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="fjob_vacancieslist" id="fjob_vacancieslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($job_vacancies_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $job_vacancies_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="job_vacancies">
<div id="gmp_job_vacancies" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($job_vacancies_list->TotalRecs > 0) { ?>
<table id="tbl_job_vacancieslist" class="table ewTable">
<?php echo $job_vacancies->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$job_vacancies_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$job_vacancies_list->RenderListOptions();

// Render list options (header, left)
$job_vacancies_list->ListOptions->Render("header", "left");
?>
<?php if ($job_vacancies->job_vacancy_id->Visible) { // job_vacancy_id ?>
	<?php if ($job_vacancies->SortUrl($job_vacancies->job_vacancy_id) == "") { ?>
		<th data-name="job_vacancy_id"><div id="elh_job_vacancies_job_vacancy_id" class="job_vacancies_job_vacancy_id"><div class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="job_vacancy_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $job_vacancies->SortUrl($job_vacancies->job_vacancy_id) ?>',1);"><div id="elh_job_vacancies_job_vacancy_id" class="job_vacancies_job_vacancy_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($job_vacancies->job_vacancy_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($job_vacancies->job_vacancy_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($job_vacancies->job_vacancy_title->Visible) { // job_vacancy_title ?>
	<?php if ($job_vacancies->SortUrl($job_vacancies->job_vacancy_title) == "") { ?>
		<th data-name="job_vacancy_title"><div id="elh_job_vacancies_job_vacancy_title" class="job_vacancies_job_vacancy_title"><div class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="job_vacancy_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $job_vacancies->SortUrl($job_vacancies->job_vacancy_title) ?>',1);"><div id="elh_job_vacancies_job_vacancy_title" class="job_vacancies_job_vacancy_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($job_vacancies->job_vacancy_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($job_vacancies->job_vacancy_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($job_vacancies->job_vacancy_date_posted->Visible) { // job_vacancy_date_posted ?>
	<?php if ($job_vacancies->SortUrl($job_vacancies->job_vacancy_date_posted) == "") { ?>
		<th data-name="job_vacancy_date_posted"><div id="elh_job_vacancies_job_vacancy_date_posted" class="job_vacancies_job_vacancy_date_posted"><div class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_date_posted->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="job_vacancy_date_posted"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $job_vacancies->SortUrl($job_vacancies->job_vacancy_date_posted) ?>',1);"><div id="elh_job_vacancies_job_vacancy_date_posted" class="job_vacancies_job_vacancy_date_posted">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_date_posted->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($job_vacancies->job_vacancy_date_posted->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($job_vacancies->job_vacancy_date_posted->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($job_vacancies->job_vacancy_expiry_date->Visible) { // job_vacancy_expiry_date ?>
	<?php if ($job_vacancies->SortUrl($job_vacancies->job_vacancy_expiry_date) == "") { ?>
		<th data-name="job_vacancy_expiry_date"><div id="elh_job_vacancies_job_vacancy_expiry_date" class="job_vacancies_job_vacancy_expiry_date"><div class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_expiry_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="job_vacancy_expiry_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $job_vacancies->SortUrl($job_vacancies->job_vacancy_expiry_date) ?>',1);"><div id="elh_job_vacancies_job_vacancy_expiry_date" class="job_vacancies_job_vacancy_expiry_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $job_vacancies->job_vacancy_expiry_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($job_vacancies->job_vacancy_expiry_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($job_vacancies->job_vacancy_expiry_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($job_vacancies->status->Visible) { // status ?>
	<?php if ($job_vacancies->SortUrl($job_vacancies->status) == "") { ?>
		<th data-name="status"><div id="elh_job_vacancies_status" class="job_vacancies_status"><div class="ewTableHeaderCaption"><?php echo $job_vacancies->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $job_vacancies->SortUrl($job_vacancies->status) ?>',1);"><div id="elh_job_vacancies_status" class="job_vacancies_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $job_vacancies->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($job_vacancies->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($job_vacancies->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$job_vacancies_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($job_vacancies->ExportAll && $job_vacancies->Export <> "") {
	$job_vacancies_list->StopRec = $job_vacancies_list->TotalRecs;
} else {

	// Set the last record to display
	if ($job_vacancies_list->TotalRecs > $job_vacancies_list->StartRec + $job_vacancies_list->DisplayRecs - 1)
		$job_vacancies_list->StopRec = $job_vacancies_list->StartRec + $job_vacancies_list->DisplayRecs - 1;
	else
		$job_vacancies_list->StopRec = $job_vacancies_list->TotalRecs;
}
$job_vacancies_list->RecCnt = $job_vacancies_list->StartRec - 1;
if ($job_vacancies_list->Recordset && !$job_vacancies_list->Recordset->EOF) {
	$job_vacancies_list->Recordset->MoveFirst();
	$bSelectLimit = $job_vacancies_list->UseSelectLimit;
	if (!$bSelectLimit && $job_vacancies_list->StartRec > 1)
		$job_vacancies_list->Recordset->Move($job_vacancies_list->StartRec - 1);
} elseif (!$job_vacancies->AllowAddDeleteRow && $job_vacancies_list->StopRec == 0) {
	$job_vacancies_list->StopRec = $job_vacancies->GridAddRowCount;
}

// Initialize aggregate
$job_vacancies->RowType = EW_ROWTYPE_AGGREGATEINIT;
$job_vacancies->ResetAttrs();
$job_vacancies_list->RenderRow();
while ($job_vacancies_list->RecCnt < $job_vacancies_list->StopRec) {
	$job_vacancies_list->RecCnt++;
	if (intval($job_vacancies_list->RecCnt) >= intval($job_vacancies_list->StartRec)) {
		$job_vacancies_list->RowCnt++;

		// Set up key count
		$job_vacancies_list->KeyCount = $job_vacancies_list->RowIndex;

		// Init row class and style
		$job_vacancies->ResetAttrs();
		$job_vacancies->CssClass = "";
		if ($job_vacancies->CurrentAction == "gridadd") {
		} else {
			$job_vacancies_list->LoadRowValues($job_vacancies_list->Recordset); // Load row values
		}
		$job_vacancies->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$job_vacancies->RowAttrs = array_merge($job_vacancies->RowAttrs, array('data-rowindex'=>$job_vacancies_list->RowCnt, 'id'=>'r' . $job_vacancies_list->RowCnt . '_job_vacancies', 'data-rowtype'=>$job_vacancies->RowType));

		// Render row
		$job_vacancies_list->RenderRow();

		// Render list options
		$job_vacancies_list->RenderListOptions();
?>
	<tr<?php echo $job_vacancies->RowAttributes() ?>>
<?php

// Render list options (body, left)
$job_vacancies_list->ListOptions->Render("body", "left", $job_vacancies_list->RowCnt);
?>
	<?php if ($job_vacancies->job_vacancy_id->Visible) { // job_vacancy_id ?>
		<td data-name="job_vacancy_id"<?php echo $job_vacancies->job_vacancy_id->CellAttributes() ?>>
<span id="el<?php echo $job_vacancies_list->RowCnt ?>_job_vacancies_job_vacancy_id" class="job_vacancies_job_vacancy_id">
<span<?php echo $job_vacancies->job_vacancy_id->ViewAttributes() ?>>
<?php echo $job_vacancies->job_vacancy_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $job_vacancies_list->PageObjName . "_row_" . $job_vacancies_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($job_vacancies->job_vacancy_title->Visible) { // job_vacancy_title ?>
		<td data-name="job_vacancy_title"<?php echo $job_vacancies->job_vacancy_title->CellAttributes() ?>>
<span id="el<?php echo $job_vacancies_list->RowCnt ?>_job_vacancies_job_vacancy_title" class="job_vacancies_job_vacancy_title">
<span<?php echo $job_vacancies->job_vacancy_title->ViewAttributes() ?>>
<?php echo $job_vacancies->job_vacancy_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($job_vacancies->job_vacancy_date_posted->Visible) { // job_vacancy_date_posted ?>
		<td data-name="job_vacancy_date_posted"<?php echo $job_vacancies->job_vacancy_date_posted->CellAttributes() ?>>
<span id="el<?php echo $job_vacancies_list->RowCnt ?>_job_vacancies_job_vacancy_date_posted" class="job_vacancies_job_vacancy_date_posted">
<span<?php echo $job_vacancies->job_vacancy_date_posted->ViewAttributes() ?>>
<?php echo $job_vacancies->job_vacancy_date_posted->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($job_vacancies->job_vacancy_expiry_date->Visible) { // job_vacancy_expiry_date ?>
		<td data-name="job_vacancy_expiry_date"<?php echo $job_vacancies->job_vacancy_expiry_date->CellAttributes() ?>>
<span id="el<?php echo $job_vacancies_list->RowCnt ?>_job_vacancies_job_vacancy_expiry_date" class="job_vacancies_job_vacancy_expiry_date">
<span<?php echo $job_vacancies->job_vacancy_expiry_date->ViewAttributes() ?>>
<?php echo $job_vacancies->job_vacancy_expiry_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($job_vacancies->status->Visible) { // status ?>
		<td data-name="status"<?php echo $job_vacancies->status->CellAttributes() ?>>
<span id="el<?php echo $job_vacancies_list->RowCnt ?>_job_vacancies_status" class="job_vacancies_status">
<span<?php echo $job_vacancies->status->ViewAttributes() ?>>
<?php echo $job_vacancies->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$job_vacancies_list->ListOptions->Render("body", "right", $job_vacancies_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($job_vacancies->CurrentAction <> "gridadd")
		$job_vacancies_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($job_vacancies->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($job_vacancies_list->Recordset)
	$job_vacancies_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($job_vacancies->CurrentAction <> "gridadd" && $job_vacancies->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($job_vacancies_list->Pager)) $job_vacancies_list->Pager = new cPrevNextPager($job_vacancies_list->StartRec, $job_vacancies_list->DisplayRecs, $job_vacancies_list->TotalRecs) ?>
<?php if ($job_vacancies_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($job_vacancies_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $job_vacancies_list->PageUrl() ?>start=<?php echo $job_vacancies_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($job_vacancies_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $job_vacancies_list->PageUrl() ?>start=<?php echo $job_vacancies_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $job_vacancies_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($job_vacancies_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $job_vacancies_list->PageUrl() ?>start=<?php echo $job_vacancies_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($job_vacancies_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $job_vacancies_list->PageUrl() ?>start=<?php echo $job_vacancies_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $job_vacancies_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $job_vacancies_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $job_vacancies_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $job_vacancies_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($job_vacancies_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($job_vacancies_list->TotalRecs == 0 && $job_vacancies->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($job_vacancies_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fjob_vacancieslistsrch.Init();
fjob_vacancieslistsrch.FilterList = <?php echo $job_vacancies_list->GetFilterList() ?>;
fjob_vacancieslist.Init();
</script>
<?php
$job_vacancies_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$job_vacancies_list->Page_Terminate();
?>
