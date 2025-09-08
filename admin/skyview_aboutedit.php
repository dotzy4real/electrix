<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "skyview_aboutinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$skyview_about_edit = NULL; // Initialize page object first

class cskyview_about_edit extends cskyview_about {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'skyview_about';

	// Page object name
	var $PageObjName = 'skyview_about_edit';

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

		// Table object (skyview_about)
		if (!isset($GLOBALS["skyview_about"]) || get_class($GLOBALS["skyview_about"]) == "cskyview_about") {
			$GLOBALS["skyview_about"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["skyview_about"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'skyview_about', TRUE);

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
		$this->skyview_about_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $skyview_about;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($skyview_about);
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
		if (@$_GET["skyview_about_id"] <> "") {
			$this->skyview_about_id->setQueryStringValue($_GET["skyview_about_id"]);
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
		if ($this->skyview_about_id->CurrentValue == "")
			$this->Page_Terminate("skyview_aboutlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("skyview_aboutlist.php"); // No matching record, return to list
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
		$this->skyview_about_left_pic->Upload->Index = $objForm->Index;
		$this->skyview_about_left_pic->Upload->UploadFile();
		$this->skyview_about_left_pic->CurrentValue = $this->skyview_about_left_pic->Upload->FileName;
		$this->skyview_about_right_pic->Upload->Index = $objForm->Index;
		$this->skyview_about_right_pic->Upload->UploadFile();
		$this->skyview_about_right_pic->CurrentValue = $this->skyview_about_right_pic->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->skyview_about_id->FldIsDetailKey)
			$this->skyview_about_id->setFormValue($objForm->GetValue("x_skyview_about_id"));
		if (!$this->skyview_about_goal->FldIsDetailKey) {
			$this->skyview_about_goal->setFormValue($objForm->GetValue("x_skyview_about_goal"));
		}
		if (!$this->skyview_about_icon_title->FldIsDetailKey) {
			$this->skyview_about_icon_title->setFormValue($objForm->GetValue("x_skyview_about_icon_title"));
		}
		if (!$this->skyview_about_title->FldIsDetailKey) {
			$this->skyview_about_title->setFormValue($objForm->GetValue("x_skyview_about_title"));
		}
		if (!$this->skyview_about_content->FldIsDetailKey) {
			$this->skyview_about_content->setFormValue($objForm->GetValue("x_skyview_about_content"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->skyview_about_id->CurrentValue = $this->skyview_about_id->FormValue;
		$this->skyview_about_goal->CurrentValue = $this->skyview_about_goal->FormValue;
		$this->skyview_about_icon_title->CurrentValue = $this->skyview_about_icon_title->FormValue;
		$this->skyview_about_title->CurrentValue = $this->skyview_about_title->FormValue;
		$this->skyview_about_content->CurrentValue = $this->skyview_about_content->FormValue;
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
		$this->skyview_about_id->setDbValue($rs->fields('skyview_about_id'));
		$this->skyview_about_left_pic->Upload->DbValue = $rs->fields('skyview_about_left_pic');
		$this->skyview_about_left_pic->CurrentValue = $this->skyview_about_left_pic->Upload->DbValue;
		$this->skyview_about_right_pic->Upload->DbValue = $rs->fields('skyview_about_right_pic');
		$this->skyview_about_right_pic->CurrentValue = $this->skyview_about_right_pic->Upload->DbValue;
		$this->skyview_about_goal->setDbValue($rs->fields('skyview_about_goal'));
		$this->skyview_about_icon_title->setDbValue($rs->fields('skyview_about_icon_title'));
		$this->skyview_about_title->setDbValue($rs->fields('skyview_about_title'));
		$this->skyview_about_content->setDbValue($rs->fields('skyview_about_content'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->skyview_about_id->DbValue = $row['skyview_about_id'];
		$this->skyview_about_left_pic->Upload->DbValue = $row['skyview_about_left_pic'];
		$this->skyview_about_right_pic->Upload->DbValue = $row['skyview_about_right_pic'];
		$this->skyview_about_goal->DbValue = $row['skyview_about_goal'];
		$this->skyview_about_icon_title->DbValue = $row['skyview_about_icon_title'];
		$this->skyview_about_title->DbValue = $row['skyview_about_title'];
		$this->skyview_about_content->DbValue = $row['skyview_about_content'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// skyview_about_id
		// skyview_about_left_pic
		// skyview_about_right_pic
		// skyview_about_goal
		// skyview_about_icon_title
		// skyview_about_title
		// skyview_about_content

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// skyview_about_id
		$this->skyview_about_id->ViewValue = $this->skyview_about_id->CurrentValue;
		$this->skyview_about_id->ViewCustomAttributes = "";

		// skyview_about_left_pic
		$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
			$this->skyview_about_left_pic->ImageWidth = 80;
			$this->skyview_about_left_pic->ImageHeight = 120;
			$this->skyview_about_left_pic->ImageAlt = $this->skyview_about_left_pic->FldAlt();
			$this->skyview_about_left_pic->ViewValue = $this->skyview_about_left_pic->Upload->DbValue;
		} else {
			$this->skyview_about_left_pic->ViewValue = "";
		}
		$this->skyview_about_left_pic->ViewCustomAttributes = "";

		// skyview_about_right_pic
		$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
		if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
			$this->skyview_about_right_pic->ImageWidth = 110;
			$this->skyview_about_right_pic->ImageHeight = 120;
			$this->skyview_about_right_pic->ImageAlt = $this->skyview_about_right_pic->FldAlt();
			$this->skyview_about_right_pic->ViewValue = $this->skyview_about_right_pic->Upload->DbValue;
		} else {
			$this->skyview_about_right_pic->ViewValue = "";
		}
		$this->skyview_about_right_pic->ViewCustomAttributes = "";

		// skyview_about_goal
		$this->skyview_about_goal->ViewValue = $this->skyview_about_goal->CurrentValue;
		$this->skyview_about_goal->ViewCustomAttributes = "";

		// skyview_about_icon_title
		$this->skyview_about_icon_title->ViewValue = $this->skyview_about_icon_title->CurrentValue;
		$this->skyview_about_icon_title->ViewCustomAttributes = "";

		// skyview_about_title
		$this->skyview_about_title->ViewValue = $this->skyview_about_title->CurrentValue;
		$this->skyview_about_title->ViewCustomAttributes = "";

		// skyview_about_content
		$this->skyview_about_content->ViewValue = $this->skyview_about_content->CurrentValue;
		$this->skyview_about_content->ViewCustomAttributes = "";

			// skyview_about_id
			$this->skyview_about_id->LinkCustomAttributes = "";
			$this->skyview_about_id->HrefValue = "";
			$this->skyview_about_id->TooltipValue = "";

			// skyview_about_left_pic
			$this->skyview_about_left_pic->LinkCustomAttributes = "";
			$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
			if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
				$this->skyview_about_left_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_about_left_pic, $this->skyview_about_left_pic->Upload->DbValue); // Add prefix/suffix
				$this->skyview_about_left_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->skyview_about_left_pic->HrefValue = ew_ConvertFullUrl($this->skyview_about_left_pic->HrefValue);
			} else {
				$this->skyview_about_left_pic->HrefValue = "";
			}
			$this->skyview_about_left_pic->HrefValue2 = $this->skyview_about_left_pic->UploadPath . $this->skyview_about_left_pic->Upload->DbValue;
			$this->skyview_about_left_pic->TooltipValue = "";
			if ($this->skyview_about_left_pic->UseColorbox) {
				$this->skyview_about_left_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->skyview_about_left_pic->LinkAttrs["data-rel"] = "skyview_about_x_skyview_about_left_pic";

				//$this->skyview_about_left_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->skyview_about_left_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->skyview_about_left_pic->LinkAttrs["data-container"] = "body";

				$this->skyview_about_left_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// skyview_about_right_pic
			$this->skyview_about_right_pic->LinkCustomAttributes = "";
			$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
			if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
				$this->skyview_about_right_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_about_right_pic, $this->skyview_about_right_pic->Upload->DbValue); // Add prefix/suffix
				$this->skyview_about_right_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->skyview_about_right_pic->HrefValue = ew_ConvertFullUrl($this->skyview_about_right_pic->HrefValue);
			} else {
				$this->skyview_about_right_pic->HrefValue = "";
			}
			$this->skyview_about_right_pic->HrefValue2 = $this->skyview_about_right_pic->UploadPath . $this->skyview_about_right_pic->Upload->DbValue;
			$this->skyview_about_right_pic->TooltipValue = "";
			if ($this->skyview_about_right_pic->UseColorbox) {
				$this->skyview_about_right_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->skyview_about_right_pic->LinkAttrs["data-rel"] = "skyview_about_x_skyview_about_right_pic";

				//$this->skyview_about_right_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->skyview_about_right_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->skyview_about_right_pic->LinkAttrs["data-container"] = "body";

				$this->skyview_about_right_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// skyview_about_goal
			$this->skyview_about_goal->LinkCustomAttributes = "";
			$this->skyview_about_goal->HrefValue = "";
			$this->skyview_about_goal->TooltipValue = "";

			// skyview_about_icon_title
			$this->skyview_about_icon_title->LinkCustomAttributes = "";
			$this->skyview_about_icon_title->HrefValue = "";
			$this->skyview_about_icon_title->TooltipValue = "";

			// skyview_about_title
			$this->skyview_about_title->LinkCustomAttributes = "";
			$this->skyview_about_title->HrefValue = "";
			$this->skyview_about_title->TooltipValue = "";

			// skyview_about_content
			$this->skyview_about_content->LinkCustomAttributes = "";
			$this->skyview_about_content->HrefValue = "";
			$this->skyview_about_content->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// skyview_about_id
			$this->skyview_about_id->EditAttrs["class"] = "form-control";
			$this->skyview_about_id->EditCustomAttributes = "";
			$this->skyview_about_id->EditValue = $this->skyview_about_id->CurrentValue;
			$this->skyview_about_id->ViewCustomAttributes = "";

			// skyview_about_left_pic
			$this->skyview_about_left_pic->EditAttrs["class"] = "form-control";
			$this->skyview_about_left_pic->EditCustomAttributes = "";
			$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
			if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
				$this->skyview_about_left_pic->ImageWidth = 80;
				$this->skyview_about_left_pic->ImageHeight = 120;
				$this->skyview_about_left_pic->ImageAlt = $this->skyview_about_left_pic->FldAlt();
				$this->skyview_about_left_pic->EditValue = $this->skyview_about_left_pic->Upload->DbValue;
			} else {
				$this->skyview_about_left_pic->EditValue = "";
			}
			if (!ew_Empty($this->skyview_about_left_pic->CurrentValue))
				$this->skyview_about_left_pic->Upload->FileName = $this->skyview_about_left_pic->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->skyview_about_left_pic);

			// skyview_about_right_pic
			$this->skyview_about_right_pic->EditAttrs["class"] = "form-control";
			$this->skyview_about_right_pic->EditCustomAttributes = "";
			$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
			if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
				$this->skyview_about_right_pic->ImageWidth = 110;
				$this->skyview_about_right_pic->ImageHeight = 120;
				$this->skyview_about_right_pic->ImageAlt = $this->skyview_about_right_pic->FldAlt();
				$this->skyview_about_right_pic->EditValue = $this->skyview_about_right_pic->Upload->DbValue;
			} else {
				$this->skyview_about_right_pic->EditValue = "";
			}
			if (!ew_Empty($this->skyview_about_right_pic->CurrentValue))
				$this->skyview_about_right_pic->Upload->FileName = $this->skyview_about_right_pic->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->skyview_about_right_pic);

			// skyview_about_goal
			$this->skyview_about_goal->EditAttrs["class"] = "form-control";
			$this->skyview_about_goal->EditCustomAttributes = "";
			$this->skyview_about_goal->EditValue = ew_HtmlEncode($this->skyview_about_goal->CurrentValue);
			$this->skyview_about_goal->PlaceHolder = ew_RemoveHtml($this->skyview_about_goal->FldCaption());

			// skyview_about_icon_title
			$this->skyview_about_icon_title->EditAttrs["class"] = "form-control";
			$this->skyview_about_icon_title->EditCustomAttributes = "";
			$this->skyview_about_icon_title->EditValue = ew_HtmlEncode($this->skyview_about_icon_title->CurrentValue);
			$this->skyview_about_icon_title->PlaceHolder = ew_RemoveHtml($this->skyview_about_icon_title->FldCaption());

			// skyview_about_title
			$this->skyview_about_title->EditAttrs["class"] = "form-control";
			$this->skyview_about_title->EditCustomAttributes = "";
			$this->skyview_about_title->EditValue = ew_HtmlEncode($this->skyview_about_title->CurrentValue);
			$this->skyview_about_title->PlaceHolder = ew_RemoveHtml($this->skyview_about_title->FldCaption());

			// skyview_about_content
			$this->skyview_about_content->EditAttrs["class"] = "form-control";
			$this->skyview_about_content->EditCustomAttributes = "";
			$this->skyview_about_content->EditValue = ew_HtmlEncode($this->skyview_about_content->CurrentValue);
			$this->skyview_about_content->PlaceHolder = ew_RemoveHtml($this->skyview_about_content->FldCaption());

			// Edit refer script
			// skyview_about_id

			$this->skyview_about_id->HrefValue = "";

			// skyview_about_left_pic
			$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
			if (!ew_Empty($this->skyview_about_left_pic->Upload->DbValue)) {
				$this->skyview_about_left_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_about_left_pic, $this->skyview_about_left_pic->Upload->DbValue); // Add prefix/suffix
				$this->skyview_about_left_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->skyview_about_left_pic->HrefValue = ew_ConvertFullUrl($this->skyview_about_left_pic->HrefValue);
			} else {
				$this->skyview_about_left_pic->HrefValue = "";
			}
			$this->skyview_about_left_pic->HrefValue2 = $this->skyview_about_left_pic->UploadPath . $this->skyview_about_left_pic->Upload->DbValue;

