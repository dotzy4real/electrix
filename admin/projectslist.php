<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "projectsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$projects_list = NULL; // Initialize page object first

class cprojects_list extends cprojects {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_list';

	// Grid form hidden field names
	var $FormName = 'fprojectslist';
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

		// Table object (projects)
		if (!isset($GLOBALS["projects"]) || get_class($GLOBALS["projects"]) == "cprojects") {
			$GLOBALS["projects"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["projects"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "projectsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "projectsdelete.php";
		$this->MultiUpdateUrl = "projectsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'projects', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fprojectslistsrch";

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
		$this->project_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $projects;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($projects);
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
			$this->project_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->project_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->project_id->AdvancedSearch->ToJSON(), ","); // Field project_id
		$sFilterList = ew_Concat($sFilterList, $this->project_title->AdvancedSearch->ToJSON(), ","); // Field project_title
		$sFilterList = ew_Concat($sFilterList, $this->project_small_pic->AdvancedSearch->ToJSON(), ","); // Field project_small_pic
		$sFilterList = ew_Concat($sFilterList, $this->project_pic->AdvancedSearch->ToJSON(), ","); // Field project_pic
		$sFilterList = ew_Concat($sFilterList, $this->project_content->AdvancedSearch->ToJSON(), ","); // Field project_content
		$sFilterList = ew_Concat($sFilterList, $this->project_category_id->AdvancedSearch->ToJSON(), ","); // Field project_category_id
		$sFilterList = ew_Concat($sFilterList, $this->project_date->AdvancedSearch->ToJSON(), ","); // Field project_date
		$sFilterList = ew_Concat($sFilterList, $this->project_client->AdvancedSearch->ToJSON(), ","); // Field project_client
		$sFilterList = ew_Concat($sFilterList, $this->project_location->AdvancedSearch->ToJSON(), ","); // Field project_location
		$sFilterList = ew_Concat($sFilterList, $this->sort_order->AdvancedSearch->ToJSON(), ","); // Field sort_order
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

		// Field project_id
		$this->project_id->AdvancedSearch->SearchValue = @$filter["x_project_id"];
		$this->project_id->AdvancedSearch->SearchOperator = @$filter["z_project_id"];
		$this->project_id->AdvancedSearch->SearchCondition = @$filter["v_project_id"];
		$this->project_id->AdvancedSearch->SearchValue2 = @$filter["y_project_id"];
		$this->project_id->AdvancedSearch->SearchOperator2 = @$filter["w_project_id"];
		$this->project_id->AdvancedSearch->Save();

		// Field project_title
		$this->project_title->AdvancedSearch->SearchValue = @$filter["x_project_title"];
		$this->project_title->AdvancedSearch->SearchOperator = @$filter["z_project_title"];
		$this->project_title->AdvancedSearch->SearchCondition = @$filter["v_project_title"];
		$this->project_title->AdvancedSearch->SearchValue2 = @$filter["y_project_title"];
		$this->project_title->AdvancedSearch->SearchOperator2 = @$filter["w_project_title"];
		$this->project_title->AdvancedSearch->Save();

		// Field project_small_pic
		$this->project_small_pic->AdvancedSearch->SearchValue = @$filter["x_project_small_pic"];
		$this->project_small_pic->AdvancedSearch->SearchOperator = @$filter["z_project_small_pic"];
		$this->project_small_pic->AdvancedSearch->SearchCondition = @$filter["v_project_small_pic"];
		$this->project_small_pic->AdvancedSearch->SearchValue2 = @$filter["y_project_small_pic"];
		$this->project_small_pic->AdvancedSearch->SearchOperator2 = @$filter["w_project_small_pic"];
		$this->project_small_pic->AdvancedSearch->Save();

		// Field project_pic
		$this->project_pic->AdvancedSearch->SearchValue = @$filter["x_project_pic"];
		$this->project_pic->AdvancedSearch->SearchOperator = @$filter["z_project_pic"];
		$this->project_pic->AdvancedSearch->SearchCondition = @$filter["v_project_pic"];
		$this->project_pic->AdvancedSearch->SearchValue2 = @$filter["y_project_pic"];
		$this->project_pic->AdvancedSearch->SearchOperator2 = @$filter["w_project_pic"];
		$this->project_pic->AdvancedSearch->Save();

		// Field project_content
		$this->project_content->AdvancedSearch->SearchValue = @$filter["x_project_content"];
		$this->project_content->AdvancedSearch->SearchOperator = @$filter["z_project_content"];
		$this->project_content->AdvancedSearch->SearchCondition = @$filter["v_project_content"];
		$this->project_content->AdvancedSearch->SearchValue2 = @$filter["y_project_content"];
		$this->project_content->AdvancedSearch->SearchOperator2 = @$filter["w_project_content"];
		$this->project_content->AdvancedSearch->Save();

		// Field project_category_id
		$this->project_category_id->AdvancedSearch->SearchValue = @$filter["x_project_category_id"];
		$this->project_category_id->AdvancedSearch->SearchOperator = @$filter["z_project_category_id"];
		$this->project_category_id->AdvancedSearch->SearchCondition = @$filter["v_project_category_id"];
		$this->project_category_id->AdvancedSearch->SearchValue2 = @$filter["y_project_category_id"];
		$this->project_category_id->AdvancedSearch->SearchOperator2 = @$filter["w_project_category_id"];
		$this->project_category_id->AdvancedSearch->Save();

		// Field project_date
		$this->project_date->AdvancedSearch->SearchValue = @$filter["x_project_date"];
		$this->project_date->AdvancedSearch->SearchOperator = @$filter["z_project_date"];
		$this->project_date->AdvancedSearch->SearchCondition = @$filter["v_project_date"];
		$this->project_date->AdvancedSearch->SearchValue2 = @$filter["y_project_date"];
		$this->project_date->AdvancedSearch->SearchOperator2 = @$filter["w_project_date"];
		$this->project_date->AdvancedSearch->Save();

		// Field project_client
		$this->project_client->AdvancedSearch->SearchValue = @$filter["x_project_client"];
		$this->project_client->AdvancedSearch->SearchOperator = @$filter["z_project_client"];
		$this->project_client->AdvancedSearch->SearchCondition = @$filter["v_project_client"];
		$this->project_client->AdvancedSearch->SearchValue2 = @$filter["y_project_client"];
		$this->project_client->AdvancedSearch->SearchOperator2 = @$filter["w_project_client"];
		$this->project_client->AdvancedSearch->Save();

		// Field project_location
		$this->project_location->AdvancedSearch->SearchValue = @$filter["x_project_location"];
		$this->project_location->AdvancedSearch->SearchOperator = @$filter["z_project_location"];
		$this->project_location->AdvancedSearch->SearchCondition = @$filter["v_project_location"];
		$this->project_location->AdvancedSearch->SearchValue2 = @$filter["y_project_location"];
		$this->project_location->AdvancedSearch->SearchOperator2 = @$filter["w_project_location"];
		$this->project_location->AdvancedSearch->Save();

		// Field sort_order
		$this->sort_order->AdvancedSearch->SearchValue = @$filter["x_sort_order"];
		$this->sort_order->AdvancedSearch->SearchOperator = @$filter["z_sort_order"];
		$this->sort_order->AdvancedSearch->SearchCondition = @$filter["v_sort_order"];
		$this->sort_order->AdvancedSearch->SearchValue2 = @$filter["y_sort_order"];
		$this->sort_order->AdvancedSearch->SearchOperator2 = @$filter["w_sort_order"];
		$this->sort_order->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->project_id, $Default, FALSE); // project_id
		$this->BuildSearchSql($sWhere, $this->project_title, $Default, FALSE); // project_title
		$this->BuildSearchSql($sWhere, $this->project_small_pic, $Default, FALSE); // project_small_pic
		$this->BuildSearchSql($sWhere, $this->project_pic, $Default, FALSE); // project_pic
		$this->BuildSearchSql($sWhere, $this->project_content, $Default, FALSE); // project_content
		$this->BuildSearchSql($sWhere, $this->project_category_id, $Default, FALSE); // project_category_id
		$this->BuildSearchSql($sWhere, $this->project_date, $Default, FALSE); // project_date
		$this->BuildSearchSql($sWhere, $this->project_client, $Default, FALSE); // project_client
		$this->BuildSearchSql($sWhere, $this->project_location, $Default, FALSE); // project_location
		$this->BuildSearchSql($sWhere, $this->sort_order, $Default, FALSE); // sort_order
		$this->BuildSearchSql($sWhere, $this->status, $Default, FALSE); // status

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->project_id->AdvancedSearch->Save(); // project_id
			$this->project_title->AdvancedSearch->Save(); // project_title
			$this->project_small_pic->AdvancedSearch->Save(); // project_small_pic
			$this->project_pic->AdvancedSearch->Save(); // project_pic
			$this->project_content->AdvancedSearch->Save(); // project_content
			$this->project_category_id->AdvancedSearch->Save(); // project_category_id
			$this->project_date->AdvancedSearch->Save(); // project_date
			$this->project_client->AdvancedSearch->Save(); // project_client
			$this->project_location->AdvancedSearch->Save(); // project_location
			$this->sort_order->AdvancedSearch->Save(); // sort_order
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
		$this->BuildBasicSearchSQL($sWhere, $this->project_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_small_pic, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_pic, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_content, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_date, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_client, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_location, $arKeywords, $type);
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
		if ($this->project_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_small_pic->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_pic->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_content->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_category_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_client->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->project_location->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sort_order->AdvancedSearch->IssetSession())
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
		$this->project_id->AdvancedSearch->UnsetSession();
		$this->project_title->AdvancedSearch->UnsetSession();
		$this->project_small_pic->AdvancedSearch->UnsetSession();
		$this->project_pic->AdvancedSearch->UnsetSession();
		$this->project_content->AdvancedSearch->UnsetSession();
		$this->project_category_id->AdvancedSearch->UnsetSession();
		$this->project_date->AdvancedSearch->UnsetSession();
		$this->project_client->AdvancedSearch->UnsetSession();
		$this->project_location->AdvancedSearch->UnsetSession();
		$this->sort_order->AdvancedSearch->UnsetSession();
		$this->status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->project_id->AdvancedSearch->Load();
		$this->project_title->AdvancedSearch->Load();
		$this->project_small_pic->AdvancedSearch->Load();
		$this->project_pic->AdvancedSearch->Load();
		$this->project_content->AdvancedSearch->Load();
		$this->project_category_id->AdvancedSearch->Load();
		$this->project_date->AdvancedSearch->Load();
		$this->project_client->AdvancedSearch->Load();
		$this->project_location->AdvancedSearch->Load();
		$this->sort_order->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->project_id); // project_id
			$this->UpdateSort($this->project_title); // project_title
			$this->UpdateSort($this->project_small_pic); // project_small_pic
			$this->UpdateSort($this->project_pic); // project_pic
			$this->UpdateSort($this->project_category_id); // project_category_id
			$this->UpdateSort($this->project_date); // project_date
			$this->UpdateSort($this->project_client); // project_client
			$this->UpdateSort($this->project_location); // project_location
			$this->UpdateSort($this->sort_order); // sort_order
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
				$this->project_id->setSort("");
				$this->project_title->setSort("");
				$this->project_small_pic->setSort("");
				$this->project_pic->setSort("");
				$this->project_category_id->setSort("");
				$this->project_date->setSort("");
				$this->project_client->setSort("");
				$this->project_location->setSort("");
				$this->sort_order->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->project_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fprojectslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fprojectslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fprojectslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fprojectslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		// project_id

