<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "kilowatt_projectsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$kilowatt_projects_add = NULL; // Initialize page object first

class ckilowatt_projects_add extends ckilowatt_projects {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'kilowatt_projects';

	// Page object name
	var $PageObjName = 'kilowatt_projects_add';

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

		// Table object (kilowatt_projects)
		if (!isset($GLOBALS["kilowatt_projects"]) || get_class($GLOBALS["kilowatt_projects"]) == "ckilowatt_projects") {
			$GLOBALS["kilowatt_projects"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["kilowatt_projects"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'kilowatt_projects', TRUE);

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
		global $EW_EXPORT, $kilowatt_projects;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($kilowatt_projects);
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
			if (@$_GET["kilowatt_project_id"] != "") {
				$this->kilowatt_project_id->setQueryStringValue($_GET["kilowatt_project_id"]);
				$this->setKey("kilowatt_project_id", $this->kilowatt_project_id->CurrentValue); // Set up key
			} else {
				$this->setKey("kilowatt_project_id", ""); // Clear key
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
					$this->Page_Terminate("kilowatt_projectslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "kilowatt_projectsview.php")
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
		$this->kilowatt_project_pic->Upload->Index = $objForm->Index;
		$this->kilowatt_project_pic->Upload->UploadFile();
		$this->kilowatt_project_pic->CurrentValue = $this->kilowatt_project_pic->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->kilowatt_project_pic->Upload->DbValue = NULL;
		$this->kilowatt_project_pic->OldValue = $this->kilowatt_project_pic->Upload->DbValue;
		$this->kilowatt_project_pic->CurrentValue = NULL; // Clear file related field
		$this->kilowatt_project_title->CurrentValue = NULL;
		$this->kilowatt_project_title->OldValue = $this->kilowatt_project_title->CurrentValue;
		$this->kilowatt_service_category_id->CurrentValue = NULL;
		$this->kilowatt_service_category_id->OldValue = $this->kilowatt_service_category_id->CurrentValue;
		$this->sort_order->CurrentValue = NULL;
		$this->sort_order->OldValue = $this->sort_order->CurrentValue;
		$this->status->CurrentValue = "active";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->kilowatt_project_title->FldIsDetailKey) {
			$this->kilowatt_project_title->setFormValue($objForm->GetValue("x_kilowatt_project_title"));
		}
		if (!$this->kilowatt_service_category_id->FldIsDetailKey) {
			$this->kilowatt_service_category_id->setFormValue($objForm->GetValue("x_kilowatt_service_category_id"));
		}
		if (!$this->sort_order->FldIsDetailKey) {
			$this->sort_order->setFormValue($objForm->GetValue("x_sort_order"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->kilowatt_project_title->CurrentValue = $this->kilowatt_project_title->FormValue;
		$this->kilowatt_service_category_id->CurrentValue = $this->kilowatt_service_category_id->FormValue;
		$this->sort_order->CurrentValue = $this->sort_order->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
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
		$this->kilowatt_project_id->setDbValue($rs->fields('kilowatt_project_id'));
		$this->kilowatt_project_pic->Upload->DbValue = $rs->fields('kilowatt_project_pic');
		$this->kilowatt_project_pic->CurrentValue = $this->kilowatt_project_pic->Upload->DbValue;
		$this->kilowatt_project_title->setDbValue($rs->fields('kilowatt_project_title'));
		$this->kilowatt_service_category_id->setDbValue($rs->fields('kilowatt_service_category_id'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kilowatt_project_id->DbValue = $row['kilowatt_project_id'];
		$this->kilowatt_project_pic->Upload->DbValue = $row['kilowatt_project_pic'];
		$this->kilowatt_project_title->DbValue = $row['kilowatt_project_title'];
		$this->kilowatt_service_category_id->DbValue = $row['kilowatt_service_category_id'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("kilowatt_project_id")) <> "")
			$this->kilowatt_project_id->CurrentValue = $this->getKey("kilowatt_project_id"); // kilowatt_project_id
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
		// kilowatt_project_id
		// kilowatt_project_pic
		// kilowatt_project_title
		// kilowatt_service_category_id
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kilowatt_project_id
		$this->kilowatt_project_id->ViewValue = $this->kilowatt_project_id->CurrentValue;
		$this->kilowatt_project_id->ViewCustomAttributes = "";

		// kilowatt_project_pic
		$this->kilowatt_project_pic->UploadPath = '../src/assets/images/kilowatt/projects';
		if (!ew_Empty($this->kilowatt_project_pic->Upload->DbValue)) {
			$this->kilowatt_project_pic->ImageWidth = 100;
			$this->kilowatt_project_pic->ImageHeight = 120;
			$this->kilowatt_project_pic->ImageAlt = $this->kilowatt_project_pic->FldAlt();
			$this->kilowatt_project_pic->ViewValue = $this->kilowatt_project_pic->Upload->DbValue;
		} else {
			$this->kilowatt_project_pic->ViewValue = "";
		}
		$this->kilowatt_project_pic->ViewCustomAttributes = "";

		// kilowatt_project_title
		$this->kilowatt_project_title->ViewValue = $this->kilowatt_project_title->CurrentValue;
		$this->kilowatt_project_title->ViewCustomAttributes = "";

		// kilowatt_service_category_id
		if (strval($this->kilowatt_service_category_id->CurrentValue) <> "") {
			$sFilterWrk = "`kilowatt_service_category_id`" . ew_SearchString("=", $this->kilowatt_service_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kilowatt_service_category_id`, `kilowatt_service_category_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `kilowatt_service_category`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kilowatt_service_category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kilowatt_service_category_id->ViewValue = $this->kilowatt_service_category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kilowatt_service_category_id->ViewValue = $this->kilowatt_service_category_id->CurrentValue;
			}
		} else {
			$this->kilowatt_service_category_id->ViewValue = NULL;
		}
		$this->kilowatt_service_category_id->ViewCustomAttributes = "";

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

			// kilowatt_project_pic
			$this->kilowatt_project_pic->LinkCustomAttributes = "";
			$this->kilowatt_project_pic->UploadPath = '../src/assets/images/kilowatt/projects';
			if (!ew_Empty($this->kilowatt_project_pic->Upload->DbValue)) {
				$this->kilowatt_project_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_project_pic, $this->kilowatt_project_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_project_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_project_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_project_pic->HrefValue);
			} else {
				$this->kilowatt_project_pic->HrefValue = "";
			}
			$this->kilowatt_project_pic->HrefValue2 = $this->kilowatt_project_pic->UploadPath . $this->kilowatt_project_pic->Upload->DbValue;
			$this->kilowatt_project_pic->TooltipValue = "";
			if ($this->kilowatt_project_pic->UseColorbox) {
				$this->kilowatt_project_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->kilowatt_project_pic->LinkAttrs["data-rel"] = "kilowatt_projects_x_kilowatt_project_pic";

				//$this->kilowatt_project_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->kilowatt_project_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->kilowatt_project_pic->LinkAttrs["data-container"] = "body";

				$this->kilowatt_project_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// kilowatt_project_title
			$this->kilowatt_project_title->LinkCustomAttributes = "";
			$this->kilowatt_project_title->HrefValue = "";
			$this->kilowatt_project_title->TooltipValue = "";

			// kilowatt_service_category_id
			$this->kilowatt_service_category_id->LinkCustomAttributes = "";
			$this->kilowatt_service_category_id->HrefValue = "";
			$this->kilowatt_service_category_id->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// kilowatt_project_pic
			$this->kilowatt_project_pic->EditAttrs["class"] = "form-control";
			$this->kilowatt_project_pic->EditCustomAttributes = "";
			$this->kilowatt_project_pic->UploadPath = '../src/assets/images/kilowatt/projects';
			if (!ew_Empty($this->kilowatt_project_pic->Upload->DbValue)) {
				$this->kilowatt_project_pic->ImageWidth = 100;
				$this->kilowatt_project_pic->ImageHeight = 120;
				$this->kilowatt_project_pic->ImageAlt = $this->kilowatt_project_pic->FldAlt();
				$this->kilowatt_project_pic->EditValue = $this->kilowatt_project_pic->Upload->DbValue;
			} else {
				$this->kilowatt_project_pic->EditValue = "";
			}
			if (!ew_Empty($this->kilowatt_project_pic->CurrentValue))
				$this->kilowatt_project_pic->Upload->FileName = $this->kilowatt_project_pic->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->kilowatt_project_pic);

			// kilowatt_project_title
			$this->kilowatt_project_title->EditAttrs["class"] = "form-control";
			$this->kilowatt_project_title->EditCustomAttributes = "";
			$this->kilowatt_project_title->EditValue = ew_HtmlEncode($this->kilowatt_project_title->CurrentValue);
			$this->kilowatt_project_title->PlaceHolder = ew_RemoveHtml($this->kilowatt_project_title->FldCaption());

			// kilowatt_service_category_id
			$this->kilowatt_service_category_id->EditAttrs["class"] = "form-control";
			$this->kilowatt_service_category_id->EditCustomAttributes = "";
			if (trim(strval($this->kilowatt_service_category_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kilowatt_service_category_id`" . ew_SearchString("=", $this->kilowatt_service_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kilowatt_service_category_id`, `kilowatt_service_category_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `kilowatt_service_category`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kilowatt_service_category_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->kilowatt_service_category_id->EditValue = $arwrk;

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// kilowatt_project_pic

			$this->kilowatt_project_pic->UploadPath = '../src/assets/images/kilowatt/projects';
			if (!ew_Empty($this->kilowatt_project_pic->Upload->DbValue)) {
				$this->kilowatt_project_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_project_pic, $this->kilowatt_project_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_project_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_project_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_project_pic->HrefValue);
			} else {
				$this->kilowatt_project_pic->HrefValue = "";
			}
			$this->kilowatt_project_pic->HrefValue2 = $this->kilowatt_project_pic->UploadPath . $this->kilowatt_project_pic->Upload->DbValue;

			// kilowatt_project_title
			$this->kilowatt_project_title->HrefValue = "";

			// kilowatt_service_category_id
			$this->kilowatt_service_category_id->HrefValue = "";

			// sort_order
			$this->sort_order->HrefValue = "";

			// status
			$this->status->HrefValue = "";
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
		if ($this->kilowatt_project_pic->Upload->FileName == "" && !$this->kilowatt_project_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_project_pic->FldCaption(), $this->kilowatt_project_pic->ReqErrMsg));
		}
		if (!$this->kilowatt_project_title->FldIsDetailKey && !is_null($this->kilowatt_project_title->FormValue) && $this->kilowatt_project_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_project_title->FldCaption(), $this->kilowatt_project_title->ReqErrMsg));
		}
		if (!$this->kilowatt_service_category_id->FldIsDetailKey && !is_null($this->kilowatt_service_category_id->FormValue) && $this->kilowatt_service_category_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kilowatt_service_category_id->FldCaption(), $this->kilowatt_service_category_id->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->kilowatt_project_pic->OldUploadPath = '../src/assets/images/kilowatt/projects';
			$this->kilowatt_project_pic->UploadPath = $this->kilowatt_project_pic->OldUploadPath;
		}
		$rsnew = array();

		// kilowatt_project_pic
		if (!$this->kilowatt_project_pic->Upload->KeepFile) {
			$this->kilowatt_project_pic->Upload->DbValue = ""; // No need to delete old file
			if ($this->kilowatt_project_pic->Upload->FileName == "") {
				$rsnew['kilowatt_project_pic'] = NULL;
			} else {
				$rsnew['kilowatt_project_pic'] = $this->kilowatt_project_pic->Upload->FileName;
			}
			$this->kilowatt_project_pic->ImageWidth = 380; // Resize width
			$this->kilowatt_project_pic->ImageHeight = 529; // Resize height
		}

		// kilowatt_project_title
		$this->kilowatt_project_title->SetDbValueDef($rsnew, $this->kilowatt_project_title->CurrentValue, "", FALSE);

		// kilowatt_service_category_id
		$this->kilowatt_service_category_id->SetDbValueDef($rsnew, $this->kilowatt_service_category_id->CurrentValue, 0, FALSE);

		// sort_order
		$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");
		if (!$this->kilowatt_project_pic->Upload->KeepFile) {
			$this->kilowatt_project_pic->UploadPath = '../src/assets/images/kilowatt/projects';
			if (!ew_Empty($this->kilowatt_project_pic->Upload->Value)) {
				$rsnew['kilowatt_project_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->kilowatt_project_pic->UploadPath), $rsnew['kilowatt_project_pic']); // Get new file name
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
				$this->kilowatt_project_id->setDbValue($conn->Insert_ID());
				$rsnew['kilowatt_project_id'] = $this->kilowatt_project_id->DbValue;
				if (!$this->kilowatt_project_pic->Upload->KeepFile) {
					if (!ew_Empty($this->kilowatt_project_pic->Upload->Value)) {
						$this->kilowatt_project_pic->Upload->Resize($this->kilowatt_project_pic->ImageWidth, $this->kilowatt_project_pic->ImageHeight);
						$this->kilowatt_project_pic->Upload->SaveToFile($this->kilowatt_project_pic->UploadPath, $rsnew['kilowatt_project_pic'], TRUE);
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

		// kilowatt_project_pic
		ew_CleanUploadTempPath($this->kilowatt_project_pic, $this->kilowatt_project_pic->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "kilowatt_projectslist.php", "", $this->TableVar, TRUE);
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
if (!isset($kilowatt_projects_add)) $kilowatt_projects_add = new ckilowatt_projects_add();

// Page init
$kilowatt_projects_add->Page_Init();

// Page main
$kilowatt_projects_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$kilowatt_projects_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fkilowatt_projectsadd = new ew_Form("fkilowatt_projectsadd", "add");

// Validate form
fkilowatt_projectsadd.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_kilowatt_project_pic");
			elm = this.GetElements("fn_x" + infix + "_kilowatt_project_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_projects->kilowatt_project_pic->FldCaption(), $kilowatt_projects->kilowatt_project_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kilowatt_project_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_projects->kilowatt_project_title->FldCaption(), $kilowatt_projects->kilowatt_project_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kilowatt_service_category_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_projects->kilowatt_service_category_id->FldCaption(), $kilowatt_projects->kilowatt_service_category_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_projects->sort_order->FldCaption(), $kilowatt_projects->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($kilowatt_projects->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $kilowatt_projects->status->FldCaption(), $kilowatt_projects->status->ReqErrMsg)) ?>");

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
fkilowatt_projectsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkilowatt_projectsadd.ValidateRequired = true;
<?php } else { ?>
fkilowatt_projectsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fkilowatt_projectsadd.Lists["x_kilowatt_service_category_id"] = {"LinkField":"x_kilowatt_service_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kilowatt_service_category_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fkilowatt_projectsadd.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fkilowatt_projectsadd.Lists["x_status"].Options = <?php echo json_encode($kilowatt_projects->status->Options()) ?>;

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
<?php $kilowatt_projects_add->ShowPageHeader(); ?>
<?php
$kilowatt_projects_add->ShowMessage();
?>
<form name="fkilowatt_projectsadd" id="fkilowatt_projectsadd" class="<?php echo $kilowatt_projects_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($kilowatt_projects_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $kilowatt_projects_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="kilowatt_projects">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($kilowatt_projects->kilowatt_project_pic->Visible) { // kilowatt_project_pic ?>
	<div id="r_kilowatt_project_pic" class="form-group">
		<label id="elh_kilowatt_projects_kilowatt_project_pic" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_projects->kilowatt_project_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_projects->kilowatt_project_pic->CellAttributes() ?>>
<span id="el_kilowatt_projects_kilowatt_project_pic">
<div id="fd_x_kilowatt_project_pic">
<span title="<?php echo $kilowatt_projects->kilowatt_project_pic->FldTitle() ? $kilowatt_projects->kilowatt_project_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($kilowatt_projects->kilowatt_project_pic->ReadOnly || $kilowatt_projects->kilowatt_project_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="kilowatt_projects" data-field="x_kilowatt_project_pic" name="x_kilowatt_project_pic" id="x_kilowatt_project_pic"<?php echo $kilowatt_projects->kilowatt_project_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_kilowatt_project_pic" id= "fn_x_kilowatt_project_pic" value="<?php echo $kilowatt_projects->kilowatt_project_pic->Upload->FileName ?>">
<input type="hidden" name="fa_x_kilowatt_project_pic" id= "fa_x_kilowatt_project_pic" value="0">
<input type="hidden" name="fs_x_kilowatt_project_pic" id= "fs_x_kilowatt_project_pic" value="255">
<input type="hidden" name="fx_x_kilowatt_project_pic" id= "fx_x_kilowatt_project_pic" value="<?php echo $kilowatt_projects->kilowatt_project_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_kilowatt_project_pic" id= "fm_x_kilowatt_project_pic" value="<?php echo $kilowatt_projects->kilowatt_project_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_kilowatt_project_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $kilowatt_projects->kilowatt_project_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_project_title->Visible) { // kilowatt_project_title ?>
	<div id="r_kilowatt_project_title" class="form-group">
		<label id="elh_kilowatt_projects_kilowatt_project_title" for="x_kilowatt_project_title" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_projects->kilowatt_project_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_projects->kilowatt_project_title->CellAttributes() ?>>
<span id="el_kilowatt_projects_kilowatt_project_title">
<input type="text" data-table="kilowatt_projects" data-field="x_kilowatt_project_title" name="x_kilowatt_project_title" id="x_kilowatt_project_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($kilowatt_projects->kilowatt_project_title->getPlaceHolder()) ?>" value="<?php echo $kilowatt_projects->kilowatt_project_title->EditValue ?>"<?php echo $kilowatt_projects->kilowatt_project_title->EditAttributes() ?>>
</span>
<?php echo $kilowatt_projects->kilowatt_project_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_service_category_id->Visible) { // kilowatt_service_category_id ?>
	<div id="r_kilowatt_service_category_id" class="form-group">
		<label id="elh_kilowatt_projects_kilowatt_service_category_id" for="x_kilowatt_service_category_id" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_projects->kilowatt_service_category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_projects->kilowatt_service_category_id->CellAttributes() ?>>
<span id="el_kilowatt_projects_kilowatt_service_category_id">
<select data-table="kilowatt_projects" data-field="x_kilowatt_service_category_id" data-value-separator="<?php echo ew_HtmlEncode(is_array($kilowatt_projects->kilowatt_service_category_id->DisplayValueSeparator) ? json_encode($kilowatt_projects->kilowatt_service_category_id->DisplayValueSeparator) : $kilowatt_projects->kilowatt_service_category_id->DisplayValueSeparator) ?>" id="x_kilowatt_service_category_id" name="x_kilowatt_service_category_id"<?php echo $kilowatt_projects->kilowatt_service_category_id->EditAttributes() ?>>
<?php
if (is_array($kilowatt_projects->kilowatt_service_category_id->EditValue)) {
	$arwrk = $kilowatt_projects->kilowatt_service_category_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($kilowatt_projects->kilowatt_service_category_id->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $kilowatt_projects->kilowatt_service_category_id->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($kilowatt_projects->kilowatt_service_category_id->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($kilowatt_projects->kilowatt_service_category_id->CurrentValue) ?>" selected><?php echo $kilowatt_projects->kilowatt_service_category_id->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `kilowatt_service_category_id`, `kilowatt_service_category_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `kilowatt_service_category`";
$sWhereWrk = "";
$kilowatt_projects->kilowatt_service_category_id->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$kilowatt_projects->kilowatt_service_category_id->LookupFilters += array("f0" => "`kilowatt_service_category_id` = {filter_value}", "t0" => "19", "fn0" => "");
$sSqlWrk = "";
$kilowatt_projects->Lookup_Selecting($kilowatt_projects->kilowatt_service_category_id, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $kilowatt_projects->kilowatt_service_category_id->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_kilowatt_service_category_id" id="s_x_kilowatt_service_category_id" value="<?php echo $kilowatt_projects->kilowatt_service_category_id->LookupFilterQuery() ?>">
</span>
<?php echo $kilowatt_projects->kilowatt_service_category_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_projects->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_kilowatt_projects_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_projects->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_projects->sort_order->CellAttributes() ?>>
<span id="el_kilowatt_projects_sort_order">
<input type="text" data-table="kilowatt_projects" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($kilowatt_projects->sort_order->getPlaceHolder()) ?>" value="<?php echo $kilowatt_projects->sort_order->EditValue ?>"<?php echo $kilowatt_projects->sort_order->EditAttributes() ?>>
</span>
<?php echo $kilowatt_projects->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($kilowatt_projects->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_kilowatt_projects_status" class="col-sm-2 control-label ewLabel"><?php echo $kilowatt_projects->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $kilowatt_projects->status->CellAttributes() ?>>
<span id="el_kilowatt_projects_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="kilowatt_projects" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($kilowatt_projects->status->DisplayValueSeparator) ? json_encode($kilowatt_projects->status->DisplayValueSeparator) : $kilowatt_projects->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $kilowatt_projects->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $kilowatt_projects->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($kilowatt_projects->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="kilowatt_projects" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $kilowatt_projects->status->EditAttributes() ?>><?php echo $kilowatt_projects->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($kilowatt_projects->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="kilowatt_projects" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($kilowatt_projects->status->CurrentValue) ?>" checked<?php echo $kilowatt_projects->status->EditAttributes() ?>><?php echo $kilowatt_projects->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $kilowatt_projects->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $kilowatt_projects_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fkilowatt_projectsadd.Init();
</script>
<?php
$kilowatt_projects_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$kilowatt_projects_add->Page_Terminate();
?>
