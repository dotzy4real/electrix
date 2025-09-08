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

$board_directors_add = NULL; // Initialize page object first

class cboard_directors_add extends cboard_directors {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'board_directors';

	// Page object name
	var $PageObjName = 'board_directors_add';

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

		// Table object (board_directors)
		if (!isset($GLOBALS["board_directors"]) || get_class($GLOBALS["board_directors"]) == "cboard_directors") {
			$GLOBALS["board_directors"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["board_directors"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'board_directors', TRUE);

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
			if (@$_GET["board_director_id"] != "") {
				$this->board_director_id->setQueryStringValue($_GET["board_director_id"]);
				$this->setKey("board_director_id", $this->board_director_id->CurrentValue); // Set up key
			} else {
				$this->setKey("board_director_id", ""); // Clear key
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
					$this->Page_Terminate("board_directorslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "board_directorsview.php")
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
		$this->board_director_pic->Upload->Index = $objForm->Index;
		$this->board_director_pic->Upload->UploadFile();
		$this->board_director_pic->CurrentValue = $this->board_director_pic->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->board_director_pic->Upload->DbValue = NULL;
		$this->board_director_pic->OldValue = $this->board_director_pic->Upload->DbValue;
		$this->board_director_pic->CurrentValue = NULL; // Clear file related field
		$this->board_director_name->CurrentValue = NULL;
		$this->board_director_name->OldValue = $this->board_director_name->CurrentValue;
		$this->board_director_designation->CurrentValue = NULL;
		$this->board_director_designation->OldValue = $this->board_director_designation->CurrentValue;
		$this->board_director_content->CurrentValue = NULL;
		$this->board_director_content->OldValue = $this->board_director_content->CurrentValue;
		$this->sort_order->CurrentValue = NULL;
		$this->sort_order->OldValue = $this->sort_order->CurrentValue;
		$this->status->CurrentValue = "active";
		$this->board_director_linkedin->CurrentValue = NULL;
		$this->board_director_linkedin->OldValue = $this->board_director_linkedin->CurrentValue;
		$this->board_director_facebook->CurrentValue = NULL;
		$this->board_director_facebook->OldValue = $this->board_director_facebook->CurrentValue;
		$this->board_director_twitter->CurrentValue = NULL;
		$this->board_director_twitter->OldValue = $this->board_director_twitter->CurrentValue;
		$this->board_director_email->CurrentValue = NULL;
		$this->board_director_email->OldValue = $this->board_director_email->CurrentValue;
		$this->board_director_phone->CurrentValue = NULL;
		$this->board_director_phone->OldValue = $this->board_director_phone->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->board_director_name->FldIsDetailKey) {
			$this->board_director_name->setFormValue($objForm->GetValue("x_board_director_name"));
		}
		if (!$this->board_director_designation->FldIsDetailKey) {
			$this->board_director_designation->setFormValue($objForm->GetValue("x_board_director_designation"));
		}
		if (!$this->board_director_content->FldIsDetailKey) {
			$this->board_director_content->setFormValue($objForm->GetValue("x_board_director_content"));
		}
		if (!$this->sort_order->FldIsDetailKey) {
			$this->sort_order->setFormValue($objForm->GetValue("x_sort_order"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->board_director_linkedin->FldIsDetailKey) {
			$this->board_director_linkedin->setFormValue($objForm->GetValue("x_board_director_linkedin"));
		}
		if (!$this->board_director_facebook->FldIsDetailKey) {
			$this->board_director_facebook->setFormValue($objForm->GetValue("x_board_director_facebook"));
		}
		if (!$this->board_director_twitter->FldIsDetailKey) {
			$this->board_director_twitter->setFormValue($objForm->GetValue("x_board_director_twitter"));
		}
		if (!$this->board_director_email->FldIsDetailKey) {
			$this->board_director_email->setFormValue($objForm->GetValue("x_board_director_email"));
		}
		if (!$this->board_director_phone->FldIsDetailKey) {
			$this->board_director_phone->setFormValue($objForm->GetValue("x_board_director_phone"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->board_director_name->CurrentValue = $this->board_director_name->FormValue;
		$this->board_director_designation->CurrentValue = $this->board_director_designation->FormValue;
		$this->board_director_content->CurrentValue = $this->board_director_content->FormValue;
		$this->sort_order->CurrentValue = $this->sort_order->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->board_director_linkedin->CurrentValue = $this->board_director_linkedin->FormValue;
		$this->board_director_facebook->CurrentValue = $this->board_director_facebook->FormValue;
		$this->board_director_twitter->CurrentValue = $this->board_director_twitter->FormValue;
		$this->board_director_email->CurrentValue = $this->board_director_email->FormValue;
		$this->board_director_phone->CurrentValue = $this->board_director_phone->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// board_director_pic
			$this->board_director_pic->EditAttrs["class"] = "form-control";
			$this->board_director_pic->EditCustomAttributes = "";
			$this->board_director_pic->UploadPath = '../src/assets/images/resource/board_members';
			if (!ew_Empty($this->board_director_pic->Upload->DbValue)) {
				$this->board_director_pic->ImageWidth = 105;
				$this->board_director_pic->ImageHeight = 120;
				$this->board_director_pic->ImageAlt = $this->board_director_pic->FldAlt();
				$this->board_director_pic->EditValue = $this->board_director_pic->Upload->DbValue;
			} else {
				$this->board_director_pic->EditValue = "";
			}
			if (!ew_Empty($this->board_director_pic->CurrentValue))
				$this->board_director_pic->Upload->FileName = $this->board_director_pic->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->board_director_pic);

			// board_director_name
			$this->board_director_name->EditAttrs["class"] = "form-control";
			$this->board_director_name->EditCustomAttributes = "";
			$this->board_director_name->EditValue = ew_HtmlEncode($this->board_director_name->CurrentValue);
			$this->board_director_name->PlaceHolder = ew_RemoveHtml($this->board_director_name->FldCaption());

			// board_director_designation
			$this->board_director_designation->EditAttrs["class"] = "form-control";
			$this->board_director_designation->EditCustomAttributes = "";
			$this->board_director_designation->EditValue = ew_HtmlEncode($this->board_director_designation->CurrentValue);
			$this->board_director_designation->PlaceHolder = ew_RemoveHtml($this->board_director_designation->FldCaption());

			// board_director_content
			$this->board_director_content->EditAttrs["class"] = "form-control";
			$this->board_director_content->EditCustomAttributes = "";
			$this->board_director_content->EditValue = ew_HtmlEncode($this->board_director_content->CurrentValue);
			$this->board_director_content->PlaceHolder = ew_RemoveHtml($this->board_director_content->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// board_director_linkedin
			$this->board_director_linkedin->EditAttrs["class"] = "form-control";
			$this->board_director_linkedin->EditCustomAttributes = "";
			$this->board_director_linkedin->EditValue = ew_HtmlEncode($this->board_director_linkedin->CurrentValue);
			$this->board_director_linkedin->PlaceHolder = ew_RemoveHtml($this->board_director_linkedin->FldCaption());

			// board_director_facebook
			$this->board_director_facebook->EditAttrs["class"] = "form-control";
			$this->board_director_facebook->EditCustomAttributes = "";
			$this->board_director_facebook->EditValue = ew_HtmlEncode($this->board_director_facebook->CurrentValue);
			$this->board_director_facebook->PlaceHolder = ew_RemoveHtml($this->board_director_facebook->FldCaption());

			// board_director_twitter
			$this->board_director_twitter->EditAttrs["class"] = "form-control";
			$this->board_director_twitter->EditCustomAttributes = "";
			$this->board_director_twitter->EditValue = ew_HtmlEncode($this->board_director_twitter->CurrentValue);
			$this->board_director_twitter->PlaceHolder = ew_RemoveHtml($this->board_director_twitter->FldCaption());

			// board_director_email
			$this->board_director_email->EditAttrs["class"] = "form-control";
			$this->board_director_email->EditCustomAttributes = "";
			$this->board_director_email->EditValue = ew_HtmlEncode($this->board_director_email->CurrentValue);
			$this->board_director_email->PlaceHolder = ew_RemoveHtml($this->board_director_email->FldCaption());

			// board_director_phone
			$this->board_director_phone->EditAttrs["class"] = "form-control";
			$this->board_director_phone->EditCustomAttributes = "";
			$this->board_director_phone->EditValue = ew_HtmlEncode($this->board_director_phone->CurrentValue);
			$this->board_director_phone->PlaceHolder = ew_RemoveHtml($this->board_director_phone->FldCaption());

			// Edit refer script
			// board_director_pic

			$this->board_director_pic->UploadPath = '../src/assets/images/resource/board_members';
			if (!ew_Empty($this->board_director_pic->Upload->DbValue)) {
				$this->board_director_pic->HrefValue = ew_GetFileUploadUrl($this->board_director_pic, $this->board_director_pic->Upload->DbValue); // Add prefix/suffix
				$this->board_director_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->board_director_pic->HrefValue = ew_ConvertFullUrl($this->board_director_pic->HrefValue);
			} else {
				$this->board_director_pic->HrefValue = "";
			}
			$this->board_director_pic->HrefValue2 = $this->board_director_pic->UploadPath . $this->board_director_pic->Upload->DbValue;

			// board_director_name
			$this->board_director_name->HrefValue = "";

			// board_director_designation
			$this->board_director_designation->HrefValue = "";

			// board_director_content
			$this->board_director_content->HrefValue = "";

			// sort_order
			$this->sort_order->HrefValue = "";

			// status
			$this->status->HrefValue = "";

			// board_director_linkedin
			$this->board_director_linkedin->HrefValue = "";

			// board_director_facebook
			$this->board_director_facebook->HrefValue = "";

			// board_director_twitter
			$this->board_director_twitter->HrefValue = "";

			// board_director_email
			$this->board_director_email->HrefValue = "";

			// board_director_phone
			$this->board_director_phone->HrefValue = "";
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
		if ($this->board_director_pic->Upload->FileName == "" && !$this->board_director_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->board_director_pic->FldCaption(), $this->board_director_pic->ReqErrMsg));
		}
		if (!$this->board_director_name->FldIsDetailKey && !is_null($this->board_director_name->FormValue) && $this->board_director_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->board_director_name->FldCaption(), $this->board_director_name->ReqErrMsg));
		}
		if (!$this->board_director_designation->FldIsDetailKey && !is_null($this->board_director_designation->FormValue) && $this->board_director_designation->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->board_director_designation->FldCaption(), $this->board_director_designation->ReqErrMsg));
		}
		if (!$this->board_director_content->FldIsDetailKey && !is_null($this->board_director_content->FormValue) && $this->board_director_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->board_director_content->FldCaption(), $this->board_director_content->ReqErrMsg));
		}
		if (!$this->sort_order->FldIsDetailKey && !is_null($this->sort_order->FormValue) && $this->sort_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sort_order->FldCaption(), $this->sort_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sort_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->sort_order->FldErrMsg());
		}
		if ($this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!$this->board_director_email->FldIsDetailKey && !is_null($this->board_director_email->FormValue) && $this->board_director_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->board_director_email->FldCaption(), $this->board_director_email->ReqErrMsg));
		}
		if (!$this->board_director_phone->FldIsDetailKey && !is_null($this->board_director_phone->FormValue) && $this->board_director_phone->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->board_director_phone->FldCaption(), $this->board_director_phone->ReqErrMsg));
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
			$this->board_director_pic->OldUploadPath = '../src/assets/images/resource/board_members';
			$this->board_director_pic->UploadPath = $this->board_director_pic->OldUploadPath;
		}
		$rsnew = array();

		// board_director_pic
		if (!$this->board_director_pic->Upload->KeepFile) {
			$this->board_director_pic->Upload->DbValue = ""; // No need to delete old file
			if ($this->board_director_pic->Upload->FileName == "") {
				$rsnew['board_director_pic'] = NULL;
			} else {
				$rsnew['board_director_pic'] = $this->board_director_pic->Upload->FileName;
			}
		}

		// board_director_name
		$this->board_director_name->SetDbValueDef($rsnew, $this->board_director_name->CurrentValue, "", FALSE);

		// board_director_designation
		$this->board_director_designation->SetDbValueDef($rsnew, $this->board_director_designation->CurrentValue, "", FALSE);

		// board_director_content
		$this->board_director_content->SetDbValueDef($rsnew, $this->board_director_content->CurrentValue, "", FALSE);

		// sort_order
		$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");

		// board_director_linkedin
		$this->board_director_linkedin->SetDbValueDef($rsnew, $this->board_director_linkedin->CurrentValue, NULL, FALSE);

		// board_director_facebook
		$this->board_director_facebook->SetDbValueDef($rsnew, $this->board_director_facebook->CurrentValue, NULL, FALSE);

		// board_director_twitter
		$this->board_director_twitter->SetDbValueDef($rsnew, $this->board_director_twitter->CurrentValue, NULL, FALSE);

		// board_director_email
		$this->board_director_email->SetDbValueDef($rsnew, $this->board_director_email->CurrentValue, "", FALSE);

		// board_director_phone
		$this->board_director_phone->SetDbValueDef($rsnew, $this->board_director_phone->CurrentValue, "", FALSE);
		if (!$this->board_director_pic->Upload->KeepFile) {
			$this->board_director_pic->UploadPath = '../src/assets/images/resource/board_members';
			if (!ew_Empty($this->board_director_pic->Upload->Value)) {
				$rsnew['board_director_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->board_director_pic->UploadPath), $rsnew['board_director_pic']); // Get new file name
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
				$this->board_director_id->setDbValue($conn->Insert_ID());
				$rsnew['board_director_id'] = $this->board_director_id->DbValue;
				if (!$this->board_director_pic->Upload->KeepFile) {
					if (!ew_Empty($this->board_director_pic->Upload->Value)) {
						$this->board_director_pic->Upload->SaveToFile($this->board_director_pic->UploadPath, $rsnew['board_director_pic'], TRUE);
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

		// board_director_pic
		ew_CleanUploadTempPath($this->board_director_pic, $this->board_director_pic->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "board_directorslist.php", "", $this->TableVar, TRUE);
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
if (!isset($board_directors_add)) $board_directors_add = new cboard_directors_add();

// Page init
$board_directors_add->Page_Init();

// Page main
$board_directors_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$board_directors_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fboard_directorsadd = new ew_Form("fboard_directorsadd", "add");

// Validate form
fboard_directorsadd.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_board_director_pic");
			elm = this.GetElements("fn_x" + infix + "_board_director_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->board_director_pic->FldCaption(), $board_directors->board_director_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_board_director_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->board_director_name->FldCaption(), $board_directors->board_director_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_board_director_designation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->board_director_designation->FldCaption(), $board_directors->board_director_designation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_board_director_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->board_director_content->FldCaption(), $board_directors->board_director_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->sort_order->FldCaption(), $board_directors->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($board_directors->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->status->FldCaption(), $board_directors->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_board_director_email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->board_director_email->FldCaption(), $board_directors->board_director_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_board_director_phone");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $board_directors->board_director_phone->FldCaption(), $board_directors->board_director_phone->ReqErrMsg)) ?>");

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
fboard_directorsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fboard_directorsadd.ValidateRequired = true;
<?php } else { ?>
fboard_directorsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fboard_directorsadd.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fboard_directorsadd.Lists["x_status"].Options = <?php echo json_encode($board_directors->status->Options()) ?>;

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
<?php $board_directors_add->ShowPageHeader(); ?>
<?php
$board_directors_add->ShowMessage();
?>
<form name="fboard_directorsadd" id="fboard_directorsadd" class="<?php echo $board_directors_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($board_directors_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $board_directors_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="board_directors">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($board_directors->board_director_pic->Visible) { // board_director_pic ?>
	<div id="r_board_director_pic" class="form-group">
		<label id="elh_board_directors_board_director_pic" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_pic->CellAttributes() ?>>
<span id="el_board_directors_board_director_pic">
<div id="fd_x_board_director_pic">
<span title="<?php echo $board_directors->board_director_pic->FldTitle() ? $board_directors->board_director_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($board_directors->board_director_pic->ReadOnly || $board_directors->board_director_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="board_directors" data-field="x_board_director_pic" name="x_board_director_pic" id="x_board_director_pic"<?php echo $board_directors->board_director_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_board_director_pic" id= "fn_x_board_director_pic" value="<?php echo $board_directors->board_director_pic->Upload->FileName ?>">
<input type="hidden" name="fa_x_board_director_pic" id= "fa_x_board_director_pic" value="0">
<input type="hidden" name="fs_x_board_director_pic" id= "fs_x_board_director_pic" value="255">
<input type="hidden" name="fx_x_board_director_pic" id= "fx_x_board_director_pic" value="<?php echo $board_directors->board_director_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_board_director_pic" id= "fm_x_board_director_pic" value="<?php echo $board_directors->board_director_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_board_director_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $board_directors->board_director_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_name->Visible) { // board_director_name ?>
	<div id="r_board_director_name" class="form-group">
		<label id="elh_board_directors_board_director_name" for="x_board_director_name" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_name->CellAttributes() ?>>
<span id="el_board_directors_board_director_name">
<input type="text" data-table="board_directors" data-field="x_board_director_name" name="x_board_director_name" id="x_board_director_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_name->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_name->EditValue ?>"<?php echo $board_directors->board_director_name->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_designation->Visible) { // board_director_designation ?>
	<div id="r_board_director_designation" class="form-group">
		<label id="elh_board_directors_board_director_designation" for="x_board_director_designation" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_designation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_designation->CellAttributes() ?>>
<span id="el_board_directors_board_director_designation">
<input type="text" data-table="board_directors" data-field="x_board_director_designation" name="x_board_director_designation" id="x_board_director_designation" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_designation->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_designation->EditValue ?>"<?php echo $board_directors->board_director_designation->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_designation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_content->Visible) { // board_director_content ?>
	<div id="r_board_director_content" class="form-group">
		<label id="elh_board_directors_board_director_content" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_content->CellAttributes() ?>>
<span id="el_board_directors_board_director_content">
<?php ew_AppendClass($board_directors->board_director_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="board_directors" data-field="x_board_director_content" name="x_board_director_content" id="x_board_director_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_content->getPlaceHolder()) ?>"<?php echo $board_directors->board_director_content->EditAttributes() ?>><?php echo $board_directors->board_director_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fboard_directorsadd", "x_board_director_content", 35, 4, <?php echo ($board_directors->board_director_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $board_directors->board_director_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_board_directors_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->sort_order->CellAttributes() ?>>
<span id="el_board_directors_sort_order">
<input type="text" data-table="board_directors" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($board_directors->sort_order->getPlaceHolder()) ?>" value="<?php echo $board_directors->sort_order->EditValue ?>"<?php echo $board_directors->sort_order->EditAttributes() ?>>
</span>
<?php echo $board_directors->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_board_directors_status" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->status->CellAttributes() ?>>
<span id="el_board_directors_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="board_directors" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($board_directors->status->DisplayValueSeparator) ? json_encode($board_directors->status->DisplayValueSeparator) : $board_directors->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $board_directors->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $board_directors->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($board_directors->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
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
<?php echo $board_directors->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_linkedin->Visible) { // board_director_linkedin ?>
	<div id="r_board_director_linkedin" class="form-group">
		<label id="elh_board_directors_board_director_linkedin" for="x_board_director_linkedin" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_linkedin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_linkedin->CellAttributes() ?>>
<span id="el_board_directors_board_director_linkedin">
<input type="text" data-table="board_directors" data-field="x_board_director_linkedin" name="x_board_director_linkedin" id="x_board_director_linkedin" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_linkedin->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_linkedin->EditValue ?>"<?php echo $board_directors->board_director_linkedin->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_linkedin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_facebook->Visible) { // board_director_facebook ?>
	<div id="r_board_director_facebook" class="form-group">
		<label id="elh_board_directors_board_director_facebook" for="x_board_director_facebook" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_facebook->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_facebook->CellAttributes() ?>>
<span id="el_board_directors_board_director_facebook">
<input type="text" data-table="board_directors" data-field="x_board_director_facebook" name="x_board_director_facebook" id="x_board_director_facebook" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_facebook->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_facebook->EditValue ?>"<?php echo $board_directors->board_director_facebook->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_facebook->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_twitter->Visible) { // board_director_twitter ?>
	<div id="r_board_director_twitter" class="form-group">
		<label id="elh_board_directors_board_director_twitter" for="x_board_director_twitter" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_twitter->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_twitter->CellAttributes() ?>>
<span id="el_board_directors_board_director_twitter">
<input type="text" data-table="board_directors" data-field="x_board_director_twitter" name="x_board_director_twitter" id="x_board_director_twitter" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_twitter->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_twitter->EditValue ?>"<?php echo $board_directors->board_director_twitter->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_twitter->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_email->Visible) { // board_director_email ?>
	<div id="r_board_director_email" class="form-group">
		<label id="elh_board_directors_board_director_email" for="x_board_director_email" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_email->CellAttributes() ?>>
<span id="el_board_directors_board_director_email">
<input type="text" data-table="board_directors" data-field="x_board_director_email" name="x_board_director_email" id="x_board_director_email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_email->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_email->EditValue ?>"<?php echo $board_directors->board_director_email->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($board_directors->board_director_phone->Visible) { // board_director_phone ?>
	<div id="r_board_director_phone" class="form-group">
		<label id="elh_board_directors_board_director_phone" for="x_board_director_phone" class="col-sm-2 control-label ewLabel"><?php echo $board_directors->board_director_phone->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $board_directors->board_director_phone->CellAttributes() ?>>
<span id="el_board_directors_board_director_phone">
<input type="text" data-table="board_directors" data-field="x_board_director_phone" name="x_board_director_phone" id="x_board_director_phone" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($board_directors->board_director_phone->getPlaceHolder()) ?>" value="<?php echo $board_directors->board_director_phone->EditValue ?>"<?php echo $board_directors->board_director_phone->EditAttributes() ?>>
</span>
<?php echo $board_directors->board_director_phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $board_directors_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fboard_directorsadd.Init();
</script>
<?php
$board_directors_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$board_directors_add->Page_Terminate();
?>
