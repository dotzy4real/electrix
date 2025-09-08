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

$board_directors_list = NULL; // Initialize page object first

class cboard_directors_list extends cboard_directors {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'board_directors';

	// Page object name
	var $PageObjName = 'board_directors_list';

	// Grid form hidden field names
	var $FormName = 'fboard_directorslist';
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

		// Table object (board_directors)
		if (!isset($GLOBALS["board_directors"]) || get_class($GLOBALS["board_directors"]) == "cboard_directors") {
			$GLOBALS["board_directors"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["board_directors"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "board_directorsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "board_directorsdelete.php";
		$this->MultiUpdateUrl = "board_directorsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'board_directors', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fboard_directorslistsrch";

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
			$this->board_director_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->board_director_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->board_director_id->AdvancedSearch->ToJSON(), ","); // Field board_director_id
		$sFilterList = ew_Concat($sFilterList, $this->board_director_pic->AdvancedSearch->ToJSON(), ","); // Field board_director_pic
		$sFilterList = ew_Concat($sFilterList, $this->board_director_name->AdvancedSearch->ToJSON(), ","); // Field board_director_name
		$sFilterList = ew_Concat($sFilterList, $this->board_director_designation->AdvancedSearch->ToJSON(), ","); // Field board_director_designation
		$sFilterList = ew_Concat($sFilterList, $this->board_director_content->AdvancedSearch->ToJSON(), ","); // Field board_director_content
		$sFilterList = ew_Concat($sFilterList, $this->sort_order->AdvancedSearch->ToJSON(), ","); // Field sort_order
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJSON(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->board_director_linkedin->AdvancedSearch->ToJSON(), ","); // Field board_director_linkedin
		$sFilterList = ew_Concat($sFilterList, $this->board_director_facebook->AdvancedSearch->ToJSON(), ","); // Field board_director_facebook
		$sFilterList = ew_Concat($sFilterList, $this->board_director_twitter->AdvancedSearch->ToJSON(), ","); // Field board_director_twitter
		$sFilterList = ew_Concat($sFilterList, $this->board_director_email->AdvancedSearch->ToJSON(), ","); // Field board_director_email
		$sFilterList = ew_Concat($sFilterList, $this->board_director_phone->AdvancedSearch->ToJSON(), ","); // Field board_director_phone
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

		// Field board_director_id
		$this->board_director_id->AdvancedSearch->SearchValue = @$filter["x_board_director_id"];
		$this->board_director_id->AdvancedSearch->SearchOperator = @$filter["z_board_director_id"];
		$this->board_director_id->AdvancedSearch->SearchCondition = @$filter["v_board_director_id"];
		$this->board_director_id->AdvancedSearch->SearchValue2 = @$filter["y_board_director_id"];
		$this->board_director_id->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_id"];
		$this->board_director_id->AdvancedSearch->Save();

		// Field board_director_pic
		$this->board_director_pic->AdvancedSearch->SearchValue = @$filter["x_board_director_pic"];
		$this->board_director_pic->AdvancedSearch->SearchOperator = @$filter["z_board_director_pic"];
		$this->board_director_pic->AdvancedSearch->SearchCondition = @$filter["v_board_director_pic"];
		$this->board_director_pic->AdvancedSearch->SearchValue2 = @$filter["y_board_director_pic"];
		$this->board_director_pic->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_pic"];
		$this->board_director_pic->AdvancedSearch->Save();

		// Field board_director_name
		$this->board_director_name->AdvancedSearch->SearchValue = @$filter["x_board_director_name"];
		$this->board_director_name->AdvancedSearch->SearchOperator = @$filter["z_board_director_name"];
		$this->board_director_name->AdvancedSearch->SearchCondition = @$filter["v_board_director_name"];
		$this->board_director_name->AdvancedSearch->SearchValue2 = @$filter["y_board_director_name"];
		$this->board_director_name->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_name"];
		$this->board_director_name->AdvancedSearch->Save();

		// Field board_director_designation
		$this->board_director_designation->AdvancedSearch->SearchValue = @$filter["x_board_director_designation"];
		$this->board_director_designation->AdvancedSearch->SearchOperator = @$filter["z_board_director_designation"];
		$this->board_director_designation->AdvancedSearch->SearchCondition = @$filter["v_board_director_designation"];
		$this->board_director_designation->AdvancedSearch->SearchValue2 = @$filter["y_board_director_designation"];
		$this->board_director_designation->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_designation"];
		$this->board_director_designation->AdvancedSearch->Save();

		// Field board_director_content
		$this->board_director_content->AdvancedSearch->SearchValue = @$filter["x_board_director_content"];
		$this->board_director_content->AdvancedSearch->SearchOperator = @$filter["z_board_director_content"];
		$this->board_director_content->AdvancedSearch->SearchCondition = @$filter["v_board_director_content"];
		$this->board_director_content->AdvancedSearch->SearchValue2 = @$filter["y_board_director_content"];
		$this->board_director_content->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_content"];
		$this->board_director_content->AdvancedSearch->Save();

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

		// Field board_director_linkedin
		$this->board_director_linkedin->AdvancedSearch->SearchValue = @$filter["x_board_director_linkedin"];
		$this->board_director_linkedin->AdvancedSearch->SearchOperator = @$filter["z_board_director_linkedin"];
		$this->board_director_linkedin->AdvancedSearch->SearchCondition = @$filter["v_board_director_linkedin"];
		$this->board_director_linkedin->AdvancedSearch->SearchValue2 = @$filter["y_board_director_linkedin"];
		$this->board_director_linkedin->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_linkedin"];
		$this->board_director_linkedin->AdvancedSearch->Save();

		// Field board_director_facebook
		$this->board_director_facebook->AdvancedSearch->SearchValue = @$filter["x_board_director_facebook"];
		$this->board_director_facebook->AdvancedSearch->SearchOperator = @$filter["z_board_director_facebook"];
		$this->board_director_facebook->AdvancedSearch->SearchCondition = @$filter["v_board_director_facebook"];
		$this->board_director_facebook->AdvancedSearch->SearchValue2 = @$filter["y_board_director_facebook"];
		$this->board_director_facebook->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_facebook"];
		$this->board_director_facebook->AdvancedSearch->Save();

		// Field board_director_twitter
		$this->board_director_twitter->AdvancedSearch->SearchValue = @$filter["x_board_director_twitter"];
		$this->board_director_twitter->AdvancedSearch->SearchOperator = @$filter["z_board_director_twitter"];
		$this->board_director_twitter->AdvancedSearch->SearchCondition = @$filter["v_board_director_twitter"];
		$this->board_director_twitter->AdvancedSearch->SearchValue2 = @$filter["y_board_director_twitter"];
		$this->board_director_twitter->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_twitter"];
		$this->board_director_twitter->AdvancedSearch->Save();

		// Field board_director_email
		$this->board_director_email->AdvancedSearch->SearchValue = @$filter["x_board_director_email"];
		$this->board_director_email->AdvancedSearch->SearchOperator = @$filter["z_board_director_email"];
		$this->board_director_email->AdvancedSearch->SearchCondition = @$filter["v_board_director_email"];
		$this->board_director_email->AdvancedSearch->SearchValue2 = @$filter["y_board_director_email"];
		$this->board_director_email->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_email"];
		$this->board_director_email->AdvancedSearch->Save();

		// Field board_director_phone
		$this->board_director_phone->AdvancedSearch->SearchValue = @$filter["x_board_director_phone"];
		$this->board_director_phone->AdvancedSearch->SearchOperator = @$filter["z_board_director_phone"];
		$this->board_director_phone->AdvancedSearch->SearchCondition = @$filter["v_board_director_phone"];
		$this->board_director_phone->AdvancedSearch->SearchValue2 = @$filter["y_board_director_phone"];
		$this->board_director_phone->AdvancedSearch->SearchOperator2 = @$filter["w_board_director_phone"];
		$this->board_director_phone->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->board_director_id, $Default, FALSE); // board_director_id
		$this->BuildSearchSql($sWhere, $this->board_director_pic, $Default, FALSE); // board_director_pic
		$this->BuildSearchSql($sWhere, $this->board_director_name, $Default, FALSE); // board_director_name
		$this->BuildSearchSql($sWhere, $this->board_director_designation, $Default, FALSE); // board_director_designation
		$this->BuildSearchSql($sWhere, $this->board_director_content, $Default, FALSE); // board_director_content
		$this->BuildSearchSql($sWhere, $this->sort_order, $Default, FALSE); // sort_order
		$this->BuildSearchSql($sWhere, $this->status, $Default, FALSE); // status
		$this->BuildSearchSql($sWhere, $this->board_director_linkedin, $Default, FALSE); // board_director_linkedin
		$this->BuildSearchSql($sWhere, $this->board_director_facebook, $Default, FALSE); // board_director_facebook
		$this->BuildSearchSql($sWhere, $this->board_director_twitter, $Default, FALSE); // board_director_twitter
		$this->BuildSearchSql($sWhere, $this->board_director_email, $Default, FALSE); // board_director_email
		$this->BuildSearchSql($sWhere, $this->board_director_phone, $Default, FALSE); // board_director_phone

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->board_director_id->AdvancedSearch->Save(); // board_director_id
			$this->board_director_pic->AdvancedSearch->Save(); // board_director_pic
			$this->board_director_name->AdvancedSearch->Save(); // board_director_name
			$this->board_director_designation->AdvancedSearch->Save(); // board_director_designation
			$this->board_director_content->AdvancedSearch->Save(); // board_director_content
			$this->sort_order->AdvancedSearch->Save(); // sort_order
			$this->status->AdvancedSearch->Save(); // status
			$this->board_director_linkedin->AdvancedSearch->Save(); // board_director_linkedin
			$this->board_director_facebook->AdvancedSearch->Save(); // board_director_facebook
			$this->board_director_twitter->AdvancedSearch->Save(); // board_director_twitter
			$this->board_director_email->AdvancedSearch->Save(); // board_director_email
			$this->board_director_phone->AdvancedSearch->Save(); // board_director_phone
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
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_pic, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_designation, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_content, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_linkedin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_facebook, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_twitter, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->board_director_phone, $arKeywords, $type);
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
		if ($this->board_director_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_pic->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_designation->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_content->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sort_order->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_linkedin->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_facebook->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_twitter->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_email->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->board_director_phone->AdvancedSearch->IssetSession())
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
		$this->board_director_id->AdvancedSearch->UnsetSession();
		$this->board_director_pic->AdvancedSearch->UnsetSession();
		$this->board_director_name->AdvancedSearch->UnsetSession();
		$this->board_director_designation->AdvancedSearch->UnsetSession();
		$this->board_director_content->AdvancedSearch->UnsetSession();
		$this->sort_order->AdvancedSearch->UnsetSession();
		$this->status->AdvancedSearch->UnsetSession();
		$this->board_director_linkedin->AdvancedSearch->UnsetSession();
		$this->board_director_facebook->AdvancedSearch->UnsetSession();
		$this->board_director_twitter->AdvancedSearch->UnsetSession();
		$this->board_director_email->AdvancedSearch->UnsetSession();
		$this->board_director_phone->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->board_director_id->AdvancedSearch->Load();
		$this->board_director_pic->AdvancedSearch->Load();
		$this->board_director_name->AdvancedSearch->Load();
		$this->board_director_designation->AdvancedSearch->Load();
		$this->board_director_content->AdvancedSearch->Load();
		$this->sort_order->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
		$this->board_director_linkedin->AdvancedSearch->Load();
		$this->board_director_facebook->AdvancedSearch->Load();
		$this->board_director_twitter->AdvancedSearch->Load();
		$this->board_director_email->AdvancedSearch->Load();
		$this->board_director_phone->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->board_director_id); // board_director_id
			$this->UpdateSort($this->board_director_pic); // board_director_pic
			$this->UpdateSort($this->board_director_name); // board_director_name
			$this->UpdateSort($this->board_director_designation); // board_director_designation
			$this->UpdateSort($this->sort_order); // sort_order
			$this->UpdateSort($this->status); // status
			$this->UpdateSort($this->board_director_linkedin); // board_director_linkedin
			$this->UpdateSort($this->board_director_facebook); // board_director_facebook
			$this->UpdateSort($this->board_director_twitter); // board_director_twitter
			$this->UpdateSort($this->board_director_email); // board_director_email
			$this->UpdateSort($this->board_director_phone); // board_director_phone
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
				$this->board_director_id->setSort("");
				$this->board_director_pic->setSort("");
				$this->board_director_name->setSort("");
				$this->board_director_designation->setSort("");
				$this->sort_order->setSort("");
				$this->status->setSort("");
				$this->board_director_linkedin->setSort("");
				$this->board_director_facebook->setSort("");
				$this->board_director_twitter->setSort("");
				$this->board_director_email->setSort("");
				$this->board_director_phone->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->board_director_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fboard_directorslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fboard_directorslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fboard_directorslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fboard_directorslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		// board_director_id

		$this->board_director_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_id"]);
		if ($this->board_director_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_id->AdvancedSearch->SearchOperator = @$_GET["z_board_director_id"];

		// board_director_pic
		$this->board_director_pic->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_pic"]);
		if ($this->board_director_pic->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_pic->AdvancedSearch->SearchOperator = @$_GET["z_board_director_pic"];

		// board_director_name
		$this->board_director_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_name"]);
		if ($this->board_director_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_name->AdvancedSearch->SearchOperator = @$_GET["z_board_director_name"];

		// board_director_designation
		$this->board_director_designation->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_designation"]);
		if ($this->board_director_designation->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_designation->AdvancedSearch->SearchOperator = @$_GET["z_board_director_designation"];

		// board_director_content
		$this->board_director_content->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_content"]);
		if ($this->board_director_content->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_content->AdvancedSearch->SearchOperator = @$_GET["z_board_director_content"];

		// sort_order
		$this->sort_order->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_sort_order"]);
		if ($this->sort_order->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->sort_order->AdvancedSearch->SearchOperator = @$_GET["z_sort_order"];

		// status
		$this->status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_status"]);
		if ($this->status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->status->AdvancedSearch->SearchOperator = @$_GET["z_status"];

		// board_director_linkedin
		$this->board_director_linkedin->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_linkedin"]);
		if ($this->board_director_linkedin->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_linkedin->AdvancedSearch->SearchOperator = @$_GET["z_board_director_linkedin"];

		// board_director_facebook
		$this->board_director_facebook->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_facebook"]);
		if ($this->board_director_facebook->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_facebook->AdvancedSearch->SearchOperator = @$_GET["z_board_director_facebook"];

		// board_director_twitter
		$this->board_director_twitter->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_twitter"]);
		if ($this->board_director_twitter->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_twitter->AdvancedSearch->SearchOperator = @$_GET["z_board_director_twitter"];

		// board_director_email
		$this->board_director_email->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_email"]);
		if ($this->board_director_email->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_email->AdvancedSearch->SearchOperator = @$_GET["z_board_director_email"];

		// board_director_phone
		$this->board_director_phone->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_board_director_phone"]);
		if ($this->board_director_phone->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->board_director_phone->AdvancedSearch->SearchOperator = @$_GET["z_board_director_phone"];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("board_director_id")) <> "")
			$this->board_director_id->CurrentValue = $this->getKey("board_director_id"); // board_director_id
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
				$this->board_director_pic->LinkAttrs["data-rel"] = "board_directors_x" . $this->RowCnt . "_board_director_pic";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// board_director_id
			$this->board_director_id->EditAttrs["class"] = "form-control";
			$this->board_director_id->EditCustomAttributes = "";
			$this->board_director_id->EditValue = ew_HtmlEncode($this->board_director_id->AdvancedSearch->SearchValue);
			$this->board_director_id->PlaceHolder = ew_RemoveHtml($this->board_director_id->FldCaption());

			// board_director_pic
			$this->board_director_pic->EditAttrs["class"] = "form-control";
			$this->board_director_pic->EditCustomAttributes = "";
			$this->board_director_pic->EditValue = ew_HtmlEncode($this->board_director_pic->AdvancedSearch->SearchValue);
			$this->board_director_pic->PlaceHolder = ew_RemoveHtml($this->board_director_pic->FldCaption());

			// board_director_name
			$this->board_director_name->EditAttrs["class"] = "form-control";
			$this->board_director_name->EditCustomAttributes = "";
			$this->board_director_name->EditValue = ew_HtmlEncode($this->board_director_name->AdvancedSearch->SearchValue);
			$this->board_director_name->PlaceHolder = ew_RemoveHtml($this->board_director_name->FldCaption());

			// board_director_designation
			$this->board_director_designation->EditAttrs["class"] = "form-control";
			$this->board_director_designation->EditCustomAttributes = "";
			$this->board_director_designation->EditValue = ew_HtmlEncode($this->board_director_designation->AdvancedSearch->SearchValue);
			$this->board_director_designation->PlaceHolder = ew_RemoveHtml($this->board_director_designation->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->AdvancedSearch->SearchValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// board_director_linkedin
			$this->board_director_linkedin->EditAttrs["class"] = "form-control";
			$this->board_director_linkedin->EditCustomAttributes = "";
			$this->board_director_linkedin->EditValue = ew_HtmlEncode($this->board_director_linkedin->AdvancedSearch->SearchValue);
			$this->board_director_linkedin->PlaceHolder = ew_RemoveHtml($this->board_director_linkedin->FldCaption());

			// board_director_facebook
			$this->board_director_facebook->EditAttrs["class"] = "form-control";
			$this->board_director_facebook->EditCustomAttributes = "";
			$this->board_director_facebook->EditValue = ew_HtmlEncode($this->board_director_facebook->AdvancedSearch->SearchValue);
			$this->board_director_facebook->PlaceHolder = ew_RemoveHtml($this->board_director_facebook->FldCaption());

			// board_director_twitter
			$this->board_director_twitter->EditAttrs["class"] = "form-control";
			$this->board_director_twitter->EditCustomAttributes = "";
			$this->board_director_twitter->EditValue = ew_HtmlEncode($this->board_director_twitter->AdvancedSearch->SearchValue);
			$this->board_director_twitter->PlaceHolder = ew_RemoveHtml($this->board_director_twitter->FldCaption());

			// board_director_email
			$this->board_director_email->EditAttrs["class"] = "form-control";
			$this->board_director_email->EditCustomAttributes = "";
			$this->board_director_email->EditValue = ew_HtmlEncode($this->board_director_email->AdvancedSearch->SearchValue);
			$this->board_director_email->PlaceHolder = ew_RemoveHtml($this->board_director_email->FldCaption());

			// board_director_phone
			$this->board_director_phone->EditAttrs["class"] = "form-control";
			$this->board_director_phone->EditCustomAttributes = "";
			$this->board_director_phone->EditValue = ew_HtmlEncode($this->board_director_phone->AdvancedSearch->SearchValue);
			$this->board_director_phone->PlaceHolder = ew_RemoveHtml($this->board_director_phone->FldCaption());
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
		$this->board_director_id->AdvancedSearch->Load();
		$this->board_director_pic->AdvancedSearch->Load();
		$this->board_director_name->AdvancedSearch->Load();
		$this->board_director_designation->AdvancedSearch->Load();
		$this->board_director_content->AdvancedSearch->Load();
		$this->sort_order->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
		$this->board_director_linkedin->AdvancedSearch->Load();
		$this->board_director_facebook->AdvancedSearch->Load();
		$this->board_director_twitter->AdvancedSearch->Load();
		$this->board_director_email->AdvancedSearch->Load();
		$this->board_director_phone->AdvancedSearch->Load();
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
if (!isset($board_directors_list)) $board_directors_list = new cboard_directors_list();

// Page init
$board_directors_list->Page_Init();

// Page main
$board_directors_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$board_directors_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fboard_directorslist = new ew_Form("fboard_directorslist", "list");
fboard_directorslist.FormKeyCountName = '<?php echo $board_directors_list->FormKeyCountName ?>';

// Form_CustomValidate event
fboard_directorslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fboard_directorslist.ValidateRequired = true;
<?php } else { ?>
fboard_directorslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fboard_directorslist.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fboard_directorslist.Lists["x_status"].Options = <?php echo json_encode($board_directors->status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fboard_directorslistsrch = new ew_Form("fboard_directorslistsrch");

// Validate function for search
fboard_directorslistsrch.Validate = function(fobj) {
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
fboard_directorslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fboard_directorslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fboard_directorslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fboard_directorslistsrch.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fboard_directorslistsrch.Lists["x_status"].Options = <?php echo json_encode($board_directors->status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($board_directors_list->TotalRecs > 0 && $board_directors_list->ExportOptions->Visible()) { ?>
<?php $board_directors_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($board_directors_list->SearchOptions->Visible()) { ?>
<?php $board_directors_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($board_directors_list->FilterOptions->Visible()) { ?>
<?php $board_directors_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $board_directors_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($board_directors_list->TotalRecs <= 0)
			$board_directors_list->TotalRecs = $board_directors->SelectRecordCount();
	} else {
		if (!$board_directors_list->Recordset && ($board_directors_list->Recordset = $board_directors_list->LoadRecordset()))
			$board_directors_list->TotalRecs = $board_directors_list->Recordset->RecordCount();
	}
	$board_directors_list->StartRec = 1;
	if ($board_directors_list->DisplayRecs <= 0 || ($board_directors->Export <> "" && $board_directors->ExportAll)) // Display all records
		$board_directors_list->DisplayRecs = $board_directors_list->TotalRecs;
	if (!($board_directors->Export <> "" && $board_directors->ExportAll))
		$board_directors_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$board_directors_list->Recordset = $board_directors_list->LoadRecordset($board_directors_list->StartRec-1, $board_directors_list->DisplayRecs);

	// Set no record found message
	if ($board_directors->CurrentAction == "" && $board_directors_list->TotalRecs == 0) {
		if ($board_directors_list->SearchWhere == "0=101")
			$board_directors_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$board_directors_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$board_directors_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($board_directors->Export == "" && $board_directors->CurrentAction == "") { ?>
<form name="fboard_directorslistsrch" id="fboard_directorslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($board_directors_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fboard_directorslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="board_directors">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$board_directors_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$board_directors->RowType = EW_ROWTYPE_SEARCH;

// Render row
$board_directors->ResetAttrs();
$board_directors_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($board_directors->status->Visible) { // status ?>
	<div id="xsc_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $board_directors->status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status" id="z_status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="board_directors" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($board_directors->status->DisplayValueSeparator) ? json_encode($board_directors->status->DisplayValueSeparator) : $board_directors->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $board_directors->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $board_directors->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($board_directors->status->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="board_directors" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $board_directors->status->EditAttributes() ?>><?php echo $board_directors->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($board_directors->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="board_directors" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($board_directors->status->CurrentValue) ?>" checked<?php echo $board_directors->status->EditAttributes() ?>><?php echo $board_directors->status->CurrentValue ?></label>
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
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($board_directors_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($board_directors_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $board_directors_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($board_directors_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($board_directors_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($board_directors_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($board_directors_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $board_directors_list->ShowPageHeader(); ?>
<?php
$board_directors_list->ShowMessage();
?>
<?php if ($board_directors_list->TotalRecs > 0 || $board_directors->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="fboard_directorslist" id="fboard_directorslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($board_directors_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $board_directors_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="board_directors">
<div id="gmp_board_directors" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($board_directors_list->TotalRecs > 0) { ?>
<table id="tbl_board_directorslist" class="table ewTable">
<?php echo $board_directors->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$board_directors_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$board_directors_list->RenderListOptions();

// Render list options (header, left)
$board_directors_list->ListOptions->Render("header", "left");
?>
<?php if ($board_directors->board_director_id->Visible) { // board_director_id ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_id) == "") { ?>
		<th data-name="board_director_id"><div id="elh_board_directors_board_director_id" class="board_directors_board_director_id"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_id) ?>',1);"><div id="elh_board_directors_board_director_id" class="board_directors_board_director_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_pic->Visible) { // board_director_pic ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_pic) == "") { ?>
		<th data-name="board_director_pic"><div id="elh_board_directors_board_director_pic" class="board_directors_board_director_pic"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_pic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_pic"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_pic) ?>',1);"><div id="elh_board_directors_board_director_pic" class="board_directors_board_director_pic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_pic->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_pic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_pic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_name->Visible) { // board_director_name ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_name) == "") { ?>
		<th data-name="board_director_name"><div id="elh_board_directors_board_director_name" class="board_directors_board_director_name"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_name) ?>',1);"><div id="elh_board_directors_board_director_name" class="board_directors_board_director_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_designation->Visible) { // board_director_designation ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_designation) == "") { ?>
		<th data-name="board_director_designation"><div id="elh_board_directors_board_director_designation" class="board_directors_board_director_designation"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_designation->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_designation"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_designation) ?>',1);"><div id="elh_board_directors_board_director_designation" class="board_directors_board_director_designation">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_designation->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_designation->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_designation->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->sort_order->Visible) { // sort_order ?>
	<?php if ($board_directors->SortUrl($board_directors->sort_order) == "") { ?>
		<th data-name="sort_order"><div id="elh_board_directors_sort_order" class="board_directors_sort_order"><div class="ewTableHeaderCaption"><?php echo $board_directors->sort_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sort_order"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->sort_order) ?>',1);"><div id="elh_board_directors_sort_order" class="board_directors_sort_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->sort_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->sort_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->sort_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->status->Visible) { // status ?>
	<?php if ($board_directors->SortUrl($board_directors->status) == "") { ?>
		<th data-name="status"><div id="elh_board_directors_status" class="board_directors_status"><div class="ewTableHeaderCaption"><?php echo $board_directors->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->status) ?>',1);"><div id="elh_board_directors_status" class="board_directors_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_linkedin->Visible) { // board_director_linkedin ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_linkedin) == "") { ?>
		<th data-name="board_director_linkedin"><div id="elh_board_directors_board_director_linkedin" class="board_directors_board_director_linkedin"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_linkedin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_linkedin"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_linkedin) ?>',1);"><div id="elh_board_directors_board_director_linkedin" class="board_directors_board_director_linkedin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_linkedin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_linkedin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_linkedin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_facebook->Visible) { // board_director_facebook ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_facebook) == "") { ?>
		<th data-name="board_director_facebook"><div id="elh_board_directors_board_director_facebook" class="board_directors_board_director_facebook"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_facebook->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_facebook"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_facebook) ?>',1);"><div id="elh_board_directors_board_director_facebook" class="board_directors_board_director_facebook">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_facebook->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_facebook->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_facebook->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_twitter->Visible) { // board_director_twitter ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_twitter) == "") { ?>
		<th data-name="board_director_twitter"><div id="elh_board_directors_board_director_twitter" class="board_directors_board_director_twitter"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_twitter->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_twitter"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_twitter) ?>',1);"><div id="elh_board_directors_board_director_twitter" class="board_directors_board_director_twitter">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_twitter->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_twitter->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_twitter->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_email->Visible) { // board_director_email ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_email) == "") { ?>
		<th data-name="board_director_email"><div id="elh_board_directors_board_director_email" class="board_directors_board_director_email"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_email) ?>',1);"><div id="elh_board_directors_board_director_email" class="board_directors_board_director_email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($board_directors->board_director_phone->Visible) { // board_director_phone ?>
	<?php if ($board_directors->SortUrl($board_directors->board_director_phone) == "") { ?>
		<th data-name="board_director_phone"><div id="elh_board_directors_board_director_phone" class="board_directors_board_director_phone"><div class="ewTableHeaderCaption"><?php echo $board_directors->board_director_phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="board_director_phone"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $board_directors->SortUrl($board_directors->board_director_phone) ?>',1);"><div id="elh_board_directors_board_director_phone" class="board_directors_board_director_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $board_directors->board_director_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($board_directors->board_director_phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($board_directors->board_director_phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$board_directors_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($board_directors->ExportAll && $board_directors->Export <> "") {
	$board_directors_list->StopRec = $board_directors_list->TotalRecs;
} else {

	// Set the last record to display
	if ($board_directors_list->TotalRecs > $board_directors_list->StartRec + $board_directors_list->DisplayRecs - 1)
		$board_directors_list->StopRec = $board_directors_list->StartRec + $board_directors_list->DisplayRecs - 1;
	else
		$board_directors_list->StopRec = $board_directors_list->TotalRecs;
}
$board_directors_list->RecCnt = $board_directors_list->StartRec - 1;
if ($board_directors_list->Recordset && !$board_directors_list->Recordset->EOF) {
	$board_directors_list->Recordset->MoveFirst();
	$bSelectLimit = $board_directors_list->UseSelectLimit;
	if (!$bSelectLimit && $board_directors_list->StartRec > 1)
		$board_directors_list->Recordset->Move($board_directors_list->StartRec - 1);
} elseif (!$board_directors->AllowAddDeleteRow && $board_directors_list->StopRec == 0) {
	$board_directors_list->StopRec = $board_directors->GridAddRowCount;
}

// Initialize aggregate
$board_directors->RowType = EW_ROWTYPE_AGGREGATEINIT;
$board_directors->ResetAttrs();
$board_directors_list->RenderRow();
while ($board_directors_list->RecCnt < $board_directors_list->StopRec) {
	$board_directors_list->RecCnt++;
	if (intval($board_directors_list->RecCnt) >= intval($board_directors_list->StartRec)) {
		$board_directors_list->RowCnt++;

		// Set up key count
		$board_directors_list->KeyCount = $board_directors_list->RowIndex;

		// Init row class and style
		$board_directors->ResetAttrs();
		$board_directors->CssClass = "";
		if ($board_directors->CurrentAction == "gridadd") {
		} else {
			$board_directors_list->LoadRowValues($board_directors_list->Recordset); // Load row values
		}
		$board_directors->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$board_directors->RowAttrs = array_merge($board_directors->RowAttrs, array('data-rowindex'=>$board_directors_list->RowCnt, 'id'=>'r' . $board_directors_list->RowCnt . '_board_directors', 'data-rowtype'=>$board_directors->RowType));

		// Render row
		$board_directors_list->RenderRow();

		// Render list options
		$board_directors_list->RenderListOptions();
?>
	<tr<?php echo $board_directors->RowAttributes() ?>>
<?php

// Render list options (body, left)
$board_directors_list->ListOptions->Render("body", "left", $board_directors_list->RowCnt);
?>
	<?php if ($board_directors->board_director_id->Visible) { // board_director_id ?>
		<td data-name="board_director_id"<?php echo $board_directors->board_director_id->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_id" class="board_directors_board_director_id">
<span<?php echo $board_directors->board_director_id->ViewAttributes() ?>>
<?php echo $board_directors->board_director_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $board_directors_list->PageObjName . "_row_" . $board_directors_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($board_directors->board_director_pic->Visible) { // board_director_pic ?>
		<td data-name="board_director_pic"<?php echo $board_directors->board_director_pic->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_pic" class="board_directors_board_director_pic">
<span>
<?php echo ew_GetFileViewTag($board_directors->board_director_pic, $board_directors->board_director_pic->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_name->Visible) { // board_director_name ?>
		<td data-name="board_director_name"<?php echo $board_directors->board_director_name->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_name" class="board_directors_board_director_name">
<span<?php echo $board_directors->board_director_name->ViewAttributes() ?>>
<?php echo $board_directors->board_director_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_designation->Visible) { // board_director_designation ?>
		<td data-name="board_director_designation"<?php echo $board_directors->board_director_designation->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_designation" class="board_directors_board_director_designation">
<span<?php echo $board_directors->board_director_designation->ViewAttributes() ?>>
<?php echo $board_directors->board_director_designation->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->sort_order->Visible) { // sort_order ?>
		<td data-name="sort_order"<?php echo $board_directors->sort_order->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_sort_order" class="board_directors_sort_order">
<span<?php echo $board_directors->sort_order->ViewAttributes() ?>>
<?php echo $board_directors->sort_order->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->status->Visible) { // status ?>
		<td data-name="status"<?php echo $board_directors->status->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_status" class="board_directors_status">
<span<?php echo $board_directors->status->ViewAttributes() ?>>
<?php echo $board_directors->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_linkedin->Visible) { // board_director_linkedin ?>
		<td data-name="board_director_linkedin"<?php echo $board_directors->board_director_linkedin->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_linkedin" class="board_directors_board_director_linkedin">
<span<?php echo $board_directors->board_director_linkedin->ViewAttributes() ?>>
<?php echo $board_directors->board_director_linkedin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_facebook->Visible) { // board_director_facebook ?>
		<td data-name="board_director_facebook"<?php echo $board_directors->board_director_facebook->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_facebook" class="board_directors_board_director_facebook">
<span<?php echo $board_directors->board_director_facebook->ViewAttributes() ?>>
<?php echo $board_directors->board_director_facebook->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_twitter->Visible) { // board_director_twitter ?>
		<td data-name="board_director_twitter"<?php echo $board_directors->board_director_twitter->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_twitter" class="board_directors_board_director_twitter">
<span<?php echo $board_directors->board_director_twitter->ViewAttributes() ?>>
<?php echo $board_directors->board_director_twitter->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_email->Visible) { // board_director_email ?>
		<td data-name="board_director_email"<?php echo $board_directors->board_director_email->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_email" class="board_directors_board_director_email">
<span<?php echo $board_directors->board_director_email->ViewAttributes() ?>>
<?php echo $board_directors->board_director_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($board_directors->board_director_phone->Visible) { // board_director_phone ?>
		<td data-name="board_director_phone"<?php echo $board_directors->board_director_phone->CellAttributes() ?>>
<span id="el<?php echo $board_directors_list->RowCnt ?>_board_directors_board_director_phone" class="board_directors_board_director_phone">
<span<?php echo $board_directors->board_director_phone->ViewAttributes() ?>>
<?php echo $board_directors->board_director_phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$board_directors_list->ListOptions->Render("body", "right", $board_directors_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($board_directors->CurrentAction <> "gridadd")
		$board_directors_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($board_directors->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($board_directors_list->Recordset)
	$board_directors_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($board_directors->CurrentAction <> "gridadd" && $board_directors->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($board_directors_list->Pager)) $board_directors_list->Pager = new cPrevNextPager($board_directors_list->StartRec, $board_directors_list->DisplayRecs, $board_directors_list->TotalRecs) ?>
<?php if ($board_directors_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($board_directors_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $board_directors_list->PageUrl() ?>start=<?php echo $board_directors_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($board_directors_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $board_directors_list->PageUrl() ?>start=<?php echo $board_directors_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $board_directors_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($board_directors_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $board_directors_list->PageUrl() ?>start=<?php echo $board_directors_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($board_directors_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $board_directors_list->PageUrl() ?>start=<?php echo $board_directors_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $board_directors_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $board_directors_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $board_directors_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $board_directors_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($board_directors_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($board_directors_list->TotalRecs == 0 && $board_directors->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($board_directors_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fboard_directorslistsrch.Init();
fboard_directorslistsrch.FilterList = <?php echo $board_directors_list->GetFilterList() ?>;
fboard_directorslist.Init();
</script>
<?php
$board_directors_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$board_directors_list->Page_Terminate();
?>
