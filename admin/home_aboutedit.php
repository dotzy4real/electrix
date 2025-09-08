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

$home_about_edit = NULL; // Initialize page object first

class chome_about_edit extends chome_about {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'home_about';

	// Page object name
	var $PageObjName = 'home_about_edit';

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

		// Table object (home_about)
		if (!isset($GLOBALS["home_about"]) || get_class($GLOBALS["home_about"]) == "chome_about") {
			$GLOBALS["home_about"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["home_about"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'home_about', TRUE);

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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["home_about_id"] <> "") {
			$this->home_about_id->setQueryStringValue($_GET["home_about_id"]);
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
		if ($this->home_about_id->CurrentValue == "")
			$this->Page_Terminate("home_aboutlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("home_aboutlist.php"); // No matching record, return to list
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
		$this->home_about_pic->Upload->Index = $objForm->Index;
		$this->home_about_pic->Upload->UploadFile();
		$this->home_about_pic->CurrentValue = $this->home_about_pic->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->home_about_id->FldIsDetailKey)
			$this->home_about_id->setFormValue($objForm->GetValue("x_home_about_id"));
		if (!$this->home_about_icon_title->FldIsDetailKey) {
			$this->home_about_icon_title->setFormValue($objForm->GetValue("x_home_about_icon_title"));
		}
		if (!$this->home_about_title->FldIsDetailKey) {
			$this->home_about_title->setFormValue($objForm->GetValue("x_home_about_title"));
		}
		if (!$this->home_about_subtitle->FldIsDetailKey) {
			$this->home_about_subtitle->setFormValue($objForm->GetValue("x_home_about_subtitle"));
		}
		if (!$this->home_about_content->FldIsDetailKey) {
			$this->home_about_content->setFormValue($objForm->GetValue("x_home_about_content"));
		}
		if (!$this->home_about_block1_title->FldIsDetailKey) {
			$this->home_about_block1_title->setFormValue($objForm->GetValue("x_home_about_block1_title"));
		}
		if (!$this->home_about_block1_content->FldIsDetailKey) {
			$this->home_about_block1_content->setFormValue($objForm->GetValue("x_home_about_block1_content"));
		}
		if (!$this->home_about_block2_title->FldIsDetailKey) {
			$this->home_about_block2_title->setFormValue($objForm->GetValue("x_home_about_block2_title"));
		}
		if (!$this->home_about_block2_content->FldIsDetailKey) {
			$this->home_about_block2_content->setFormValue($objForm->GetValue("x_home_about_block2_content"));
		}
		if (!$this->home_about_board_director_id->FldIsDetailKey) {
			$this->home_about_board_director_id->setFormValue($objForm->GetValue("x_home_about_board_director_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->home_about_id->CurrentValue = $this->home_about_id->FormValue;
		$this->home_about_icon_title->CurrentValue = $this->home_about_icon_title->FormValue;
		$this->home_about_title->CurrentValue = $this->home_about_title->FormValue;
		$this->home_about_subtitle->CurrentValue = $this->home_about_subtitle->FormValue;
		$this->home_about_content->CurrentValue = $this->home_about_content->FormValue;
		$this->home_about_block1_title->CurrentValue = $this->home_about_block1_title->FormValue;
		$this->home_about_block1_content->CurrentValue = $this->home_about_block1_content->FormValue;
		$this->home_about_block2_title->CurrentValue = $this->home_about_block2_title->FormValue;
		$this->home_about_block2_content->CurrentValue = $this->home_about_block2_content->FormValue;
		$this->home_about_board_director_id->CurrentValue = $this->home_about_board_director_id->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// home_about_id
			$this->home_about_id->EditAttrs["class"] = "form-control";
			$this->home_about_id->EditCustomAttributes = "";
			$this->home_about_id->EditValue = $this->home_about_id->CurrentValue;
			$this->home_about_id->ViewCustomAttributes = "";

			// home_about_pic
			$this->home_about_pic->EditAttrs["class"] = "form-control";
			$this->home_about_pic->EditCustomAttributes = "";
			$this->home_about_pic->UploadPath = '../src/assets/images/resource';
			if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
				$this->home_about_pic->ImageWidth = 105;
				$this->home_about_pic->ImageHeight = 120;
				$this->home_about_pic->ImageAlt = $this->home_about_pic->FldAlt();
				$this->home_about_pic->EditValue = $this->home_about_pic->Upload->DbValue;
			} else {
				$this->home_about_pic->EditValue = "";
			}
			if (!ew_Empty($this->home_about_pic->CurrentValue))
				$this->home_about_pic->Upload->FileName = $this->home_about_pic->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->home_about_pic);

			// home_about_icon_title
			$this->home_about_icon_title->EditAttrs["class"] = "form-control";
			$this->home_about_icon_title->EditCustomAttributes = "";
			$this->home_about_icon_title->EditValue = ew_HtmlEncode($this->home_about_icon_title->CurrentValue);
			$this->home_about_icon_title->PlaceHolder = ew_RemoveHtml($this->home_about_icon_title->FldCaption());

			// home_about_title
			$this->home_about_title->EditAttrs["class"] = "form-control";
			$this->home_about_title->EditCustomAttributes = "";
			$this->home_about_title->EditValue = ew_HtmlEncode($this->home_about_title->CurrentValue);
			$this->home_about_title->PlaceHolder = ew_RemoveHtml($this->home_about_title->FldCaption());

			// home_about_subtitle
			$this->home_about_subtitle->EditAttrs["class"] = "form-control";
			$this->home_about_subtitle->EditCustomAttributes = "";
			$this->home_about_subtitle->EditValue = ew_HtmlEncode($this->home_about_subtitle->CurrentValue);
			$this->home_about_subtitle->PlaceHolder = ew_RemoveHtml($this->home_about_subtitle->FldCaption());

			// home_about_content
			$this->home_about_content->EditAttrs["class"] = "form-control";
			$this->home_about_content->EditCustomAttributes = "";
			$this->home_about_content->EditValue = ew_HtmlEncode($this->home_about_content->CurrentValue);
			$this->home_about_content->PlaceHolder = ew_RemoveHtml($this->home_about_content->FldCaption());

			// home_about_block1_title
			$this->home_about_block1_title->EditAttrs["class"] = "form-control";
			$this->home_about_block1_title->EditCustomAttributes = "";
			$this->home_about_block1_title->EditValue = ew_HtmlEncode($this->home_about_block1_title->CurrentValue);
			$this->home_about_block1_title->PlaceHolder = ew_RemoveHtml($this->home_about_block1_title->FldCaption());

			// home_about_block1_content
			$this->home_about_block1_content->EditAttrs["class"] = "form-control";
			$this->home_about_block1_content->EditCustomAttributes = "";
			$this->home_about_block1_content->EditValue = ew_HtmlEncode($this->home_about_block1_content->CurrentValue);
			$this->home_about_block1_content->PlaceHolder = ew_RemoveHtml($this->home_about_block1_content->FldCaption());

			// home_about_block2_title
			$this->home_about_block2_title->EditAttrs["class"] = "form-control";
			$this->home_about_block2_title->EditCustomAttributes = "";
			$this->home_about_block2_title->EditValue = ew_HtmlEncode($this->home_about_block2_title->CurrentValue);
			$this->home_about_block2_title->PlaceHolder = ew_RemoveHtml($this->home_about_block2_title->FldCaption());

			// home_about_block2_content
			$this->home_about_block2_content->EditAttrs["class"] = "form-control";
			$this->home_about_block2_content->EditCustomAttributes = "";
			$this->home_about_block2_content->EditValue = ew_HtmlEncode($this->home_about_block2_content->CurrentValue);
			$this->home_about_block2_content->PlaceHolder = ew_RemoveHtml($this->home_about_block2_content->FldCaption());

			// home_about_board_director_id
			$this->home_about_board_director_id->EditAttrs["class"] = "form-control";
			$this->home_about_board_director_id->EditCustomAttributes = "";
			$this->home_about_board_director_id->EditValue = ew_HtmlEncode($this->home_about_board_director_id->CurrentValue);
			$this->home_about_board_director_id->PlaceHolder = ew_RemoveHtml($this->home_about_board_director_id->FldCaption());

			// Edit refer script
			// home_about_id

			$this->home_about_id->HrefValue = "";

			// home_about_pic
			$this->home_about_pic->UploadPath = '../src/assets/images/resource';
			if (!ew_Empty($this->home_about_pic->Upload->DbValue)) {
				$this->home_about_pic->HrefValue = ew_GetFileUploadUrl($this->home_about_pic, $this->home_about_pic->Upload->DbValue); // Add prefix/suffix
				$this->home_about_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->home_about_pic->HrefValue = ew_ConvertFullUrl($this->home_about_pic->HrefValue);
			} else {
				$this->home_about_pic->HrefValue = "";
			}
			$this->home_about_pic->HrefValue2 = $this->home_about_pic->UploadPath . $this->home_about_pic->Upload->DbValue;

			// home_about_icon_title
			$this->home_about_icon_title->HrefValue = "";

			// home_about_title
			$this->home_about_title->HrefValue = "";

			// home_about_subtitle
			$this->home_about_subtitle->HrefValue = "";

			// home_about_content
			$this->home_about_content->HrefValue = "";

			// home_about_block1_title
			$this->home_about_block1_title->HrefValue = "";

			// home_about_block1_content
			$this->home_about_block1_content->HrefValue = "";

			// home_about_block2_title
			$this->home_about_block2_title->HrefValue = "";

			// home_about_block2_content
			$this->home_about_block2_content->HrefValue = "";

			// home_about_board_director_id
			$this->home_about_board_director_id->HrefValue = "";
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
		if ($this->home_about_pic->Upload->FileName == "" && !$this->home_about_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_pic->FldCaption(), $this->home_about_pic->ReqErrMsg));
		}
		if (!$this->home_about_icon_title->FldIsDetailKey && !is_null($this->home_about_icon_title->FormValue) && $this->home_about_icon_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_icon_title->FldCaption(), $this->home_about_icon_title->ReqErrMsg));
		}
		if (!$this->home_about_title->FldIsDetailKey && !is_null($this->home_about_title->FormValue) && $this->home_about_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_title->FldCaption(), $this->home_about_title->ReqErrMsg));
		}
		if (!$this->home_about_subtitle->FldIsDetailKey && !is_null($this->home_about_subtitle->FormValue) && $this->home_about_subtitle->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_subtitle->FldCaption(), $this->home_about_subtitle->ReqErrMsg));
		}
		if (!$this->home_about_content->FldIsDetailKey && !is_null($this->home_about_content->FormValue) && $this->home_about_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_content->FldCaption(), $this->home_about_content->ReqErrMsg));
		}
		if (!$this->home_about_block1_title->FldIsDetailKey && !is_null($this->home_about_block1_title->FormValue) && $this->home_about_block1_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_block1_title->FldCaption(), $this->home_about_block1_title->ReqErrMsg));
		}
		if (!$this->home_about_block1_content->FldIsDetailKey && !is_null($this->home_about_block1_content->FormValue) && $this->home_about_block1_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_block1_content->FldCaption(), $this->home_about_block1_content->ReqErrMsg));
		}
		if (!$this->home_about_block2_title->FldIsDetailKey && !is_null($this->home_about_block2_title->FormValue) && $this->home_about_block2_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_block2_title->FldCaption(), $this->home_about_block2_title->ReqErrMsg));
		}
		if (!$this->home_about_block2_content->FldIsDetailKey && !is_null($this->home_about_block2_content->FormValue) && $this->home_about_block2_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_block2_content->FldCaption(), $this->home_about_block2_content->ReqErrMsg));
		}
		if (!$this->home_about_board_director_id->FldIsDetailKey && !is_null($this->home_about_board_director_id->FormValue) && $this->home_about_board_director_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->home_about_board_director_id->FldCaption(), $this->home_about_board_director_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->home_about_board_director_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->home_about_board_director_id->FldErrMsg());
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
			$this->home_about_pic->OldUploadPath = '../src/assets/images/resource';
			$this->home_about_pic->UploadPath = $this->home_about_pic->OldUploadPath;
			$rsnew = array();

			// home_about_pic
			if (!($this->home_about_pic->ReadOnly) && !$this->home_about_pic->Upload->KeepFile) {
				$this->home_about_pic->Upload->DbValue = $rsold['home_about_pic']; // Get original value
				if ($this->home_about_pic->Upload->FileName == "") {
					$rsnew['home_about_pic'] = NULL;
				} else {
					$rsnew['home_about_pic'] = $this->home_about_pic->Upload->FileName;
				}
			}

			// home_about_icon_title
			$this->home_about_icon_title->SetDbValueDef($rsnew, $this->home_about_icon_title->CurrentValue, "", $this->home_about_icon_title->ReadOnly);

			// home_about_title
			$this->home_about_title->SetDbValueDef($rsnew, $this->home_about_title->CurrentValue, "", $this->home_about_title->ReadOnly);

			// home_about_subtitle
			$this->home_about_subtitle->SetDbValueDef($rsnew, $this->home_about_subtitle->CurrentValue, "", $this->home_about_subtitle->ReadOnly);

			// home_about_content
			$this->home_about_content->SetDbValueDef($rsnew, $this->home_about_content->CurrentValue, "", $this->home_about_content->ReadOnly);

			// home_about_block1_title
			$this->home_about_block1_title->SetDbValueDef($rsnew, $this->home_about_block1_title->CurrentValue, "", $this->home_about_block1_title->ReadOnly);

			// home_about_block1_content
			$this->home_about_block1_content->SetDbValueDef($rsnew, $this->home_about_block1_content->CurrentValue, "", $this->home_about_block1_content->ReadOnly);

			// home_about_block2_title
			$this->home_about_block2_title->SetDbValueDef($rsnew, $this->home_about_block2_title->CurrentValue, "", $this->home_about_block2_title->ReadOnly);

			// home_about_block2_content
			$this->home_about_block2_content->SetDbValueDef($rsnew, $this->home_about_block2_content->CurrentValue, "", $this->home_about_block2_content->ReadOnly);

			// home_about_board_director_id
			$this->home_about_board_director_id->SetDbValueDef($rsnew, $this->home_about_board_director_id->CurrentValue, 0, $this->home_about_board_director_id->ReadOnly);
			if (!$this->home_about_pic->Upload->KeepFile) {
				$this->home_about_pic->UploadPath = '../src/assets/images/resource';
				if (!ew_Empty($this->home_about_pic->Upload->Value)) {
					$rsnew['home_about_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->home_about_pic->UploadPath), $rsnew['home_about_pic']); // Get new file name
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
					if (!$this->home_about_pic->Upload->KeepFile) {
						if (!ew_Empty($this->home_about_pic->Upload->Value)) {
							$this->home_about_pic->Upload->SaveToFile($this->home_about_pic->UploadPath, $rsnew['home_about_pic'], TRUE);
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

		// home_about_pic
		ew_CleanUploadTempPath($this->home_about_pic, $this->home_about_pic->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "home_aboutlist.php", "", $this->TableVar, TRUE);
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
if (!isset($home_about_edit)) $home_about_edit = new chome_about_edit();

// Page init
$home_about_edit->Page_Init();

// Page main
$home_about_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$home_about_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fhome_aboutedit = new ew_Form("fhome_aboutedit", "edit");

// Validate form
fhome_aboutedit.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_home_about_pic");
			elm = this.GetElements("fn_x" + infix + "_home_about_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_pic->FldCaption(), $home_about->home_about_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_icon_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_icon_title->FldCaption(), $home_about->home_about_icon_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_title->FldCaption(), $home_about->home_about_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_subtitle");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_subtitle->FldCaption(), $home_about->home_about_subtitle->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_content->FldCaption(), $home_about->home_about_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_block1_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_block1_title->FldCaption(), $home_about->home_about_block1_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_block1_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_block1_content->FldCaption(), $home_about->home_about_block1_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_block2_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_block2_title->FldCaption(), $home_about->home_about_block2_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_block2_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_block2_content->FldCaption(), $home_about->home_about_block2_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_board_director_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $home_about->home_about_board_director_id->FldCaption(), $home_about->home_about_board_director_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_home_about_board_director_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($home_about->home_about_board_director_id->FldErrMsg()) ?>");

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
fhome_aboutedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhome_aboutedit.ValidateRequired = true;
<?php } else { ?>
fhome_aboutedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $home_about_edit->ShowPageHeader(); ?>
<?php
$home_about_edit->ShowMessage();
?>
<form name="fhome_aboutedit" id="fhome_aboutedit" class="<?php echo $home_about_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($home_about_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $home_about_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="home_about">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($home_about->home_about_id->Visible) { // home_about_id ?>
	<div id="r_home_about_id" class="form-group">
		<label id="elh_home_about_home_about_id" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_id->CellAttributes() ?>>
<span id="el_home_about_home_about_id">
<span<?php echo $home_about->home_about_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $home_about->home_about_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="home_about" data-field="x_home_about_id" name="x_home_about_id" id="x_home_about_id" value="<?php echo ew_HtmlEncode($home_about->home_about_id->CurrentValue) ?>">
<?php echo $home_about->home_about_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_pic->Visible) { // home_about_pic ?>
	<div id="r_home_about_pic" class="form-group">
		<label id="elh_home_about_home_about_pic" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_pic->CellAttributes() ?>>
<span id="el_home_about_home_about_pic">
<div id="fd_x_home_about_pic">
<span title="<?php echo $home_about->home_about_pic->FldTitle() ? $home_about->home_about_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($home_about->home_about_pic->ReadOnly || $home_about->home_about_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="home_about" data-field="x_home_about_pic" name="x_home_about_pic" id="x_home_about_pic"<?php echo $home_about->home_about_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_home_about_pic" id= "fn_x_home_about_pic" value="<?php echo $home_about->home_about_pic->Upload->FileName ?>">
<?php if (@$_POST["fa_x_home_about_pic"] == "0") { ?>
<input type="hidden" name="fa_x_home_about_pic" id= "fa_x_home_about_pic" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_home_about_pic" id= "fa_x_home_about_pic" value="1">
<?php } ?>
<input type="hidden" name="fs_x_home_about_pic" id= "fs_x_home_about_pic" value="255">
<input type="hidden" name="fx_x_home_about_pic" id= "fx_x_home_about_pic" value="<?php echo $home_about->home_about_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_home_about_pic" id= "fm_x_home_about_pic" value="<?php echo $home_about->home_about_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_home_about_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $home_about->home_about_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_icon_title->Visible) { // home_about_icon_title ?>
	<div id="r_home_about_icon_title" class="form-group">
		<label id="elh_home_about_home_about_icon_title" for="x_home_about_icon_title" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_icon_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_icon_title->CellAttributes() ?>>
<span id="el_home_about_home_about_icon_title">
<input type="text" data-table="home_about" data-field="x_home_about_icon_title" name="x_home_about_icon_title" id="x_home_about_icon_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_icon_title->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_icon_title->EditValue ?>"<?php echo $home_about->home_about_icon_title->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_icon_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_title->Visible) { // home_about_title ?>
	<div id="r_home_about_title" class="form-group">
		<label id="elh_home_about_home_about_title" for="x_home_about_title" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_title->CellAttributes() ?>>
<span id="el_home_about_home_about_title">
<input type="text" data-table="home_about" data-field="x_home_about_title" name="x_home_about_title" id="x_home_about_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_title->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_title->EditValue ?>"<?php echo $home_about->home_about_title->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_subtitle->Visible) { // home_about_subtitle ?>
	<div id="r_home_about_subtitle" class="form-group">
		<label id="elh_home_about_home_about_subtitle" for="x_home_about_subtitle" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_subtitle->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_subtitle->CellAttributes() ?>>
<span id="el_home_about_home_about_subtitle">
<input type="text" data-table="home_about" data-field="x_home_about_subtitle" name="x_home_about_subtitle" id="x_home_about_subtitle" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_subtitle->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_subtitle->EditValue ?>"<?php echo $home_about->home_about_subtitle->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_subtitle->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_content->Visible) { // home_about_content ?>
	<div id="r_home_about_content" class="form-group">
		<label id="elh_home_about_home_about_content" for="x_home_about_content" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_content->CellAttributes() ?>>
<span id="el_home_about_home_about_content">
<textarea data-table="home_about" data-field="x_home_about_content" name="x_home_about_content" id="x_home_about_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_content->getPlaceHolder()) ?>"<?php echo $home_about->home_about_content->EditAttributes() ?>><?php echo $home_about->home_about_content->EditValue ?></textarea>
</span>
<?php echo $home_about->home_about_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_block1_title->Visible) { // home_about_block1_title ?>
	<div id="r_home_about_block1_title" class="form-group">
		<label id="elh_home_about_home_about_block1_title" for="x_home_about_block1_title" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_block1_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_block1_title->CellAttributes() ?>>
<span id="el_home_about_home_about_block1_title">
<input type="text" data-table="home_about" data-field="x_home_about_block1_title" name="x_home_about_block1_title" id="x_home_about_block1_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_block1_title->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_block1_title->EditValue ?>"<?php echo $home_about->home_about_block1_title->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_block1_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_block1_content->Visible) { // home_about_block1_content ?>
	<div id="r_home_about_block1_content" class="form-group">
		<label id="elh_home_about_home_about_block1_content" for="x_home_about_block1_content" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_block1_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_block1_content->CellAttributes() ?>>
<span id="el_home_about_home_about_block1_content">
<input type="text" data-table="home_about" data-field="x_home_about_block1_content" name="x_home_about_block1_content" id="x_home_about_block1_content" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_block1_content->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_block1_content->EditValue ?>"<?php echo $home_about->home_about_block1_content->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_block1_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_block2_title->Visible) { // home_about_block2_title ?>
	<div id="r_home_about_block2_title" class="form-group">
		<label id="elh_home_about_home_about_block2_title" for="x_home_about_block2_title" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_block2_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_block2_title->CellAttributes() ?>>
<span id="el_home_about_home_about_block2_title">
<input type="text" data-table="home_about" data-field="x_home_about_block2_title" name="x_home_about_block2_title" id="x_home_about_block2_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_block2_title->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_block2_title->EditValue ?>"<?php echo $home_about->home_about_block2_title->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_block2_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_block2_content->Visible) { // home_about_block2_content ?>
	<div id="r_home_about_block2_content" class="form-group">
		<label id="elh_home_about_home_about_block2_content" for="x_home_about_block2_content" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_block2_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_block2_content->CellAttributes() ?>>
<span id="el_home_about_home_about_block2_content">
<input type="text" data-table="home_about" data-field="x_home_about_block2_content" name="x_home_about_block2_content" id="x_home_about_block2_content" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_block2_content->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_block2_content->EditValue ?>"<?php echo $home_about->home_about_block2_content->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_block2_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about->home_about_board_director_id->Visible) { // home_about_board_director_id ?>
	<div id="r_home_about_board_director_id" class="form-group">
		<label id="elh_home_about_home_about_board_director_id" for="x_home_about_board_director_id" class="col-sm-2 control-label ewLabel"><?php echo $home_about->home_about_board_director_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $home_about->home_about_board_director_id->CellAttributes() ?>>
<span id="el_home_about_home_about_board_director_id">
<input type="text" data-table="home_about" data-field="x_home_about_board_director_id" name="x_home_about_board_director_id" id="x_home_about_board_director_id" size="30" placeholder="<?php echo ew_HtmlEncode($home_about->home_about_board_director_id->getPlaceHolder()) ?>" value="<?php echo $home_about->home_about_board_director_id->EditValue ?>"<?php echo $home_about->home_about_board_director_id->EditAttributes() ?>>
</span>
<?php echo $home_about->home_about_board_director_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $home_about_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fhome_aboutedit.Init();
</script>
<?php
$home_about_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$home_about_edit->Page_Terminate();
?>