			// skyview_about_right_pic
			$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
			if (!ew_Empty($this->skyview_about_right_pic->Upload->DbValue)) {
				$this->skyview_about_right_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_about_right_pic, $this->skyview_about_right_pic->Upload->DbValue); // Add prefix/suffix
				$this->skyview_about_right_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->skyview_about_right_pic->HrefValue = ew_ConvertFullUrl($this->skyview_about_right_pic->HrefValue);
			} else {
				$this->skyview_about_right_pic->HrefValue = "";
			}
			$this->skyview_about_right_pic->HrefValue2 = $this->skyview_about_right_pic->UploadPath . $this->skyview_about_right_pic->Upload->DbValue;

			// skyview_about_goal
			$this->skyview_about_goal->HrefValue = "";

			// skyview_about_icon_title
			$this->skyview_about_icon_title->HrefValue = "";

			// skyview_about_title
			$this->skyview_about_title->HrefValue = "";

			// skyview_about_content
			$this->skyview_about_content->HrefValue = "";
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
		if ($this->skyview_about_left_pic->Upload->FileName == "" && !$this->skyview_about_left_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->skyview_about_left_pic->FldCaption(), $this->skyview_about_left_pic->ReqErrMsg));
		}
		if ($this->skyview_about_right_pic->Upload->FileName == "" && !$this->skyview_about_right_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->skyview_about_right_pic->FldCaption(), $this->skyview_about_right_pic->ReqErrMsg));
		}
		if (!$this->skyview_about_goal->FldIsDetailKey && !is_null($this->skyview_about_goal->FormValue) && $this->skyview_about_goal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->skyview_about_goal->FldCaption(), $this->skyview_about_goal->ReqErrMsg));
		}
		if (!$this->skyview_about_icon_title->FldIsDetailKey && !is_null($this->skyview_about_icon_title->FormValue) && $this->skyview_about_icon_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->skyview_about_icon_title->FldCaption(), $this->skyview_about_icon_title->ReqErrMsg));
		}
		if (!$this->skyview_about_title->FldIsDetailKey && !is_null($this->skyview_about_title->FormValue) && $this->skyview_about_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->skyview_about_title->FldCaption(), $this->skyview_about_title->ReqErrMsg));
		}
		if (!$this->skyview_about_content->FldIsDetailKey && !is_null($this->skyview_about_content->FormValue) && $this->skyview_about_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->skyview_about_content->FldCaption(), $this->skyview_about_content->ReqErrMsg));
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
			$this->skyview_about_left_pic->OldUploadPath = '../src/assets/images/skyview';
			$this->skyview_about_left_pic->UploadPath = $this->skyview_about_left_pic->OldUploadPath;
			$this->skyview_about_right_pic->OldUploadPath = '../src/assets/images/skyview';
			$this->skyview_about_right_pic->UploadPath = $this->skyview_about_right_pic->OldUploadPath;
			$rsnew = array();

			// skyview_about_left_pic
			if (!($this->skyview_about_left_pic->ReadOnly) && !$this->skyview_about_left_pic->Upload->KeepFile) {
				$this->skyview_about_left_pic->Upload->DbValue = $rsold['skyview_about_left_pic']; // Get original value
				if ($this->skyview_about_left_pic->Upload->FileName == "") {
					$rsnew['skyview_about_left_pic'] = NULL;
				} else {
					$rsnew['skyview_about_left_pic'] = $this->skyview_about_left_pic->Upload->FileName;
				}
				$this->skyview_about_left_pic->ImageWidth = 260; // Resize width
				$this->skyview_about_left_pic->ImageHeight = 463; // Resize height
			}

			// skyview_about_right_pic
			if (!($this->skyview_about_right_pic->ReadOnly) && !$this->skyview_about_right_pic->Upload->KeepFile) {
				$this->skyview_about_right_pic->Upload->DbValue = $rsold['skyview_about_right_pic']; // Get original value
				if ($this->skyview_about_right_pic->Upload->FileName == "") {
					$rsnew['skyview_about_right_pic'] = NULL;
				} else {
					$rsnew['skyview_about_right_pic'] = $this->skyview_about_right_pic->Upload->FileName;
				}
			}

			// skyview_about_goal
			$this->skyview_about_goal->SetDbValueDef($rsnew, $this->skyview_about_goal->CurrentValue, "", $this->skyview_about_goal->ReadOnly);

			// skyview_about_icon_title
			$this->skyview_about_icon_title->SetDbValueDef($rsnew, $this->skyview_about_icon_title->CurrentValue, "", $this->skyview_about_icon_title->ReadOnly);

			// skyview_about_title
			$this->skyview_about_title->SetDbValueDef($rsnew, $this->skyview_about_title->CurrentValue, "", $this->skyview_about_title->ReadOnly);

			// skyview_about_content
			$this->skyview_about_content->SetDbValueDef($rsnew, $this->skyview_about_content->CurrentValue, "", $this->skyview_about_content->ReadOnly);
			if (!$this->skyview_about_left_pic->Upload->KeepFile) {
				$this->skyview_about_left_pic->UploadPath = '../src/assets/images/skyview';
				if (!ew_Empty($this->skyview_about_left_pic->Upload->Value)) {
					$rsnew['skyview_about_left_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->skyview_about_left_pic->UploadPath), $rsnew['skyview_about_left_pic']); // Get new file name
				}
			}
			if (!$this->skyview_about_right_pic->Upload->KeepFile) {
				$this->skyview_about_right_pic->UploadPath = '../src/assets/images/skyview';
				if (!ew_Empty($this->skyview_about_right_pic->Upload->Value)) {
					$rsnew['skyview_about_right_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->skyview_about_right_pic->UploadPath), $rsnew['skyview_about_right_pic']); // Get new file name
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
					if (!$this->skyview_about_left_pic->Upload->KeepFile) {
						if (!ew_Empty($this->skyview_about_left_pic->Upload->Value)) {
							$this->skyview_about_left_pic->Upload->Resize($this->skyview_about_left_pic->ImageWidth, $this->skyview_about_left_pic->ImageHeight);
							$this->skyview_about_left_pic->Upload->SaveToFile($this->skyview_about_left_pic->UploadPath, $rsnew['skyview_about_left_pic'], TRUE);
						}
					}
					if (!$this->skyview_about_right_pic->Upload->KeepFile) {
						if (!ew_Empty($this->skyview_about_right_pic->Upload->Value)) {
							$this->skyview_about_right_pic->Upload->SaveToFile($this->skyview_about_right_pic->UploadPath, $rsnew['skyview_about_right_pic'], TRUE);
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

		// skyview_about_left_pic
		ew_CleanUploadTempPath($this->skyview_about_left_pic, $this->skyview_about_left_pic->Upload->Index);

		// skyview_about_right_pic
		ew_CleanUploadTempPath($this->skyview_about_right_pic, $this->skyview_about_right_pic->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "skyview_aboutlist.php", "", $this->TableVar, TRUE);
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
if (!isset($skyview_about_edit)) $skyview_about_edit = new cskyview_about_edit();

// Page init
$skyview_about_edit->Page_Init();

// Page main
$skyview_about_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$skyview_about_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fskyview_aboutedit = new ew_Form("fskyview_aboutedit", "edit");

// Validate form
fskyview_aboutedit.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_skyview_about_left_pic");
			elm = this.GetElements("fn_x" + infix + "_skyview_about_left_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $skyview_about->skyview_about_left_pic->FldCaption(), $skyview_about->skyview_about_left_pic->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_skyview_about_right_pic");
			elm = this.GetElements("fn_x" + infix + "_skyview_about_right_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $skyview_about->skyview_about_right_pic->FldCaption(), $skyview_about->skyview_about_right_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_skyview_about_goal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skyview_about->skyview_about_goal->FldCaption(), $skyview_about->skyview_about_goal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_skyview_about_icon_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skyview_about->skyview_about_icon_title->FldCaption(), $skyview_about->skyview_about_icon_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_skyview_about_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skyview_about->skyview_about_title->FldCaption(), $skyview_about->skyview_about_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_skyview_about_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skyview_about->skyview_about_content->FldCaption(), $skyview_about->skyview_about_content->ReqErrMsg)) ?>");

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
fskyview_aboutedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fskyview_aboutedit.ValidateRequired = true;
<?php } else { ?>
fskyview_aboutedit.ValidateRequired = false; 
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
<?php $skyview_about_edit->ShowPageHeader(); ?>
<?php
$skyview_about_edit->ShowMessage();
?>
<form name="fskyview_aboutedit" id="fskyview_aboutedit" class="<?php echo $skyview_about_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($skyview_about_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $skyview_about_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="skyview_about">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($skyview_about->skyview_about_id->Visible) { // skyview_about_id ?>
	<div id="r_skyview_about_id" class="form-group">
		<label id="elh_skyview_about_skyview_about_id" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_id->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_id">
<span<?php echo $skyview_about->skyview_about_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $skyview_about->skyview_about_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="skyview_about" data-field="x_skyview_about_id" name="x_skyview_about_id" id="x_skyview_about_id" value="<?php echo ew_HtmlEncode($skyview_about->skyview_about_id->CurrentValue) ?>">
<?php echo $skyview_about->skyview_about_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skyview_about->skyview_about_left_pic->Visible) { // skyview_about_left_pic ?>
	<div id="r_skyview_about_left_pic" class="form-group">
		<label id="elh_skyview_about_skyview_about_left_pic" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_left_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_left_pic->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_left_pic">
<div id="fd_x_skyview_about_left_pic">
<span title="<?php echo $skyview_about->skyview_about_left_pic->FldTitle() ? $skyview_about->skyview_about_left_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($skyview_about->skyview_about_left_pic->ReadOnly || $skyview_about->skyview_about_left_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="skyview_about" data-field="x_skyview_about_left_pic" name="x_skyview_about_left_pic" id="x_skyview_about_left_pic"<?php echo $skyview_about->skyview_about_left_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_skyview_about_left_pic" id= "fn_x_skyview_about_left_pic" value="<?php echo $skyview_about->skyview_about_left_pic->Upload->FileName ?>">
<?php if (@$_POST["fa_x_skyview_about_left_pic"] == "0") { ?>
<input type="hidden" name="fa_x_skyview_about_left_pic" id= "fa_x_skyview_about_left_pic" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_skyview_about_left_pic" id= "fa_x_skyview_about_left_pic" value="1">
<?php } ?>
<input type="hidden" name="fs_x_skyview_about_left_pic" id= "fs_x_skyview_about_left_pic" value="255">
<input type="hidden" name="fx_x_skyview_about_left_pic" id= "fx_x_skyview_about_left_pic" value="<?php echo $skyview_about->skyview_about_left_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_skyview_about_left_pic" id= "fm_x_skyview_about_left_pic" value="<?php echo $skyview_about->skyview_about_left_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_skyview_about_left_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $skyview_about->skyview_about_left_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skyview_about->skyview_about_right_pic->Visible) { // skyview_about_right_pic ?>
	<div id="r_skyview_about_right_pic" class="form-group">
		<label id="elh_skyview_about_skyview_about_right_pic" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_right_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_right_pic->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_right_pic">
<div id="fd_x_skyview_about_right_pic">
<span title="<?php echo $skyview_about->skyview_about_right_pic->FldTitle() ? $skyview_about->skyview_about_right_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($skyview_about->skyview_about_right_pic->ReadOnly || $skyview_about->skyview_about_right_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="skyview_about" data-field="x_skyview_about_right_pic" name="x_skyview_about_right_pic" id="x_skyview_about_right_pic"<?php echo $skyview_about->skyview_about_right_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_skyview_about_right_pic" id= "fn_x_skyview_about_right_pic" value="<?php echo $skyview_about->skyview_about_right_pic->Upload->FileName ?>">
<?php if (@$_POST["fa_x_skyview_about_right_pic"] == "0") { ?>
<input type="hidden" name="fa_x_skyview_about_right_pic" id= "fa_x_skyview_about_right_pic" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_skyview_about_right_pic" id= "fa_x_skyview_about_right_pic" value="1">
<?php } ?>
<input type="hidden" name="fs_x_skyview_about_right_pic" id= "fs_x_skyview_about_right_pic" value="255">
<input type="hidden" name="fx_x_skyview_about_right_pic" id= "fx_x_skyview_about_right_pic" value="<?php echo $skyview_about->skyview_about_right_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_skyview_about_right_pic" id= "fm_x_skyview_about_right_pic" value="<?php echo $skyview_about->skyview_about_right_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_skyview_about_right_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $skyview_about->skyview_about_right_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skyview_about->skyview_about_goal->Visible) { // skyview_about_goal ?>
	<div id="r_skyview_about_goal" class="form-group">
		<label id="elh_skyview_about_skyview_about_goal" for="x_skyview_about_goal" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_goal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_goal->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_goal">
<textarea data-table="skyview_about" data-field="x_skyview_about_goal" name="x_skyview_about_goal" id="x_skyview_about_goal" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skyview_about->skyview_about_goal->getPlaceHolder()) ?>"<?php echo $skyview_about->skyview_about_goal->EditAttributes() ?>><?php echo $skyview_about->skyview_about_goal->EditValue ?></textarea>
</span>
<?php echo $skyview_about->skyview_about_goal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skyview_about->skyview_about_icon_title->Visible) { // skyview_about_icon_title ?>
	<div id="r_skyview_about_icon_title" class="form-group">
		<label id="elh_skyview_about_skyview_about_icon_title" for="x_skyview_about_icon_title" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_icon_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_icon_title->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_icon_title">
<input type="text" data-table="skyview_about" data-field="x_skyview_about_icon_title" name="x_skyview_about_icon_title" id="x_skyview_about_icon_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($skyview_about->skyview_about_icon_title->getPlaceHolder()) ?>" value="<?php echo $skyview_about->skyview_about_icon_title->EditValue ?>"<?php echo $skyview_about->skyview_about_icon_title->EditAttributes() ?>>
</span>
<?php echo $skyview_about->skyview_about_icon_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skyview_about->skyview_about_title->Visible) { // skyview_about_title ?>
	<div id="r_skyview_about_title" class="form-group">
		<label id="elh_skyview_about_skyview_about_title" for="x_skyview_about_title" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_title->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_title">
<input type="text" data-table="skyview_about" data-field="x_skyview_about_title" name="x_skyview_about_title" id="x_skyview_about_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($skyview_about->skyview_about_title->getPlaceHolder()) ?>" value="<?php echo $skyview_about->skyview_about_title->EditValue ?>"<?php echo $skyview_about->skyview_about_title->EditAttributes() ?>>
</span>
<?php echo $skyview_about->skyview_about_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skyview_about->skyview_about_content->Visible) { // skyview_about_content ?>
	<div id="r_skyview_about_content" class="form-group">
		<label id="elh_skyview_about_skyview_about_content" class="col-sm-2 control-label ewLabel"><?php echo $skyview_about->skyview_about_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $skyview_about->skyview_about_content->CellAttributes() ?>>
<span id="el_skyview_about_skyview_about_content">
<?php ew_AppendClass($skyview_about->skyview_about_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="skyview_about" data-field="x_skyview_about_content" name="x_skyview_about_content" id="x_skyview_about_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skyview_about->skyview_about_content->getPlaceHolder()) ?>"<?php echo $skyview_about->skyview_about_content->EditAttributes() ?>><?php echo $skyview_about->skyview_about_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fskyview_aboutedit", "x_skyview_about_content", 35, 4, <?php echo ($skyview_about->skyview_about_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $skyview_about->skyview_about_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $skyview_about_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fskyview_aboutedit.Init();
</script>
<?php
$skyview_about_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$skyview_about_edit->Page_Terminate();
?>