		$this->project_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_id"]);
		if ($this->project_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_id->AdvancedSearch->SearchOperator = @$_GET["z_project_id"];

		// project_title
		$this->project_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_title"]);
		if ($this->project_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_title->AdvancedSearch->SearchOperator = @$_GET["z_project_title"];

		// project_small_pic
		$this->project_small_pic->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_small_pic"]);
		if ($this->project_small_pic->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_small_pic->AdvancedSearch->SearchOperator = @$_GET["z_project_small_pic"];

		// project_pic
		$this->project_pic->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_pic"]);
		if ($this->project_pic->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_pic->AdvancedSearch->SearchOperator = @$_GET["z_project_pic"];

		// project_content
		$this->project_content->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_content"]);
		if ($this->project_content->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_content->AdvancedSearch->SearchOperator = @$_GET["z_project_content"];

		// project_category_id
		$this->project_category_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_category_id"]);
		if ($this->project_category_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_category_id->AdvancedSearch->SearchOperator = @$_GET["z_project_category_id"];

		// project_date
		$this->project_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_date"]);
		if ($this->project_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_date->AdvancedSearch->SearchOperator = @$_GET["z_project_date"];

		// project_client
		$this->project_client->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_client"]);
		if ($this->project_client->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_client->AdvancedSearch->SearchOperator = @$_GET["z_project_client"];

		// project_location
		$this->project_location->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_project_location"]);
		if ($this->project_location->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->project_location->AdvancedSearch->SearchOperator = @$_GET["z_project_location"];

		// sort_order
		$this->sort_order->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_sort_order"]);
		if ($this->sort_order->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->sort_order->AdvancedSearch->SearchOperator = @$_GET["z_sort_order"];

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
		$this->project_id->setDbValue($rs->fields('project_id'));
		$this->project_title->setDbValue($rs->fields('project_title'));
		$this->project_small_pic->Upload->DbValue = $rs->fields('project_small_pic');
		$this->project_small_pic->CurrentValue = $this->project_small_pic->Upload->DbValue;
		$this->project_pic->Upload->DbValue = $rs->fields('project_pic');
		$this->project_pic->CurrentValue = $this->project_pic->Upload->DbValue;
		$this->project_content->setDbValue($rs->fields('project_content'));
		$this->project_category_id->setDbValue($rs->fields('project_category_id'));
		$this->project_date->setDbValue($rs->fields('project_date'));
		$this->project_client->setDbValue($rs->fields('project_client'));
		$this->project_location->setDbValue($rs->fields('project_location'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->project_id->DbValue = $row['project_id'];
		$this->project_title->DbValue = $row['project_title'];
		$this->project_small_pic->Upload->DbValue = $row['project_small_pic'];
		$this->project_pic->Upload->DbValue = $row['project_pic'];
		$this->project_content->DbValue = $row['project_content'];
		$this->project_category_id->DbValue = $row['project_category_id'];
		$this->project_date->DbValue = $row['project_date'];
		$this->project_client->DbValue = $row['project_client'];
		$this->project_location->DbValue = $row['project_location'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("project_id")) <> "")
			$this->project_id->CurrentValue = $this->getKey("project_id"); // project_id
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
		// project_id
		// project_title
		// project_small_pic
		// project_pic
		// project_content
		// project_category_id
		// project_date
		// project_client
		// project_location
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// project_id
		$this->project_id->ViewValue = $this->project_id->CurrentValue;
		$this->project_id->ViewCustomAttributes = "";

		// project_title
		$this->project_title->ViewValue = $this->project_title->CurrentValue;
		$this->project_title->ViewCustomAttributes = "";

		// project_small_pic
		$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
			$this->project_small_pic->ImageWidth = 100;
			$this->project_small_pic->ImageHeight = 120;
			$this->project_small_pic->ImageAlt = $this->project_small_pic->FldAlt();
			$this->project_small_pic->ViewValue = $this->project_small_pic->Upload->DbValue;
		} else {
			$this->project_small_pic->ViewValue = "";
		}
		$this->project_small_pic->CssStyle = "font-style: italic;";
		$this->project_small_pic->ViewCustomAttributes = "";

		// project_pic
		$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
		if (!ew_Empty($this->project_pic->Upload->DbValue)) {
			$this->project_pic->ImageWidth = 120;
			$this->project_pic->ImageHeight = 45;
			$this->project_pic->ImageAlt = $this->project_pic->FldAlt();
			$this->project_pic->ViewValue = $this->project_pic->Upload->DbValue;
		} else {
			$this->project_pic->ViewValue = "";
		}
		$this->project_pic->ViewCustomAttributes = "";

		// project_category_id
		if (strval($this->project_category_id->CurrentValue) <> "") {
			$sFilterWrk = "`project_category_id`" . ew_SearchString("=", $this->project_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `project_category_id`, `project_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `project_categories`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->project_category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->project_category_id->ViewValue = $this->project_category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->project_category_id->ViewValue = $this->project_category_id->CurrentValue;
			}
		} else {
			$this->project_category_id->ViewValue = NULL;
		}
		$this->project_category_id->ViewCustomAttributes = "";

		// project_date
		$this->project_date->ViewValue = $this->project_date->CurrentValue;
		$this->project_date->ViewCustomAttributes = "";

		// project_client
		$this->project_client->ViewValue = $this->project_client->CurrentValue;
		$this->project_client->ViewCustomAttributes = "";

		// project_location
		$this->project_location->ViewValue = $this->project_location->CurrentValue;
		$this->project_location->ViewCustomAttributes = "";

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

			// project_id
			$this->project_id->LinkCustomAttributes = "";
			$this->project_id->HrefValue = "";
			$this->project_id->TooltipValue = "";

			// project_title
			$this->project_title->LinkCustomAttributes = "";
			$this->project_title->HrefValue = "";
			$this->project_title->TooltipValue = "";

			// project_small_pic
			$this->project_small_pic->LinkCustomAttributes = "";
			$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
			if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
				$this->project_small_pic->HrefValue = ew_GetFileUploadUrl($this->project_small_pic, $this->project_small_pic->Upload->DbValue); // Add prefix/suffix
				$this->project_small_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->project_small_pic->HrefValue = ew_ConvertFullUrl($this->project_small_pic->HrefValue);
			} else {
				$this->project_small_pic->HrefValue = "";
			}
			$this->project_small_pic->HrefValue2 = $this->project_small_pic->UploadPath . $this->project_small_pic->Upload->DbValue;
			$this->project_small_pic->TooltipValue = "";
			if ($this->project_small_pic->UseColorbox) {
				$this->project_small_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->project_small_pic->LinkAttrs["data-rel"] = "projects_x" . $this->RowCnt . "_project_small_pic";

				//$this->project_small_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->project_small_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->project_small_pic->LinkAttrs["data-container"] = "body";

				$this->project_small_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// project_pic
			$this->project_pic->LinkCustomAttributes = "";
			$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
			if (!ew_Empty($this->project_pic->Upload->DbValue)) {
				$this->project_pic->HrefValue = ew_GetFileUploadUrl($this->project_pic, $this->project_pic->Upload->DbValue); // Add prefix/suffix
				$this->project_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->project_pic->HrefValue = ew_ConvertFullUrl($this->project_pic->HrefValue);
			} else {
				$this->project_pic->HrefValue = "";
			}
			$this->project_pic->HrefValue2 = $this->project_pic->UploadPath . $this->project_pic->Upload->DbValue;
			$this->project_pic->TooltipValue = "";
			if ($this->project_pic->UseColorbox) {
				$this->project_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->project_pic->LinkAttrs["data-rel"] = "projects_x" . $this->RowCnt . "_project_pic";

				//$this->project_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->project_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->project_pic->LinkAttrs["data-container"] = "body";

				$this->project_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// project_category_id
			$this->project_category_id->LinkCustomAttributes = "";
			$this->project_category_id->HrefValue = "";
			$this->project_category_id->TooltipValue = "";

			// project_date
			$this->project_date->LinkCustomAttributes = "";
			$this->project_date->HrefValue = "";
			$this->project_date->TooltipValue = "";

			// project_client
			$this->project_client->LinkCustomAttributes = "";
			$this->project_client->HrefValue = "";
			$this->project_client->TooltipValue = "";

			// project_location
			$this->project_location->LinkCustomAttributes = "";
			$this->project_location->HrefValue = "";
			$this->project_location->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// project_id
			$this->project_id->EditAttrs["class"] = "form-control";
			$this->project_id->EditCustomAttributes = "";
			$this->project_id->EditValue = ew_HtmlEncode($this->project_id->AdvancedSearch->SearchValue);
			$this->project_id->PlaceHolder = ew_RemoveHtml($this->project_id->FldCaption());

			// project_title
			$this->project_title->EditAttrs["class"] = "form-control";
			$this->project_title->EditCustomAttributes = "";
			$this->project_title->EditValue = ew_HtmlEncode($this->project_title->AdvancedSearch->SearchValue);
			$this->project_title->PlaceHolder = ew_RemoveHtml($this->project_title->FldCaption());

			// project_small_pic
			$this->project_small_pic->EditAttrs["class"] = "form-control";
			$this->project_small_pic->EditCustomAttributes = "";
			$this->project_small_pic->EditValue = ew_HtmlEncode($this->project_small_pic->AdvancedSearch->SearchValue);
			$this->project_small_pic->PlaceHolder = ew_RemoveHtml($this->project_small_pic->FldCaption());

			// project_pic
			$this->project_pic->EditAttrs["class"] = "form-control";
			$this->project_pic->EditCustomAttributes = "";
			$this->project_pic->EditValue = ew_HtmlEncode($this->project_pic->AdvancedSearch->SearchValue);
			$this->project_pic->PlaceHolder = ew_RemoveHtml($this->project_pic->FldCaption());

			// project_category_id
			$this->project_category_id->EditAttrs["class"] = "form-control";
			$this->project_category_id->EditCustomAttributes = "";

			// project_date
			$this->project_date->EditAttrs["class"] = "form-control";
			$this->project_date->EditCustomAttributes = "";
			$this->project_date->EditValue = ew_HtmlEncode($this->project_date->AdvancedSearch->SearchValue);
			$this->project_date->PlaceHolder = ew_RemoveHtml($this->project_date->FldCaption());

			// project_client
			$this->project_client->EditAttrs["class"] = "form-control";
			$this->project_client->EditCustomAttributes = "";
			$this->project_client->EditValue = ew_HtmlEncode($this->project_client->AdvancedSearch->SearchValue);
			$this->project_client->PlaceHolder = ew_RemoveHtml($this->project_client->FldCaption());

			// project_location
			$this->project_location->EditAttrs["class"] = "form-control";
			$this->project_location->EditCustomAttributes = "";
			$this->project_location->EditValue = ew_HtmlEncode($this->project_location->AdvancedSearch->SearchValue);
			$this->project_location->PlaceHolder = ew_RemoveHtml($this->project_location->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->AdvancedSearch->SearchValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

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
		$this->project_id->AdvancedSearch->Load();
		$this->project_title->AdvancedSearch->Load();
		$this->project_small_pic->AdvancedSearch->Load();
		$this->project_pic->AdvancedSearch->Load();
		$this->project_content->AdvancedSearch->Load();
		$this->project_category_id->AdvancedSearch->Load();
		$this->project_date->AdvancedSearch->Load();
		$this->project_client->AdvancedSearch->Load();
		$this->project_location->AdvancedSearch->Load();
		$this->sort_order->AdvancedSearch->Load();
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
if (!isset($projects_list)) $projects_list = new cprojects_list();

// Page init
$projects_list->Page_Init();

// Page main
$projects_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fprojectslist = new ew_Form("fprojectslist", "list");
fprojectslist.FormKeyCountName = '<?php echo $projects_list->FormKeyCountName ?>';

// Form_CustomValidate event
fprojectslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectslist.ValidateRequired = true;
<?php } else { ?>
fprojectslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fprojectslist.Lists["x_project_category_id"] = {"LinkField":"x_project_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_project_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectslist.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectslist.Lists["x_status"].Options = <?php echo json_encode($projects->status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fprojectslistsrch = new ew_Form("fprojectslistsrch");

// Validate function for search
fprojectslistsrch.Validate = function(fobj) {
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
fprojectslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fprojectslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fprojectslistsrch.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectslistsrch.Lists["x_status"].Options = <?php echo json_encode($projects->status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($projects_list->TotalRecs > 0 && $projects_list->ExportOptions->Visible()) { ?>
<?php $projects_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($projects_list->SearchOptions->Visible()) { ?>
<?php $projects_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($projects_list->FilterOptions->Visible()) { ?>
<?php $projects_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $projects_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($projects_list->TotalRecs <= 0)
			$projects_list->TotalRecs = $projects->SelectRecordCount();
	} else {
		if (!$projects_list->Recordset && ($projects_list->Recordset = $projects_list->LoadRecordset()))
			$projects_list->TotalRecs = $projects_list->Recordset->RecordCount();
	}
	$projects_list->StartRec = 1;
	if ($projects_list->DisplayRecs <= 0 || ($projects->Export <> "" && $projects->ExportAll)) // Display all records
		$projects_list->DisplayRecs = $projects_list->TotalRecs;
	if (!($projects->Export <> "" && $projects->ExportAll))
		$projects_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$projects_list->Recordset = $projects_list->LoadRecordset($projects_list->StartRec-1, $projects_list->DisplayRecs);

	// Set no record found message
	if ($projects->CurrentAction == "" && $projects_list->TotalRecs == 0) {
		if ($projects_list->SearchWhere == "0=101")
			$projects_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$projects_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$projects_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($projects->Export == "" && $projects->CurrentAction == "") { ?>
<form name="fprojectslistsrch" id="fprojectslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($projects_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fprojectslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="projects">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$projects_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$projects->RowType = EW_ROWTYPE_SEARCH;

// Render row
$projects->ResetAttrs();
$projects_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($projects->status->Visible) { // status ?>
	<div id="xsc_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $projects->status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status" id="z_status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="projects" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($projects->status->DisplayValueSeparator) ? json_encode($projects->status->DisplayValueSeparator) : $projects->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $projects->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $projects->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($projects->status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="projects" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $projects->status->EditAttributes() ?>><?php echo $projects->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($projects->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="projects" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($projects->status->CurrentValue) ?>" checked<?php echo $projects->status->EditAttributes() ?>><?php echo $projects->status->CurrentValue ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($projects_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($projects_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $projects_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($projects_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($projects_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($projects_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($projects_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $projects_list->ShowPageHeader(); ?>
<?php
$projects_list->ShowMessage();
?>
<?php if ($projects_list->TotalRecs > 0 || $projects->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="fprojectslist" id="fprojectslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<div id="gmp_projects" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($projects_list->TotalRecs > 0) { ?>
<table id="tbl_projectslist" class="table ewTable">
<?php echo $projects->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$projects_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$projects_list->RenderListOptions();

// Render list options (header, left)
$projects_list->ListOptions->Render("header", "left");
?>
<?php if ($projects->project_id->Visible) { // project_id ?>
	<?php if ($projects->SortUrl($projects->project_id) == "") { ?>
		<th data-name="project_id"><div id="elh_projects_project_id" class="projects_project_id"><div class="ewTableHeaderCaption"><?php echo $projects->project_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_id) ?>',1);"><div id="elh_projects_project_id" class="projects_project_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_title->Visible) { // project_title ?>
	<?php if ($projects->SortUrl($projects->project_title) == "") { ?>
		<th data-name="project_title"><div id="elh_projects_project_title" class="projects_project_title"><div class="ewTableHeaderCaption"><?php echo $projects->project_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_title) ?>',1);"><div id="elh_projects_project_title" class="projects_project_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_small_pic->Visible) { // project_small_pic ?>
	<?php if ($projects->SortUrl($projects->project_small_pic) == "") { ?>
		<th data-name="project_small_pic"><div id="elh_projects_project_small_pic" class="projects_project_small_pic"><div class="ewTableHeaderCaption"><?php echo $projects->project_small_pic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_small_pic"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_small_pic) ?>',1);"><div id="elh_projects_project_small_pic" class="projects_project_small_pic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_small_pic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_small_pic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_small_pic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_pic->Visible) { // project_pic ?>
	<?php if ($projects->SortUrl($projects->project_pic) == "") { ?>
		<th data-name="project_pic"><div id="elh_projects_project_pic" class="projects_project_pic"><div class="ewTableHeaderCaption"><?php echo $projects->project_pic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_pic"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_pic) ?>',1);"><div id="elh_projects_project_pic" class="projects_project_pic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_pic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_pic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_pic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_category_id->Visible) { // project_category_id ?>
	<?php if ($projects->SortUrl($projects->project_category_id) == "") { ?>
		<th data-name="project_category_id"><div id="elh_projects_project_category_id" class="projects_project_category_id"><div class="ewTableHeaderCaption"><?php echo $projects->project_category_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_category_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_category_id) ?>',1);"><div id="elh_projects_project_category_id" class="projects_project_category_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_category_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_category_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_category_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_date->Visible) { // project_date ?>
	<?php if ($projects->SortUrl($projects->project_date) == "") { ?>
		<th data-name="project_date"><div id="elh_projects_project_date" class="projects_project_date"><div class="ewTableHeaderCaption"><?php echo $projects->project_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_date) ?>',1);"><div id="elh_projects_project_date" class="projects_project_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_date->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_client->Visible) { // project_client ?>
	<?php if ($projects->SortUrl($projects->project_client) == "") { ?>
		<th data-name="project_client"><div id="elh_projects_project_client" class="projects_project_client"><div class="ewTableHeaderCaption"><?php echo $projects->project_client->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_client"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_client) ?>',1);"><div id="elh_projects_project_client" class="projects_project_client">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_client->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_client->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_client->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->project_location->Visible) { // project_location ?>
	<?php if ($projects->SortUrl($projects->project_location) == "") { ?>
		<th data-name="project_location"><div id="elh_projects_project_location" class="projects_project_location"><div class="ewTableHeaderCaption"><?php echo $projects->project_location->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="project_location"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->project_location) ?>',1);"><div id="elh_projects_project_location" class="projects_project_location">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->project_location->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->project_location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->project_location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->sort_order->Visible) { // sort_order ?>
	<?php if ($projects->SortUrl($projects->sort_order) == "") { ?>
		<th data-name="sort_order"><div id="elh_projects_sort_order" class="projects_sort_order"><div class="ewTableHeaderCaption"><?php echo $projects->sort_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sort_order"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->sort_order) ?>',1);"><div id="elh_projects_sort_order" class="projects_sort_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->sort_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->sort_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->sort_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->status->Visible) { // status ?>
	<?php if ($projects->SortUrl($projects->status) == "") { ?>
		<th data-name="status"><div id="elh_projects_status" class="projects_status"><div class="ewTableHeaderCaption"><?php echo $projects->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->status) ?>',1);"><div id="elh_projects_status" class="projects_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$projects_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($projects->ExportAll && $projects->Export <> "") {
	$projects_list->StopRec = $projects_list->TotalRecs;
} else {

	// Set the last record to display
	if ($projects_list->TotalRecs > $projects_list->StartRec + $projects_list->DisplayRecs - 1)
		$projects_list->StopRec = $projects_list->StartRec + $projects_list->DisplayRecs - 1;
	else
		$projects_list->StopRec = $projects_list->TotalRecs;
}
$projects_list->RecCnt = $projects_list->StartRec - 1;
if ($projects_list->Recordset && !$projects_list->Recordset->EOF) {
	$projects_list->Recordset->MoveFirst();
	$bSelectLimit = $projects_list->UseSelectLimit;
	if (!$bSelectLimit && $projects_list->StartRec > 1)
		$projects_list->Recordset->Move($projects_list->StartRec - 1);
} elseif (!$projects->AllowAddDeleteRow && $projects_list->StopRec == 0) {
	$projects_list->StopRec = $projects->GridAddRowCount;
}

// Initialize aggregate
$projects->RowType = EW_ROWTYPE_AGGREGATEINIT;
$projects->ResetAttrs();
$projects_list->RenderRow();
while ($projects_list->RecCnt < $projects_list->StopRec) {
	$projects_list->RecCnt++;
	if (intval($projects_list->RecCnt) >= intval($projects_list->StartRec)) {
		$projects_list->RowCnt++;

		// Set up key count
		$projects_list->KeyCount = $projects_list->RowIndex;

		// Init row class and style
		$projects->ResetAttrs();
		$projects->CssClass = "";
		if ($projects->CurrentAction == "gridadd") {
		} else {
			$projects_list->LoadRowValues($projects_list->Recordset); // Load row values
		}
		$projects->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$projects->RowAttrs = array_merge($projects->RowAttrs, array('data-rowindex'=>$projects_list->RowCnt, 'id'=>'r' . $projects_list->RowCnt . '_projects', 'data-rowtype'=>$projects->RowType));

		// Render row
		$projects_list->RenderRow();

		// Render list options
		$projects_list->RenderListOptions();
?>
	<tr<?php echo $projects->RowAttributes() ?>>
<?php

// Render list options (body, left)
$projects_list->ListOptions->Render("body", "left", $projects_list->RowCnt);
?>
	<?php if ($projects->project_id->Visible) { // project_id ?>
		<td data-name="project_id"<?php echo $projects->project_id->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_id" class="projects_project_id">
<span<?php echo $projects->project_id->ViewAttributes() ?>>
<?php echo $projects->project_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $projects_list->PageObjName . "_row_" . $projects_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($projects->project_title->Visible) { // project_title ?>
		<td data-name="project_title"<?php echo $projects->project_title->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_title" class="projects_project_title">
<span<?php echo $projects->project_title->ViewAttributes() ?>>
<?php echo $projects->project_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->project_small_pic->Visible) { // project_small_pic ?>
		<td data-name="project_small_pic"<?php echo $projects->project_small_pic->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_small_pic" class="projects_project_small_pic">
<span>
<?php echo ew_GetFileViewTag($projects->project_small_pic, $projects->project_small_pic->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->project_pic->Visible) { // project_pic ?>
		<td data-name="project_pic"<?php echo $projects->project_pic->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_pic" class="projects_project_pic">
<span>
<?php echo ew_GetFileViewTag($projects->project_pic, $projects->project_pic->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->project_category_id->Visible) { // project_category_id ?>
		<td data-name="project_category_id"<?php echo $projects->project_category_id->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_category_id" class="projects_project_category_id">
<span<?php echo $projects->project_category_id->ViewAttributes() ?>>
<?php echo $projects->project_category_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->project_date->Visible) { // project_date ?>
		<td data-name="project_date"<?php echo $projects->project_date->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_date" class="projects_project_date">
<span<?php echo $projects->project_date->ViewAttributes() ?>>
<?php echo $projects->project_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->project_client->Visible) { // project_client ?>
		<td data-name="project_client"<?php echo $projects->project_client->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_client" class="projects_project_client">
<span<?php echo $projects->project_client->ViewAttributes() ?>>
<?php echo $projects->project_client->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->project_location->Visible) { // project_location ?>
		<td data-name="project_location"<?php echo $projects->project_location->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_project_location" class="projects_project_location">
<span<?php echo $projects->project_location->ViewAttributes() ?>>
<?php echo $projects->project_location->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->sort_order->Visible) { // sort_order ?>
		<td data-name="sort_order"<?php echo $projects->sort_order->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_sort_order" class="projects_sort_order">
<span<?php echo $projects->sort_order->ViewAttributes() ?>>
<?php echo $projects->sort_order->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->status->Visible) { // status ?>
		<td data-name="status"<?php echo $projects->status->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_status" class="projects_status">
<span<?php echo $projects->status->ViewAttributes() ?>>
<?php echo $projects->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$projects_list->ListOptions->Render("body", "right", $projects_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($projects->CurrentAction <> "gridadd")
		$projects_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($projects->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($projects_list->Recordset)
	$projects_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($projects->CurrentAction <> "gridadd" && $projects->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($projects_list->Pager)) $projects_list->Pager = new cPrevNextPager($projects_list->StartRec, $projects_list->DisplayRecs, $projects_list->TotalRecs) ?>
<?php if ($projects_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($projects_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($projects_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $projects_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($projects_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($projects_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $projects_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $projects_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $projects_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $projects_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($projects_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($projects_list->TotalRecs == 0 && $projects->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($projects_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fprojectslistsrch.Init();
fprojectslistsrch.FilterList = <?php echo $projects_list->GetFilterList() ?>;
fprojectslist.Init();
</script>
<?php
$projects_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$projects_list->Page_Terminate();
?>
