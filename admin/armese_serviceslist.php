<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "armese_servicesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$armese_services_list = NULL; // Initialize page object first

class carmese_services_list extends carmese_services {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'armese_services';

	// Page object name
	var $PageObjName = 'armese_services_list';

	// Grid form hidden field names
	var $FormName = 'farmese_serviceslist';
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

		// Table object (armese_services)
		if (!isset($GLOBALS["armese_services"]) || get_class($GLOBALS["armese_services"]) == "carmese_services") {
			$GLOBALS["armese_services"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["armese_services"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "armese_servicesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "armese_servicesdelete.php";
		$this->MultiUpdateUrl = "armese_servicesupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'armese_services', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption farmese_serviceslistsrch";

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
		$this->armese_service_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $armese_services;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($armese_services);
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
			$this->armese_service_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->armese_service_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->armese_service_id->AdvancedSearch->ToJSON(), ","); // Field armese_service_id
		$sFilterList = ew_Concat($sFilterList, $this->armese_service_title->AdvancedSearch->ToJSON(), ","); // Field armese_service_title
		$sFilterList = ew_Concat($sFilterList, $this->armese_service_snippet->AdvancedSearch->ToJSON(), ","); // Field armese_service_snippet
		$sFilterList = ew_Concat($sFilterList, $this->armese_service_pic->AdvancedSearch->ToJSON(), ","); // Field armese_service_pic
		$sFilterList = ew_Concat($sFilterList, $this->armese_service_icon->AdvancedSearch->ToJSON(), ","); // Field armese_service_icon
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

		// Field armese_service_id
		$this->armese_service_id->AdvancedSearch->SearchValue = @$filter["x_armese_service_id"];
		$this->armese_service_id->AdvancedSearch->SearchOperator = @$filter["z_armese_service_id"];
		$this->armese_service_id->AdvancedSearch->SearchCondition = @$filter["v_armese_service_id"];
		$this->armese_service_id->AdvancedSearch->SearchValue2 = @$filter["y_armese_service_id"];
		$this->armese_service_id->AdvancedSearch->SearchOperator2 = @$filter["w_armese_service_id"];
		$this->armese_service_id->AdvancedSearch->Save();

		// Field armese_service_title
		$this->armese_service_title->AdvancedSearch->SearchValue = @$filter["x_armese_service_title"];
		$this->armese_service_title->AdvancedSearch->SearchOperator = @$filter["z_armese_service_title"];
		$this->armese_service_title->AdvancedSearch->SearchCondition = @$filter["v_armese_service_title"];
		$this->armese_service_title->AdvancedSearch->SearchValue2 = @$filter["y_armese_service_title"];
		$this->armese_service_title->AdvancedSearch->SearchOperator2 = @$filter["w_armese_service_title"];
		$this->armese_service_title->AdvancedSearch->Save();

		// Field armese_service_snippet
		$this->armese_service_snippet->AdvancedSearch->SearchValue = @$filter["x_armese_service_snippet"];
		$this->armese_service_snippet->AdvancedSearch->SearchOperator = @$filter["z_armese_service_snippet"];
		$this->armese_service_snippet->AdvancedSearch->SearchCondition = @$filter["v_armese_service_snippet"];
		$this->armese_service_snippet->AdvancedSearch->SearchValue2 = @$filter["y_armese_service_snippet"];
		$this->armese_service_snippet->AdvancedSearch->SearchOperator2 = @$filter["w_armese_service_snippet"];
		$this->armese_service_snippet->AdvancedSearch->Save();

		// Field armese_service_pic
		$this->armese_service_pic->AdvancedSearch->SearchValue = @$filter["x_armese_service_pic"];
		$this->armese_service_pic->AdvancedSearch->SearchOperator = @$filter["z_armese_service_pic"];
		$this->armese_service_pic->AdvancedSearch->SearchCondition = @$filter["v_armese_service_pic"];
		$this->armese_service_pic->AdvancedSearch->SearchValue2 = @$filter["y_armese_service_pic"];
		$this->armese_service_pic->AdvancedSearch->SearchOperator2 = @$filter["w_armese_service_pic"];
		$this->armese_service_pic->AdvancedSearch->Save();

		// Field armese_service_icon
		$this->armese_service_icon->AdvancedSearch->SearchValue = @$filter["x_armese_service_icon"];
		$this->armese_service_icon->AdvancedSearch->SearchOperator = @$filter["z_armese_service_icon"];
		$this->armese_service_icon->AdvancedSearch->SearchCondition = @$filter["v_armese_service_icon"];
		$this->armese_service_icon->AdvancedSearch->SearchValue2 = @$filter["y_armese_service_icon"];
		$this->armese_service_icon->AdvancedSearch->SearchOperator2 = @$filter["w_armese_service_icon"];
		$this->armese_service_icon->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->armese_service_id, $Default, FALSE); // armese_service_id
		$this->BuildSearchSql($sWhere, $this->armese_service_title, $Default, FALSE); // armese_service_title
		$this->BuildSearchSql($sWhere, $this->armese_service_snippet, $Default, FALSE); // armese_service_snippet
		$this->BuildSearchSql($sWhere, $this->armese_service_pic, $Default, FALSE); // armese_service_pic
		$this->BuildSearchSql($sWhere, $this->armese_service_icon, $Default, FALSE); // armese_service_icon
		$this->BuildSearchSql($sWhere, $this->sort_order, $Default, FALSE); // sort_order
		$this->BuildSearchSql($sWhere, $this->status, $Default, FALSE); // status

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->armese_service_id->AdvancedSearch->Save(); // armese_service_id
			$this->armese_service_title->AdvancedSearch->Save(); // armese_service_title
			$this->armese_service_snippet->AdvancedSearch->Save(); // armese_service_snippet
			$this->armese_service_pic->AdvancedSearch->Save(); // armese_service_pic
			$this->armese_service_icon->AdvancedSearch->Save(); // armese_service_icon
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
		$this->BuildBasicSearchSQL($sWhere, $this->armese_service_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->armese_service_snippet, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->armese_service_pic, $arKeywords, $type);
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
		if ($this->armese_service_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->armese_service_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->armese_service_snippet->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->armese_service_pic->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->armese_service_icon->AdvancedSearch->IssetSession())
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
		$this->armese_service_id->AdvancedSearch->UnsetSession();
		$this->armese_service_title->AdvancedSearch->UnsetSession();
		$this->armese_service_snippet->AdvancedSearch->UnsetSession();
		$this->armese_service_pic->AdvancedSearch->UnsetSession();
		$this->armese_service_icon->AdvancedSearch->UnsetSession();
		$this->sort_order->AdvancedSearch->UnsetSession();
		$this->status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->armese_service_id->AdvancedSearch->Load();
		$this->armese_service_title->AdvancedSearch->Load();
		$this->armese_service_snippet->AdvancedSearch->Load();
		$this->armese_service_pic->AdvancedSearch->Load();
		$this->armese_service_icon->AdvancedSearch->Load();
		$this->sort_order->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->armese_service_id); // armese_service_id
			$this->UpdateSort($this->armese_service_title); // armese_service_title
			$this->UpdateSort($this->armese_service_pic); // armese_service_pic
			$this->UpdateSort($this->armese_service_icon); // armese_service_icon
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
				$this->armese_service_id->setSort("");
				$this->armese_service_title->setSort("");
				$this->armese_service_pic->setSort("");
				$this->armese_service_icon->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->armese_service_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"farmese_serviceslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"farmese_serviceslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.farmese_serviceslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"farmese_serviceslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		// armese_service_id

