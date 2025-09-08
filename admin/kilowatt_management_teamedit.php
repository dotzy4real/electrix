<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "kilowatt_management_teaminfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$kilowatt_management_team_edit = NULL; // Initialize page object first

class ckilowatt_management_team_edit extends ckilowatt_management_team {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'kilowatt_management_team';

	// Page object name
	var $PageObjName = 'kilowatt_management_team_edit';

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

		// Table object (kilowatt_management_team)
		if (!isset($GLOBALS["kilowatt_management_team"]) || get_class($GLOBALS["kilowatt_management_team"]) == "ckilowatt_management_team") {
			$GLOBALS["kilowatt_management_team"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["kilowatt_management_team"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'kilowatt_management_team', TRUE);

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
		$this->kilowatt_management_team_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $kilowatt_management_team;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($kilowatt_management_team);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["kilowatt_management_team_id"] <> "") {
			$this->kilowatt_management_team_id->setQueryStringValue($_GET["kilowatt_management_team_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->kilowatt_management_team_id->CurrentValue == "")
			$this->Page_Terminate("kilowatt_management_teamlist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("kilowatt_management_teamlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->kilowatt_management_team_pic->Upload->Index = $objForm->Index;
		$this->kilowatt_management_team_pic->Upload->UploadFile();
		$this->kilowatt_management_team_pic->CurrentValue = $this->kilowatt_management_team_pic->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->kilowatt_management_team_id->FldIsDetailKey)
			$this->kilowatt_management_team_id->setFormValue($objForm->GetValue("x_kilowatt_management_team_id"));
		if (!$this->kilowatt_management_team_name->FldIsDetailKey) {
			$this->kilowatt_management_team_name->setFormValue($objForm->GetValue("x_kilowatt_management_team_name"));
		}
		if (!$this->kilowatt_management_team_designation->FldIsDetailKey) {
			$this->kilowatt_management_team_designation->setFormValue($objForm->GetValue("x_kilowatt_management_team_designation"));
		}
		if (!$this->kilowatt_management_team_content->FldIsDetailKey) {
			$this->kilowatt_management_team_content->setFormValue($objForm->GetValue("x_kilowatt_management_team_content"));
		}
		if (!$this->sort_order->FldIsDetailKey) {
			$this->sort_order->setFormValue($objForm->GetValue("x_sort_order"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->kilowatt_management_team_linkedin->FldIsDetailKey) {
			$this->kilowatt_management_team_linkedin->setFormValue($objForm->GetValue("x_kilowatt_management_team_linkedin"));
		}
		if (!$this->kilowatt_management_team_facebook->FldIsDetailKey) {
			$this->kilowatt_management_team_facebook->setFormValue($objForm->GetValue("x_kilowatt_management_team_facebook"));
		}
		if (!$this->kilowatt_management_team_twitter->FldIsDetailKey) {
			$this->kilowatt_management_team_twitter->setFormValue($objForm->GetValue("x_kilowatt_management_team_twitter"));
		}
		if (!$this->kilowatt_management_team_email->FldIsDetailKey) {
			$this->kilowatt_management_team_email->setFormValue($objForm->GetValue("x_kilowatt_management_team_email"));
		}
		if (!$this->kilowatt_management_team_phone->FldIsDetailKey) {
			$this->kilowatt_management_team_phone->setFormValue($objForm->GetValue("x_kilowatt_management_team_phone"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->kilowatt_management_team_id->CurrentValue = $this->kilowatt_management_team_id->FormValue;
		$this->kilowatt_management_team_name->CurrentValue = $this->kilowatt_management_team_name->FormValue;
		$this->kilowatt_management_team_designation->CurrentValue = $this->kilowatt_management_team_designation->FormValue;
		$this->kilowatt_management_team_content->CurrentValue = $this->kilowatt_management_team_content->FormValue;
		$this->sort_order->CurrentValue = $this->sort_order->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->kilowatt_management_team_linkedin->CurrentValue = $this->kilowatt_management_team_linkedin->FormValue;
		$this->kilowatt_management_team_facebook->CurrentValue = $this->kilowatt_management_team_facebook->FormValue;
		$this->kilowatt_management_team_twitter->CurrentValue = $this->kilowatt_management_team_twitter->FormValue;
		$this->kilowatt_management_team_email->CurrentValue = $this->kilowatt_management_team_email->FormValue;
		$this->kilowatt_management_team_phone->CurrentValue = $this->kilowatt_management_team_phone->FormValue;
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
		$this->kilowatt_management_team_id->setDbValue($rs->fields('kilowatt_management_team_id'));
		$this->kilowatt_management_team_pic->Upload->DbValue = $rs->fields('kilowatt_management_team_pic');
		$this->kilowatt_management_team_pic->CurrentValue = $this->kilowatt_management_team_pic->Upload->DbValue;
		$this->kilowatt_management_team_name->setDbValue($rs->fields('kilowatt_management_team_name'));
		$this->kilowatt_management_team_designation->setDbValue($rs->fields('kilowatt_management_team_designation'));
		$this->kilowatt_management_team_content->setDbValue($rs->fields('kilowatt_management_team_content'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
		$this->kilowatt_management_team_linkedin->setDbValue($rs->fields('kilowatt_management_team_linkedin'));
		$this->kilowatt_management_team_facebook->setDbValue($rs->fields('kilowatt_management_team_facebook'));
		$this->kilowatt_management_team_twitter->setDbValue($rs->fields('kilowatt_management_team_twitter'));
		$this->kilowatt_management_team_email->setDbValue($rs->fields('kilowatt_management_team_email'));
		$this->kilowatt_management_team_phone->setDbValue($rs->fields('kilowatt_management_team_phone'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kilowatt_management_team_id->DbValue = $row['kilowatt_management_team_id'];
		$this->kilowatt_management_team_pic->Upload->DbValue = $row['kilowatt_management_team_pic'];
		$this->kilowatt_management_team_name->DbValue = $row['kilowatt_management_team_name'];
		$this->kilowatt_management_team_designation->DbValue = $row['kilowatt_management_team_designation'];
		$this->kilowatt_management_team_content->DbValue = $row['kilowatt_management_team_content'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
		$this->kilowatt_management_team_linkedin->DbValue = $row['kilowatt_management_team_linkedin'];
		$this->kilowatt_management_team_facebook->DbValue = $row['kilowatt_management_team_facebook'];
		$this->kilowatt_management_team_twitter->DbValue = $row['kilowatt_management_team_twitter'];
		$this->kilowatt_management_team_email->DbValue = $row['kilowatt_management_team_email'];
		$this->kilowatt_management_team_phone->DbValue = $row['kilowatt_management_team_phone'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// kilowatt_management_team_id
		// kilowatt_management_team_pic
		// kilowatt_management_team_name
		// kilowatt_management_team_designation
		// kilowatt_management_team_content
		// sort_order
		// status
		// kilowatt_management_team_linkedin
		// kilowatt_management_team_facebook
		// kilowatt_management_team_twitter
		// kilowatt_management_team_email
		// kilowatt_management_team_phone

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kilowatt_management_team_id
		$this->kilowatt_management_team_id->ViewValue = $this->kilowatt_management_team_id->CurrentValue;
		$this->kilowatt_management_team_id->ViewCustomAttributes = "";

		// kilowatt_management_team_pic
		$this->kilowatt_management_team_pic->UploadPath = '../src/assets/images/kilowatt/team';
		if (!ew_Empty($this->kilowatt_management_team_pic->Upload->DbValue)) {
			$this->kilowatt_management_team_pic->ImageWidth = 100;
			$this->kilowatt_management_team_pic->ImageHeight = 120;
			$this->kilowatt_management_team_pic->ImageAlt = $this->kilowatt_management_team_pic->FldAlt();
			$this->kilowatt_management_team_pic->ViewValue = $this->kilowatt_management_team_pic->Upload->DbValue;
		} else {
			$this->kilowatt_management_team_pic->ViewValue = "";
		}
		$this->kilowatt_management_team_pic->ViewCustomAttributes = "";

		// kilowatt_management_team_name
		$this->kilowatt_management_team_name->ViewValue = $this->kilowatt_management_team_name->CurrentValue;
		$this->kilowatt_management_team_name->ViewCustomAttributes = "";

		// kilowatt_management_team_designation
		$this->kilowatt_management_team_designation->ViewValue = $this->kilowatt_management_team_designation->CurrentValue;
		$this->kilowatt_management_team_designation->ViewCustomAttributes = "";

		// kilowatt_management_team_content
		$this->kilowatt_management_team_content->ViewValue = $this->kilowatt_management_team_content->CurrentValue;
		$this->kilowatt_management_team_content->ViewCustomAttributes = "";

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

		// kilowatt_management_team_linkedin
		$this->kilowatt_management_team_linkedin->ViewValue = $this->kilowatt_management_team_linkedin->CurrentValue;
		$this->kilowatt_management_team_linkedin->ViewCustomAttributes = "";

		// kilowatt_management_team_facebook
		$this->kilowatt_management_team_facebook->ViewValue = $this->kilowatt_management_team_facebook->CurrentValue;
		$this->kilowatt_management_team_facebook->ViewCustomAttributes = "";

		// kilowatt_management_team_twitter
		$this->kilowatt_management_team_twitter->ViewValue = $this->kilowatt_management_team_twitter->CurrentValue;
		$this->kilowatt_management_team_twitter->ViewCustomAttributes = "";

		// kilowatt_management_team_email
		$this->kilowatt_management_team_email->ViewValue = $this->kilowatt_management_team_email->CurrentValue;
		$this->kilowatt_management_team_email->ViewCustomAttributes = "";

		// kilowatt_management_team_phone
		$this->kilowatt_management_team_phone->ViewValue = $this->kilowatt_management_team_phone->CurrentValue;
		$this->kilowatt_management_team_phone->ViewCustomAttributes = "";

			// kilowatt_management_team_id
			$this->kilowatt_management_team_id->LinkCustomAttributes = "";
			$this->kilowatt_management_team_id->HrefValue = "";
			$this->kilowatt_management_team_id->TooltipValue = "";

			// kilowatt_management_team_pic
			$this->kilowatt_management_team_pic->LinkCustomAttributes = "";
			$this->kilowatt_management_team_pic->UploadPath = '../src/assets/images/kilowatt/team';
			if (!ew_Empty($this->kilowatt_management_team_pic->Upload->DbValue)) {
				$this->kilowatt_management_team_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_management_team_pic, $this->kilowatt_management_team_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_management_team_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_management_team_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_management_team_pic->HrefValue);
			} else {
				$this->kilowatt_management_team_pic->HrefValue = "";
			}
			$this->kilowatt_management_team_pic->HrefValue2 = $this->kilowatt_management_team_pic->UploadPath . $this->kilowatt_management_team_pic->Upload->DbValue;
			$this->kilowatt_management_team_pic->TooltipValue = "";
			if ($this->kilowatt_management_team_pic->UseColorbox) {
				$this->kilowatt_management_team_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->kilowatt_management_team_pic->LinkAttrs["data-rel"] = "kilowatt_management_team_x_kilowatt_management_team_pic";

				//$this->kilowatt_management_team_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->kilowatt_management_team_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->kilowatt_management_team_pic->LinkAttrs["data-container"] = "body";

				$this->kilowatt_management_team_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// kilowatt_management_team_name
			$this->kilowatt_management_team_name->LinkCustomAttributes = "";
			$this->kilowatt_management_team_name->HrefValue = "";
			$this->kilowatt_management_team_name->TooltipValue = "";

			// kilowatt_management_team_designation
			$this->kilowatt_management_team_designation->LinkCustomAttributes = "";
			$this->kilowatt_management_team_designation->HrefValue = "";
			$this->kilowatt_management_team_designation->TooltipValue = "";

			// kilowatt_management_team_content
			$this->kilowatt_management_team_content->LinkCustomAttributes = "";
			$this->kilowatt_management_team_content->HrefValue = "";
			$this->kilowatt_management_team_content->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// kilowatt_management_team_linkedin
			$this->kilowatt_management_team_linkedin->LinkCustomAttributes = "";
			$this->kilowatt_management_team_linkedin->HrefValue = "";
			$this->kilowatt_management_team_linkedin->TooltipValue = "";

			// kilowatt_management_team_facebook
			$this->kilowatt_management_team_facebook->LinkCustomAttributes = "";
			$this->kilowatt_management_team_facebook->HrefValue = "";
			$this->kilowatt_management_team_facebook->TooltipValue = "";

			// kilowatt_management_team_twitter
			$this->kilowatt_management_team_twitter->LinkCustomAttributes = "";
			$this->kilowatt_management_team_twitter->HrefValue = "";
			$this->kilowatt_management_team_twitter->TooltipValue = "";

			// kilowatt_management_team_email
			$this->kilowatt_management_team_email->LinkCustomAttributes = "";
			$this->kilowatt_management_team_email->HrefValue = "";
			$this->kilowatt_management_team_email->TooltipValue = "";

			// kilowatt_management_team_phone
			$this->kilowatt_management_team_phone->LinkCustomAttributes = "";
			$this->kilowatt_management_team_phone->HrefValue = "";
			$this->kilowatt_management_team_phone->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// kilowatt_management_team_id
			$this->kilowatt_management_team_id->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_id->EditCustomAttributes = "";
			$this->kilowatt_management_team_id->EditValue = $this->kilowatt_management_team_id->CurrentValue;
			$this->kilowatt_management_team_id->ViewCustomAttributes = "";

			// kilowatt_management_team_pic
			$this->kilowatt_management_team_pic->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_pic->EditCustomAttributes = "";
			$this->kilowatt_management_team_pic->UploadPath = '../src/assets/images/kilowatt/team';
			if (!ew_Empty($this->kilowatt_management_team_pic->Upload->DbValue)) {
				$this->kilowatt_management_team_pic->ImageWidth = 100;
				$this->kilowatt_management_team_pic->ImageHeight = 120;
				$this->kilowatt_management_team_pic->ImageAlt = $this->kilowatt_management_team_pic->FldAlt();
				$this->kilowatt_management_team_pic->EditValue = $this->kilowatt_management_team_pic->Upload->DbValue;
			} else {
				$this->kilowatt_management_team_pic->EditValue = "";
			}
			if (!ew_Empty($this->kilowatt_management_team_pic->CurrentValue))
				$this->kilowatt_management_team_pic->Upload->FileName = $this->kilowatt_management_team_pic->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->kilowatt_management_team_pic);

			// kilowatt_management_team_name
			$this->kilowatt_management_team_name->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_name->EditCustomAttributes = "";
			$this->kilowatt_management_team_name->EditValue = ew_HtmlEncode($this->kilowatt_management_team_name->CurrentValue);
			$this->kilowatt_management_team_name->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_name->FldCaption());

			// kilowatt_management_team_designation
			$this->kilowatt_management_team_designation->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_designation->EditCustomAttributes = "";
			$this->kilowatt_management_team_designation->EditValue = ew_HtmlEncode($this->kilowatt_management_team_designation->CurrentValue);
			$this->kilowatt_management_team_designation->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_designation->FldCaption());

			// kilowatt_management_team_content
			$this->kilowatt_management_team_content->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_content->EditCustomAttributes = "";
			$this->kilowatt_management_team_content->EditValue = ew_HtmlEncode($this->kilowatt_management_team_content->CurrentValue);
			$this->kilowatt_management_team_content->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_content->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// kilowatt_management_team_linkedin
			$this->kilowatt_management_team_linkedin->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_linkedin->EditCustomAttributes = "";
			$this->kilowatt_management_team_linkedin->EditValue = ew_HtmlEncode($this->kilowatt_management_team_linkedin->CurrentValue);
			$this->kilowatt_management_team_linkedin->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_linkedin->FldCaption());

			// kilowatt_management_team_facebook
			$this->kilowatt_management_team_facebook->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_facebook->EditCustomAttributes = "";
			$this->kilowatt_management_team_facebook->EditValue = ew_HtmlEncode($this->kilowatt_management_team_facebook->CurrentValue);
			$this->kilowatt_management_team_facebook->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_facebook->FldCaption());

			// kilowatt_management_team_twitter
			$this->kilowatt_management_team_twitter->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_twitter->EditCustomAttributes = "";
			$this->kilowatt_management_team_twitter->EditValue = ew_HtmlEncode($this->kilowatt_management_team_twitter->CurrentValue);
			$this->kilowatt_management_team_twitter->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_twitter->FldCaption());

			// kilowatt_management_team_email
			$this->kilowatt_management_team_email->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_email->EditCustomAttributes = "";
			$this->kilowatt_management_team_email->EditValue = ew_HtmlEncode($this->kilowatt_management_team_email->CurrentValue);
			$this->kilowatt_management_team_email->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_email->FldCaption());

			// kilowatt_management_team_phone
			$this->kilowatt_management_team_phone->EditAttrs["class"] = "form-control";
			$this->kilowatt_management_team_phone->EditCustomAttributes = "";
			$this->kilowatt_management_team_phone->EditValue = ew_HtmlEncode($this->kilowatt_management_team_phone->CurrentValue);
			$this->kilowatt_management_team_phone->PlaceHolder = ew_RemoveHtml($this->kilowatt_management_team_phone->FldCaption());

			// Edit refer script
			// kilowatt_management_team_id

			$this->kilowatt_management_team_id->HrefValue = "";

			// kilowatt_management_team_pic
			$this->kilowatt_management_team_pic->UploadPath = '../src/assets/images/kilowatt/team';
			if (!ew_Empty($this->kilowatt_management_team_pic->Upload->DbValue)) {
				$this->kilowatt_management_team_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_management_team_pic, $this->kilowatt_management_team_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_management_team_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_management_team_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_management_team_pic->HrefValue);
			} else {
				$this->kilowatt_management_team_pic->HrefValue = "";
			}
			$this->kilowatt_management_team_pic->HrefValue2 = $this->kilowatt_management_team_pic->UploadPath . $this->kilowatt_management_team_pic->Upload->DbValue;

			// kilowatt_management_team_name
			$this->kilowatt_management_team_name->HrefValue = "";

			// kilowatt_management_team_designation
			$this->kilowatt_management_team_designation->HrefValue = "";

			// kilowatt_management_team_content
			$this->kilowatt_management_team_content->HrefValue = "";

			// sort_order
			$this->sort_order->HrefValue = "";

			// status
			$this->status->HrefValue = "";

			// kilowatt_management_team_linkedin
			$this->kilowatt_management_team_linkedin->HrefValue = "";

			// kilowatt_management_team_facebook
			$this->kilowatt_management_team_facebook->HrefValue = "";

			// kilowatt_management_team_twitter
			$this->kilowatt_management_team_twitter->HrefValue = "";

			// kilowatt_management_team_email
			$this->kilowatt_management_team_email->HrefValue = "";

			// kilowatt_management_team_phone
			$this->kilowatt_management_team_phone->HrefValue = "";
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
		if ($this->kilowatt_management_team_pic->Upload->FileName == "" && !$this->kilowatt_management_team_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_management_team_pic->FldCaption(), $this->kilowatt_management_team_pic->ReqErrMsg));
		}
		if (!$this->kilowatt_management_team_name->FldIsDetailKey && !is_null($this->kilowatt_management_team_name->FormValue) && $this->kilowatt_management_team_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_management_team_name->FldCaption(), $this->kilowatt_management_team_name->ReqErrMsg));
		}
		if (!$this->kilowatt_management_team_designation->FldIsDetailKey && !is_null($this->kilowatt_management_team_designation->FormValue) && $this->kilowatt_management_team_designation->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_management_team_designation->FldCaption(), $this->kilowatt_management_team_designation->ReqErrMsg));
		}
		if (!$this->kilowatt_management_team_content->FldIsDetailKey && !is_null($this->kilowatt_management_team_content->FormValue) && $this->kilowatt_management_team_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_management_team_content->FldCaption(), $this->kilowatt_management_team_content->ReqErrMsg));
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->kilowatt_management_team_pic->OldUploadPath = '../src/assets/images/kilowatt/team';
			$this->kilowatt_management_team_pic->UploadPath = $this->kilowatt_management_team_pic->OldUploadPath;
			$rsnew = array();