		$this->armese_service_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_armese_service_id"]);
		if ($this->armese_service_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->armese_service_id->AdvancedSearch->SearchOperator = @$_GET["z_armese_service_id"];

		// armese_service_title
		$this->armese_service_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_armese_service_title"]);
		if ($this->armese_service_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->armese_service_title->AdvancedSearch->SearchOperator = @$_GET["z_armese_service_title"];

		// armese_service_snippet
		$this->armese_service_snippet->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_armese_service_snippet"]);
		if ($this->armese_service_snippet->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->armese_service_snippet->AdvancedSearch->SearchOperator = @$_GET["z_armese_service_snippet"];

		// armese_service_pic
		$this->armese_service_pic->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_armese_service_pic"]);
		if ($this->armese_service_pic->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->armese_service_pic->AdvancedSearch->SearchOperator = @$_GET["z_armese_service_pic"];

		// armese_service_icon
		$this->armese_service_icon->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_armese_service_icon"]);
		if ($this->armese_service_icon->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->armese_service_icon->AdvancedSearch->SearchOperator = @$_GET["z_armese_service_icon"];

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
		$this->armese_service_id->setDbValue($rs->fields('armese_service_id'));
		$this->armese_service_title->setDbValue($rs->fields('armese_service_title'));
		$this->armese_service_snippet->setDbValue($rs->fields('armese_service_snippet'));
		$this->armese_service_pic->Upload->DbValue = $rs->fields('armese_service_pic');
		$this->armese_service_pic->CurrentValue = $this->armese_service_pic->Upload->DbValue;
		$this->armese_service_icon->setDbValue($rs->fields('armese_service_icon'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->armese_service_id->DbValue = $row['armese_service_id'];
		$this->armese_service_title->DbValue = $row['armese_service_title'];
		$this->armese_service_snippet->DbValue = $row['armese_service_snippet'];
		$this->armese_service_pic->Upload->DbValue = $row['armese_service_pic'];
		$this->armese_service_icon->DbValue = $row['armese_service_icon'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("armese_service_id")) <> "")
			$this->armese_service_id->CurrentValue = $this->getKey("armese_service_id"); // armese_service_id
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
		// armese_service_id
		// armese_service_title
		// armese_service_snippet
		// armese_service_pic
		// armese_service_icon
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// armese_service_id
		$this->armese_service_id->ViewValue = $this->armese_service_id->CurrentValue;
		$this->armese_service_id->ViewCustomAttributes = "";

		// armese_service_title
		$this->armese_service_title->ViewValue = $this->armese_service_title->CurrentValue;
		$this->armese_service_title->ViewCustomAttributes = "";

		// armese_service_pic
		$this->armese_service_pic->UploadPath = '../src/assets/images/armese';
		if (!ew_Empty($this->armese_service_pic->Upload->DbValue)) {
			$this->armese_service_pic->ImageWidth = 110;
			$this->armese_service_pic->ImageHeight = 120;
			$this->armese_service_pic->ImageAlt = $this->armese_service_pic->FldAlt();
			$this->armese_service_pic->ViewValue = $this->armese_service_pic->Upload->DbValue;
		} else {
			$this->armese_service_pic->ViewValue = "";
		}
		$this->armese_service_pic->ViewCustomAttributes = "";

		// armese_service_icon
		if (strval($this->armese_service_icon->CurrentValue) <> "") {
			$this->armese_service_icon->ViewValue = $this->armese_service_icon->OptionCaption($this->armese_service_icon->CurrentValue);
		} else {
			$this->armese_service_icon->ViewValue = NULL;
		}
		$this->armese_service_icon->ViewCustomAttributes = "";

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

			// armese_service_id
			$this->armese_service_id->LinkCustomAttributes = "";
			$this->armese_service_id->HrefValue = "";
			$this->armese_service_id->TooltipValue = "";

			// armese_service_title
			$this->armese_service_title->LinkCustomAttributes = "";
			$this->armese_service_title->HrefValue = "";
			$this->armese_service_title->TooltipValue = "";

			// armese_service_pic
			$this->armese_service_pic->LinkCustomAttributes = "";
			$this->armese_service_pic->UploadPath = '../src/assets/images/armese';
			if (!ew_Empty($this->armese_service_pic->Upload->DbValue)) {
				$this->armese_service_pic->HrefValue = ew_GetFileUploadUrl($this->armese_service_pic, $this->armese_service_pic->Upload->DbValue); // Add prefix/suffix
				$this->armese_service_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->armese_service_pic->HrefValue = ew_ConvertFullUrl($this->armese_service_pic->HrefValue);
			} else {
				$this->armese_service_pic->HrefValue = "";
			}
			$this->armese_service_pic->HrefValue2 = $this->armese_service_pic->UploadPath . $this->armese_service_pic->Upload->DbValue;
			$this->armese_service_pic->TooltipValue = "";
			if ($this->armese_service_pic->UseColorbox) {
				$this->armese_service_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->armese_service_pic->LinkAttrs["data-rel"] = "armese_services_x" . $this->RowCnt . "_armese_service_pic";

				//$this->armese_service_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->armese_service_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->armese_service_pic->LinkAttrs["data-container"] = "body";

				$this->armese_service_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// armese_service_icon
			$this->armese_service_icon->LinkCustomAttributes = "";
			$this->armese_service_icon->HrefValue = "";
			$this->armese_service_icon->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// armese_service_id
			$this->armese_service_id->EditAttrs["class"] = "form-control";
			$this->armese_service_id->EditCustomAttributes = "";
			$this->armese_service_id->EditValue = ew_HtmlEncode($this->armese_service_id->AdvancedSearch->SearchValue);
			$this->armese_service_id->PlaceHolder = ew_RemoveHtml($this->armese_service_id->FldCaption());

			// armese_service_title
			$this->armese_service_title->EditAttrs["class"] = "form-control";
			$this->armese_service_title->EditCustomAttributes = "";
			$this->armese_service_title->EditValue = ew_HtmlEncode($this->armese_service_title->AdvancedSearch->SearchValue);
			$this->armese_service_title->PlaceHolder = ew_RemoveHtml($this->armese_service_title->FldCaption());

			// armese_service_pic
			$this->armese_service_pic->EditAttrs["class"] = "form-control";
			$this->armese_service_pic->EditCustomAttributes = "";
			$this->armese_service_pic->EditValue = ew_HtmlEncode($this->armese_service_pic->AdvancedSearch->SearchValue);
			$this->armese_service_pic->PlaceHolder = ew_RemoveHtml($this->armese_service_pic->FldCaption());

			// armese_service_icon
			$this->armese_service_icon->EditAttrs["class"] = "form-control";
			$this->armese_service_icon->EditCustomAttributes = "";
			$this->armese_service_icon->EditValue = $this->armese_service_icon->Options(TRUE);

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
		$this->armese_service_id->AdvancedSearch->Load();
		$this->armese_service_title->AdvancedSearch->Load();
		$this->armese_service_snippet->AdvancedSearch->Load();
		$this->armese_service_pic->AdvancedSearch->Load();
		$this->armese_service_icon->AdvancedSearch->Load();
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
if (!isset($armese_services_list)) $armese_services_list = new carmese_services_list();

// Page init
$armese_services_list->Page_Init();

// Page main
$armese_services_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$armese_services_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = farmese_serviceslist = new ew_Form("farmese_serviceslist", "list");
farmese_serviceslist.FormKeyCountName = '<?php echo $armese_services_list->FormKeyCountName ?>';

// Form_CustomValidate event
farmese_serviceslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
farmese_serviceslist.ValidateRequired = true;
<?php } else { ?>
farmese_serviceslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
farmese_serviceslist.Lists["x_armese_service_icon"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_serviceslist.Lists["x_armese_service_icon"].Options = <?php echo json_encode($armese_services->armese_service_icon->Options()) ?>;
farmese_serviceslist.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_serviceslist.Lists["x_status"].Options = <?php echo json_encode($armese_services->status->Options()) ?>;

// Form object for search
var CurrentSearchForm = farmese_serviceslistsrch = new ew_Form("farmese_serviceslistsrch");

// Validate function for search
farmese_serviceslistsrch.Validate = function(fobj) {
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
farmese_serviceslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
farmese_serviceslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
farmese_serviceslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
farmese_serviceslistsrch.Lists["x_armese_service_icon"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_serviceslistsrch.Lists["x_armese_service_icon"].Options = <?php echo json_encode($armese_services->armese_service_icon->Options()) ?>;
farmese_serviceslistsrch.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_serviceslistsrch.Lists["x_status"].Options = <?php echo json_encode($armese_services->status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($armese_services_list->TotalRecs > 0 && $armese_services_list->ExportOptions->Visible()) { ?>
<?php $armese_services_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($armese_services_list->SearchOptions->Visible()) { ?>
<?php $armese_services_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($armese_services_list->FilterOptions->Visible()) { ?>
<?php $armese_services_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $armese_services_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($armese_services_list->TotalRecs <= 0)
			$armese_services_list->TotalRecs = $armese_services->SelectRecordCount();
	} else {
		if (!$armese_services_list->Recordset && ($armese_services_list->Recordset = $armese_services_list->LoadRecordset()))
			$armese_services_list->TotalRecs = $armese_services_list->Recordset->RecordCount();
	}
	$armese_services_list->StartRec = 1;
	if ($armese_services_list->DisplayRecs <= 0 || ($armese_services->Export <> "" && $armese_services->ExportAll)) // Display all records
		$armese_services_list->DisplayRecs = $armese_services_list->TotalRecs;
	if (!($armese_services->Export <> "" && $armese_services->ExportAll))
		$armese_services_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$armese_services_list->Recordset = $armese_services_list->LoadRecordset($armese_services_list->StartRec-1, $armese_services_list->DisplayRecs);

	// Set no record found message
	if ($armese_services->CurrentAction == "" && $armese_services_list->TotalRecs == 0) {
		if ($armese_services_list->SearchWhere == "0=101")
			$armese_services_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$armese_services_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$armese_services_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($armese_services->Export == "" && $armese_services->CurrentAction == "") { ?>
<form name="farmese_serviceslistsrch" id="farmese_serviceslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($armese_services_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="farmese_serviceslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="armese_services">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$armese_services_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$armese_services->RowType = EW_ROWTYPE_SEARCH;

// Render row
$armese_services->ResetAttrs();
$armese_services_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($armese_services->armese_service_icon->Visible) { // armese_service_icon ?>
	<div id="xsc_armese_service_icon" class="ewCell form-group">
		<label for="x_armese_service_icon" class="ewSearchCaption ewLabel"><?php echo $armese_services->armese_service_icon->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_armese_service_icon" id="z_armese_service_icon" value="="></span>
		<span class="ewSearchField">
<select data-table="armese_services" data-field="x_armese_service_icon" data-value-separator="<?php echo ew_HtmlEncode(is_array($armese_services->armese_service_icon->DisplayValueSeparator) ? json_encode($armese_services->armese_service_icon->DisplayValueSeparator) : $armese_services->armese_service_icon->DisplayValueSeparator) ?>" id="x_armese_service_icon" name="x_armese_service_icon"<?php echo $armese_services->armese_service_icon->EditAttributes() ?>>
<?php
if (is_array($armese_services->armese_service_icon->EditValue)) {
	$arwrk = $armese_services->armese_service_icon->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($armese_services->armese_service_icon->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $armese_services->armese_service_icon->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($armese_services->armese_service_icon->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($armese_services->armese_service_icon->CurrentValue) ?>" selected><?php echo $armese_services->armese_service_icon->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($armese_services->status->Visible) { // status ?>
	<div id="xsc_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $armese_services->status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status" id="z_status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="armese_services" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($armese_services->status->DisplayValueSeparator) ? json_encode($armese_services->status->DisplayValueSeparator) : $armese_services->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $armese_services->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $armese_services->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($armese_services->status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="armese_services" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $armese_services->status->EditAttributes() ?>><?php echo $armese_services->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($armese_services->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="armese_services" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($armese_services->status->CurrentValue) ?>" checked<?php echo $armese_services->status->EditAttributes() ?>><?php echo $armese_services->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($armese_services_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($armese_services_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $armese_services_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($armese_services_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($armese_services_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($armese_services_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($armese_services_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $armese_services_list->ShowPageHeader(); ?>
<?php
$armese_services_list->ShowMessage();
?>
<?php if ($armese_services_list->TotalRecs > 0 || $armese_services->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="farmese_serviceslist" id="farmese_serviceslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($armese_services_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $armese_services_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="armese_services">
<div id="gmp_armese_services" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($armese_services_list->TotalRecs > 0) { ?>
<table id="tbl_armese_serviceslist" class="table ewTable">
<?php echo $armese_services->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$armese_services_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$armese_services_list->RenderListOptions();

// Render list options (header, left)
$armese_services_list->ListOptions->Render("header", "left");
?>
<?php if ($armese_services->armese_service_id->Visible) { // armese_service_id ?>
	<?php if ($armese_services->SortUrl($armese_services->armese_service_id) == "") { ?>
		<th data-name="armese_service_id"><div id="elh_armese_services_armese_service_id" class="armese_services_armese_service_id"><div class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="armese_service_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $armese_services->SortUrl($armese_services->armese_service_id) ?>',1);"><div id="elh_armese_services_armese_service_id" class="armese_services_armese_service_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($armese_services->armese_service_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($armese_services->armese_service_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($armese_services->armese_service_title->Visible) { // armese_service_title ?>
	<?php if ($armese_services->SortUrl($armese_services->armese_service_title) == "") { ?>
		<th data-name="armese_service_title"><div id="elh_armese_services_armese_service_title" class="armese_services_armese_service_title"><div class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="armese_service_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $armese_services->SortUrl($armese_services->armese_service_title) ?>',1);"><div id="elh_armese_services_armese_service_title" class="armese_services_armese_service_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($armese_services->armese_service_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($armese_services->armese_service_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($armese_services->armese_service_pic->Visible) { // armese_service_pic ?>
	<?php if ($armese_services->SortUrl($armese_services->armese_service_pic) == "") { ?>
		<th data-name="armese_service_pic"><div id="elh_armese_services_armese_service_pic" class="armese_services_armese_service_pic"><div class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_pic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="armese_service_pic"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $armese_services->SortUrl($armese_services->armese_service_pic) ?>',1);"><div id="elh_armese_services_armese_service_pic" class="armese_services_armese_service_pic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_pic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($armese_services->armese_service_pic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($armese_services->armese_service_pic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($armese_services->armese_service_icon->Visible) { // armese_service_icon ?>
	<?php if ($armese_services->SortUrl($armese_services->armese_service_icon) == "") { ?>
		<th data-name="armese_service_icon"><div id="elh_armese_services_armese_service_icon" class="armese_services_armese_service_icon"><div class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_icon->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="armese_service_icon"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $armese_services->SortUrl($armese_services->armese_service_icon) ?>',1);"><div id="elh_armese_services_armese_service_icon" class="armese_services_armese_service_icon">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $armese_services->armese_service_icon->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($armese_services->armese_service_icon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($armese_services->armese_service_icon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($armese_services->sort_order->Visible) { // sort_order ?>
	<?php if ($armese_services->SortUrl($armese_services->sort_order) == "") { ?>
		<th data-name="sort_order"><div id="elh_armese_services_sort_order" class="armese_services_sort_order"><div class="ewTableHeaderCaption"><?php echo $armese_services->sort_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sort_order"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $armese_services->SortUrl($armese_services->sort_order) ?>',1);"><div id="elh_armese_services_sort_order" class="armese_services_sort_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $armese_services->sort_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($armese_services->sort_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($armese_services->sort_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($armese_services->status->Visible) { // status ?>
	<?php if ($armese_services->SortUrl($armese_services->status) == "") { ?>
		<th data-name="status"><div id="elh_armese_services_status" class="armese_services_status"><div class="ewTableHeaderCaption"><?php echo $armese_services->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $armese_services->SortUrl($armese_services->status) ?>',1);"><div id="elh_armese_services_status" class="armese_services_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $armese_services->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($armese_services->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($armese_services->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$armese_services_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($armese_services->ExportAll && $armese_services->Export <> "") {
	$armese_services_list->StopRec = $armese_services_list->TotalRecs;
} else {

	// Set the last record to display
	if ($armese_services_list->TotalRecs > $armese_services_list->StartRec + $armese_services_list->DisplayRecs - 1)
		$armese_services_list->StopRec = $armese_services_list->StartRec + $armese_services_list->DisplayRecs - 1;
	else
		$armese_services_list->StopRec = $armese_services_list->TotalRecs;
}
$armese_services_list->RecCnt = $armese_services_list->StartRec - 1;
if ($armese_services_list->Recordset && !$armese_services_list->Recordset->EOF) {
	$armese_services_list->Recordset->MoveFirst();
	$bSelectLimit = $armese_services_list->UseSelectLimit;
	if (!$bSelectLimit && $armese_services_list->StartRec > 1)
		$armese_services_list->Recordset->Move($armese_services_list->StartRec - 1);
} elseif (!$armese_services->AllowAddDeleteRow && $armese_services_list->StopRec == 0) {
	$armese_services_list->StopRec = $armese_services->GridAddRowCount;
}

// Initialize aggregate
$armese_services->RowType = EW_ROWTYPE_AGGREGATEINIT;
$armese_services->ResetAttrs();
$armese_services_list->RenderRow();
while ($armese_services_list->RecCnt < $armese_services_list->StopRec) {
	$armese_services_list->RecCnt++;
	if (intval($armese_services_list->RecCnt) >= intval($armese_services_list->StartRec)) {
		$armese_services_list->RowCnt++;

		// Set up key count
		$armese_services_list->KeyCount = $armese_services_list->RowIndex;

		// Init row class and style
		$armese_services->ResetAttrs();
		$armese_services->CssClass = "";
		if ($armese_services->CurrentAction == "gridadd") {
		} else {
			$armese_services_list->LoadRowValues($armese_services_list->Recordset); // Load row values
		}
		$armese_services->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$armese_services->RowAttrs = array_merge($armese_services->RowAttrs, array('data-rowindex'=>$armese_services_list->RowCnt, 'id'=>'r' . $armese_services_list->RowCnt . '_armese_services', 'data-rowtype'=>$armese_services->RowType));

		// Render row
		$armese_services_list->RenderRow();

		// Render list options
		$armese_services_list->RenderListOptions();
?>
	<tr<?php echo $armese_services->RowAttributes() ?>>
<?php

// Render list options (body, left)
$armese_services_list->ListOptions->Render("body", "left", $armese_services_list->RowCnt);
?>
	<?php if ($armese_services->armese_service_id->Visible) { // armese_service_id ?>
		<td data-name="armese_service_id"<?php echo $armese_services->armese_service_id->CellAttributes() ?>>
<span id="el<?php echo $armese_services_list->RowCnt ?>_armese_services_armese_service_id" class="armese_services_armese_service_id">
<span<?php echo $armese_services->armese_service_id->ViewAttributes() ?>>
<?php echo $armese_services->armese_service_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $armese_services_list->PageObjName . "_row_" . $armese_services_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($armese_services->armese_service_title->Visible) { // armese_service_title ?>
		<td data-name="armese_service_title"<?php echo $armese_services->armese_service_title->CellAttributes() ?>>
<span id="el<?php echo $armese_services_list->RowCnt ?>_armese_services_armese_service_title" class="armese_services_armese_service_title">
<span<?php echo $armese_services->armese_service_title->ViewAttributes() ?>>
<?php echo $armese_services->armese_service_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($armese_services->armese_service_pic->Visible) { // armese_service_pic ?>
		<td data-name="armese_service_pic"<?php echo $armese_services->armese_service_pic->CellAttributes() ?>>
<span id="el<?php echo $armese_services_list->RowCnt ?>_armese_services_armese_service_pic" class="armese_services_armese_service_pic">
<span>
<?php echo ew_GetFileViewTag($armese_services->armese_service_pic, $armese_services->armese_service_pic->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($armese_services->armese_service_icon->Visible) { // armese_service_icon ?>
		<td data-name="armese_service_icon"<?php echo $armese_services->armese_service_icon->CellAttributes() ?>>
<span id="el<?php echo $armese_services_list->RowCnt ?>_armese_services_armese_service_icon" class="armese_services_armese_service_icon">
<span<?php echo $armese_services->armese_service_icon->ViewAttributes() ?>>
<?php echo $armese_services->armese_service_icon->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($armese_services->sort_order->Visible) { // sort_order ?>
		<td data-name="sort_order"<?php echo $armese_services->sort_order->CellAttributes() ?>>
<span id="el<?php echo $armese_services_list->RowCnt ?>_armese_services_sort_order" class="armese_services_sort_order">
<span<?php echo $armese_services->sort_order->ViewAttributes() ?>>
<?php echo $armese_services->sort_order->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($armese_services->status->Visible) { // status ?>
		<td data-name="status"<?php echo $armese_services->status->CellAttributes() ?>>
<span id="el<?php echo $armese_services_list->RowCnt ?>_armese_services_status" class="armese_services_status">
<span<?php echo $armese_services->status->ViewAttributes() ?>>
<?php echo $armese_services->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$armese_services_list->ListOptions->Render("body", "right", $armese_services_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($armese_services->CurrentAction <> "gridadd")
		$armese_services_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($armese_services->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($armese_services_list->Recordset)
	$armese_services_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($armese_services->CurrentAction <> "gridadd" && $armese_services->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($armese_services_list->Pager)) $armese_services_list->Pager = new cPrevNextPager($armese_services_list->StartRec, $armese_services_list->DisplayRecs, $armese_services_list->TotalRecs) ?>
<?php if ($armese_services_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($armese_services_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $armese_services_list->PageUrl() ?>start=<?php echo $armese_services_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($armese_services_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $armese_services_list->PageUrl() ?>start=<?php echo $armese_services_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $armese_services_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($armese_services_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $armese_services_list->PageUrl() ?>start=<?php echo $armese_services_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($armese_services_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $armese_services_list->PageUrl() ?>start=<?php echo $armese_services_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $armese_services_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $armese_services_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $armese_services_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $armese_services_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($armese_services_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($armese_services_list->TotalRecs == 0 && $armese_services->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($armese_services_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
farmese_serviceslistsrch.Init();
farmese_serviceslistsrch.FilterList = <?php echo $armese_services_list->GetFilterList() ?>;
farmese_serviceslist.Init();
</script>
<?php
$armese_services_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$armese_services_list->Page_Terminate();
?>