			// kilowatt_management_team_pic
			if (!($this->kilowatt_management_team_pic->ReadOnly) && !$this->kilowatt_management_team_pic->Upload->KeepFile) {
				$this->kilowatt_management_team_pic->Upload->DbValue = $rsold['kilowatt_management_team_pic']; // Get original value
				if ($this->kilowatt_management_team_pic->Upload->FileName == "") {
					$rsnew['kilowatt_management_team_pic'] = NULL;
				} else {
					$rsnew['kilowatt_management_team_pic'] = $this->kilowatt_management_team_pic->Upload->FileName;
				}
				$this->kilowatt_management_team_pic->ImageWidth = 277; // Resize width
				$this->kilowatt_management_team_pic->ImageHeight = 350; // Resize height
			}

			// kilowatt_management_team_name
			$this->kilowatt_management_team_name->SetDbValueDef($rsnew, $this->kilowatt_management_team_name->CurrentValue, "", $this->kilowatt_management_team_name->ReadOnly);

			// kilowatt_management_team_designation
			$this->kilowatt_management_team_designation->SetDbValueDef($rsnew, $this->kilowatt_management_team_designation->CurrentValue, "", $this->kilowatt_management_team_designation->ReadOnly);

			// kilowatt_management_team_content
			$this->kilowatt_management_team_content->SetDbValueDef($rsnew, $this->kilowatt_management_team_content->CurrentValue, "", $this->kilowatt_management_team_content->ReadOnly);

			// sort_order
			$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, $this->sort_order->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

			// kilowatt_management_team_linkedin
			$this->kilowatt_management_team_linkedin->SetDbValueDef($rsnew, $this->kilowatt_management_team_linkedin->CurrentValue, NULL, $this->kilowatt_management_team_linkedin->ReadOnly);

			// kilowatt_management_team_facebook
			$this->kilowatt_management_team_facebook->SetDbValueDef($rsnew, $this->kilowatt_management_team_facebook->CurrentValue, NULL, $this->kilowatt_management_team_facebook->ReadOnly);

			// kilowatt_management_team_twitter
			$this->kilowatt_management_team_twitter->SetDbValueDef($rsnew, $this->kilowatt_management_team_twitter->CurrentValue, NULL, $this->kilowatt_management_team_twitter->ReadOnly);

			// kilowatt_management_team_email
			$this->kilowatt_management_team_email->SetDbValueDef($rsnew, $this->kilowatt_management_team_email->CurrentValue, NULL, $this->kilowatt_management_team_email->ReadOnly);

			// kilowatt_management_team_phone
			$this->kilowatt_management_team_phone->SetDbValueDef($rsnew, $this->kilowatt_management_team_phone->CurrentValue, NULL, $this->kilowatt_management_team_phone->ReadOnly);
			if (!$this->kilowatt_management_team_pic->Upload->KeepFile) {
				$this->kilowatt_management_team_pic->UploadPath = '../src/assets/images/kilowatt/team';
				if (!ew_Empty($this->kilowatt_management_team_pic->Upload->Value)) {
					$rsnew['kilowatt_management_team_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->kilowatt_management_team_pic->UploadPath), $rsnew['kilowatt_management_team_pic']); // Get new file name
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if (!$this->kilowatt_management_team_pic->Upload->KeepFile) {
						if (!ew_Empty($this->kilowatt_management_team_pic->Upload->Value)) {
							$this->kilowatt_management_team_pic->Upload->Resize($this->kilowatt_management_team_pic->ImageWidth, $this->kilowatt_management_team_pic->ImageHeight);
							$this->kilowatt_management_team_pic->Upload->SaveToFile($this->kilowatt_management_team_pic->UploadPath, $rsnew['kilowatt_management_team_pic'], TRUE);
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
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// kilowatt_management_team_pic
		ew_CleanUploadTempPath($this->kilowatt_management_team_pic, $this->kilowatt_management_team_pic->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "kilowatt_management_teamlist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($kilowatt_management_team_edit)) $kilowatt_management_team_edit = new ckilowatt_management_team_edit();

// Page init
$kilowatt_management_team_edit->Page_Init();

// Page main
$kilowatt_management_team_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$kilowatt_management_team_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fkilowatt_management_teamedit = new ew_Form("fkilowatt_management_teamedit", "edit");

// Validate form
fkilowatt_management_teamedit.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_kilowatt_management_team_pic");
			elm = this.GetElements("fn_x" + infix + "_kilowatt_management_team_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_management_team->kilowatt_management_team_pic->FldCaption(), $kilowatt_management_team->kilowatt_management_team_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kilowatt_management_team_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_management_team->kilowatt_management_team_name->FldCaption(), $kilowatt_management_team->kilowatt_management_team_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kilowatt_management_team_designation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_management_team->kilowatt_management_team_designation->FldCaption(), $kilowatt_management_team->kilowatt_management_team_designation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kilowatt_management_team_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_management_team->kilowatt_management_team_content->FldCaption(), $kilowatt_management_team->kilowatt_management_team_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_management_team->sort_order->FldCaption(), $kilowatt_management_team->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($kilowatt_management_team->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_management_team->status->FldCaption(), $kilowatt_management_team->status->ReqErrMsg)) ?>");

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
fkilowatt_management_teamedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkilowatt_management_teamedit.ValidateRequired = true;
<?php } else { ?>
fkilowatt_management_teamedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fkilowatt_management_teamedit.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fkilowatt_management_teamedit.Lists["x_status"].Options = <?php echo json_encode($kilowatt_management_team->status->Options()) ?>;

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
<?php $kilowatt_management_team_edit->ShowPageHeader(); ?>
<?php
$kilowatt_management_team_edit->ShowMessage();
?>
<form name="fkilowatt_management_teamedit" id="fkilowatt_management_teamedit" class="<?php echo $kilowatt_management_team_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($kilowatt_management_team_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $kilowatt_management_team_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="kilowatt_management_team">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($kilowatt_management_team->kilowatt_management_team_id->Visible) { // kilowatt_management_team_id ?>
	<div id="r_kilowatt_management_team_id" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_id" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_id->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_id">
<span<?php echo $kilowatt_management_team->kilowatt_management_team_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $kilowatt_management_team->kilowatt_management_team_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_id" name="x_kilowatt_management_team_id" id="x_kilowatt_management_team_id" value="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_id->CurrentValue) ?>">
<?php echo $kilowatt_management_team->kilowatt_management_team_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_pic->Visible) { // kilowatt_management_team_pic ?>
	<div id="r_kilowatt_management_team_pic" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_pic" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_pic->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_pic">
<div id="fd_x_kilowatt_management_team_pic">
<span title="<?php echo $kilowatt_management_team->kilowatt_management_team_pic->FldTitle() ? $kilowatt_management_team->kilowatt_management_team_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($kilowatt_management_team->kilowatt_management_team_pic->ReadOnly || $kilowatt_management_team->kilowatt_management_team_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_pic" name="x_kilowatt_management_team_pic" id="x_kilowatt_management_team_pic"<?php echo $kilowatt_management_team->kilowatt_management_team_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_kilowatt_management_team_pic" id= "fn_x_kilowatt_management_team_pic" value="<?php echo $kilowatt_management_team->kilowatt_management_team_pic->Upload->FileName ?>">
<?php if (@$_POST["fa_x_kilowatt_management_team_pic"] == "0") { ?>
<input type="hidden" name="fa_x_kilowatt_management_team_pic" id= "fa_x_kilowatt_management_team_pic" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_kilowatt_management_team_pic" id= "fa_x_kilowatt_management_team_pic" value="1">
<?php } ?>
<input type="hidden" name="fs_x_kilowatt_management_team_pic" id= "fs_x_kilowatt_management_team_pic" value="255">
<input type="hidden" name="fx_x_kilowatt_management_team_pic" id= "fx_x_kilowatt_management_team_pic" value="<?php echo $kilowatt_management_team->kilowatt_management_team_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_kilowatt_management_team_pic" id= "fm_x_kilowatt_management_team_pic" value="<?php echo $kilowatt_management_team->kilowatt_management_team_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_kilowatt_management_team_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_name->Visible) { // kilowatt_management_team_name ?>
	<div id="r_kilowatt_management_team_name" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_name" for="x_kilowatt_management_team_name" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_name->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_name">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_name" name="x_kilowatt_management_team_name" id="x_kilowatt_management_team_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_name->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_name->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_name->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_designation->Visible) { // kilowatt_management_team_designation ?>
	<div id="r_kilowatt_management_team_designation" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_designation" for="x_kilowatt_management_team_designation" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_designation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_designation->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_designation">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_designation" name="x_kilowatt_management_team_designation" id="x_kilowatt_management_team_designation" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_designation->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_designation->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_designation->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_designation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_content->Visible) { // kilowatt_management_team_content ?>
	<div id="r_kilowatt_management_team_content" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_content" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_content->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_content">
<?php ew_AppendClass($kilowatt_management_team->kilowatt_management_team_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_content" name="x_kilowatt_management_team_content" id="x_kilowatt_management_team_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_content->getPlaceHolder()) ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_content->EditAttributes() ?>><?php echo $kilowatt_management_team->kilowatt_management_team_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fkilowatt_management_teamedit", "x_kilowatt_management_team_content", 35, 4, <?php echo ($kilowatt_management_team->kilowatt_management_team_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_kilowatt_management_team_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->sort_order->CellAttributes() ?>>
<span id="el_kilowatt_management_team_sort_order">
<input type="text" data-table="kilowatt_management_team" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->sort_order->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->sort_order->EditValue ?>"<?php echo $kilowatt_management_team->sort_order->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_kilowatt_management_team_status" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->status->CellAttributes() ?>>
<span id="el_kilowatt_management_team_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="kilowatt_management_team" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($kilowatt_management_team->status->DisplayValueSeparator) ? json_encode($kilowatt_management_team->status->DisplayValueSeparator) : $kilowatt_management_team->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $kilowatt_management_team->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $kilowatt_management_team->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($kilowatt_management_team->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="kilowatt_management_team" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $kilowatt_management_team->status->EditAttributes() ?>><?php echo $kilowatt_management_team->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($kilowatt_management_team->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="kilowatt_management_team" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($kilowatt_management_team->status->CurrentValue) ?>" checked<?php echo $kilowatt_management_team->status->EditAttributes() ?>><?php echo $kilowatt_management_team->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $kilowatt_management_team->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_linkedin->Visible) { // kilowatt_management_team_linkedin ?>
	<div id="r_kilowatt_management_team_linkedin" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_linkedin" for="x_kilowatt_management_team_linkedin" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_linkedin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_linkedin->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_linkedin">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_linkedin" name="x_kilowatt_management_team_linkedin" id="x_kilowatt_management_team_linkedin" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_linkedin->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_linkedin->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_linkedin->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_linkedin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_facebook->Visible) { // kilowatt_management_team_facebook ?>
	<div id="r_kilowatt_management_team_facebook" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_facebook" for="x_kilowatt_management_team_facebook" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_facebook->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_facebook->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_facebook">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_facebook" name="x_kilowatt_management_team_facebook" id="x_kilowatt_management_team_facebook" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_facebook->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_facebook->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_facebook->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_facebook->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_twitter->Visible) { // kilowatt_management_team_twitter ?>
	<div id="r_kilowatt_management_team_twitter" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_twitter" for="x_kilowatt_management_team_twitter" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_twitter->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_twitter->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_twitter">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_twitter" name="x_kilowatt_management_team_twitter" id="x_kilowatt_management_team_twitter" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_twitter->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_twitter->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_twitter->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_twitter->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_email->Visible) { // kilowatt_management_team_email ?>
	<div id="r_kilowatt_management_team_email" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_email" for="x_kilowatt_management_team_email" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_email->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_email">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_email" name="x_kilowatt_management_team_email" id="x_kilowatt_management_team_email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_email->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_email->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_email->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_management_team->kilowatt_management_team_phone->Visible) { // kilowatt_management_team_phone ?>
	<div id="r_kilowatt_management_team_phone" class="form-group">
		<label id="elh_kilowatt_management_team_kilowatt_management_team_phone" for="x_kilowatt_management_team_phone" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_management_team->kilowatt_management_team_phone->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_management_team->kilowatt_management_team_phone->CellAttributes() ?>>
<span id="el_kilowatt_management_team_kilowatt_management_team_phone">
<input type="text" data-table="kilowatt_management_team" data-field="x_kilowatt_management_team_phone" name="x_kilowatt_management_team_phone" id="x_kilowatt_management_team_phone" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_management_team->kilowatt_management_team_phone->getPlaceHolder()) ?>" value="<?php echo $kilowatt_management_team->kilowatt_management_team_phone->EditValue ?>"<?php echo $kilowatt_management_team->kilowatt_management_team_phone->EditAttributes() ?>>
</span>
<?php echo $kilowatt_management_team->kilowatt_management_team_phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $kilowatt_management_team_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fkilowatt_management_teamedit.Init();
</script>
<?php
$kilowatt_management_team_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$kilowatt_management_team_edit->Page_Terminate();
?>
