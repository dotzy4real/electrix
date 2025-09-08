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

$projects_edit = NULL; // Initialize page object first

class cprojects_edit extends cprojects {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_edit';

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

		// Table object (projects)
		if (!isset($GLOBALS["projects"]) || get_class($GLOBALS["projects"]) == "cprojects") {
			$GLOBALS["projects"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["projects"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'projects', TRUE);

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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["project_id"] <> "") {
			$this->project_id->setQueryStringValue($_GET["project_id"]);
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
		if ($this->project_id->CurrentValue == "")
			$this->Page_Terminate("projectslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("projectslist.php"); // No matching record, return to list
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
		$this->project_small_pic->Upload->Index = $objForm->Index;
		$this->project_small_pic->Upload->UploadFile();
		$this->project_small_pic->CurrentValue = $this->project_small_pic->Upload->FileName;
		$this->project_pic->Upload->Index = $objForm->Index;
		$this->project_pic->Upload->UploadFile();
		$this->project_pic->CurrentValue = $this->project_pic->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->project_id->FldIsDetailKey)
			$this->project_id->setFormValue($objForm->GetValue("x_project_id"));
		if (!$this->project_title->FldIsDetailKey) {
			$this->project_title->setFormValue($objForm->GetValue("x_project_title"));
		}
		if (!$this->project_content->FldIsDetailKey) {
			$this->project_content->setFormValue($objForm->GetValue("x_project_content"));
		}
		if (!$this->project_category_id->FldIsDetailKey) {
			$this->project_category_id->setFormValue($objForm->GetValue("x_project_category_id"));
		}
		if (!$this->project_date->FldIsDetailKey) {
			$this->project_date->setFormValue($objForm->GetValue("x_project_date"));
		}
		if (!$this->project_client->FldIsDetailKey) {
			$this->project_client->setFormValue($objForm->GetValue("x_project_client"));
		}
		if (!$this->project_location->FldIsDetailKey) {
			$this->project_location->setFormValue($objForm->GetValue("x_project_location"));
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
		$this->LoadRow();
		$this->project_id->CurrentValue = $this->project_id->FormValue;
		$this->project_title->CurrentValue = $this->project_title->FormValue;
		$this->project_content->CurrentValue = $this->project_content->FormValue;
		$this->project_category_id->CurrentValue = $this->project_category_id->FormValue;
		$this->project_date->CurrentValue = $this->project_date->FormValue;
		$this->project_client->CurrentValue = $this->project_client->FormValue;
		$this->project_location->CurrentValue = $this->project_location->FormValue;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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

		// project_content
		$this->project_content->ViewValue = $this->project_content->CurrentValue;
		$this->project_content->ViewCustomAttributes = "";

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
				$this->project_small_pic->LinkAttrs["data-rel"] = "projects_x_project_small_pic";

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
				$this->project_pic->LinkAttrs["data-rel"] = "projects_x_project_pic";

				//$this->project_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->project_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->project_pic->LinkAttrs["data-container"] = "body";

				$this->project_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// project_content
			$this->project_content->LinkCustomAttributes = "";
			$this->project_content->HrefValue = "";
			$this->project_content->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// project_id
			$this->project_id->EditAttrs["class"] = "form-control";
			$this->project_id->EditCustomAttributes = "";
			$this->project_id->EditValue = $this->project_id->CurrentValue;
			$this->project_id->ViewCustomAttributes = "";

			// project_title
			$this->project_title->EditAttrs["class"] = "form-control";
			$this->project_title->EditCustomAttributes = "";
			$this->project_title->EditValue = ew_HtmlEncode($this->project_title->CurrentValue);
			$this->project_title->PlaceHolder = ew_RemoveHtml($this->project_title->FldCaption());

			// project_small_pic
			$this->project_small_pic->EditAttrs["class"] = "form-control";
			$this->project_small_pic->EditCustomAttributes = "";
			$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
			if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
				$this->project_small_pic->ImageWidth = 100;
				$this->project_small_pic->ImageHeight = 120;
				$this->project_small_pic->ImageAlt = $this->project_small_pic->FldAlt();
				$this->project_small_pic->EditValue = $this->project_small_pic->Upload->DbValue;
			} else {
				$this->project_small_pic->EditValue = "";
			}
			if (!ew_Empty($this->project_small_pic->CurrentValue))
				$this->project_small_pic->Upload->FileName = $this->project_small_pic->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->project_small_pic);

			// project_pic
			$this->project_pic->EditAttrs["class"] = "form-control";
			$this->project_pic->EditCustomAttributes = "";
			$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
			if (!ew_Empty($this->project_pic->Upload->DbValue)) {
				$this->project_pic->ImageWidth = 120;
				$this->project_pic->ImageHeight = 45;
				$this->project_pic->ImageAlt = $this->project_pic->FldAlt();
				$this->project_pic->EditValue = $this->project_pic->Upload->DbValue;
			} else {
				$this->project_pic->EditValue = "";
			}
			if (!ew_Empty($this->project_pic->CurrentValue))
				$this->project_pic->Upload->FileName = $this->project_pic->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->project_pic);

			// project_content
			$this->project_content->EditAttrs["class"] = "form-control";
			$this->project_content->EditCustomAttributes = "";
			$this->project_content->EditValue = ew_HtmlEncode($this->project_content->CurrentValue);
			$this->project_content->PlaceHolder = ew_RemoveHtml($this->project_content->FldCaption());

			// project_category_id
			$this->project_category_id->EditAttrs["class"] = "form-control";
			$this->project_category_id->EditCustomAttributes = "";
			if (trim(strval($this->project_category_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`project_category_id`" . ew_SearchString("=", $this->project_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `project_category_id`, `project_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `project_categories`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->project_category_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->project_category_id->EditValue = $arwrk;

			// project_date
			$this->project_date->EditAttrs["class"] = "form-control";
			$this->project_date->EditCustomAttributes = "";
			$this->project_date->EditValue = ew_HtmlEncode($this->project_date->CurrentValue);
			$this->project_date->PlaceHolder = ew_RemoveHtml($this->project_date->FldCaption());

			// project_client
			$this->project_client->EditAttrs["class"] = "form-control";
			$this->project_client->EditCustomAttributes = "";
			$this->project_client->EditValue = ew_HtmlEncode($this->project_client->CurrentValue);
			$this->project_client->PlaceHolder = ew_RemoveHtml($this->project_client->FldCaption());

			// project_location
			$this->project_location->EditAttrs["class"] = "form-control";
			$this->project_location->EditCustomAttributes = "";
			$this->project_location->EditValue = ew_HtmlEncode($this->project_location->CurrentValue);
			$this->project_location->PlaceHolder = ew_RemoveHtml($this->project_location->FldCaption());

			// sort_order
			$this->sort_order->EditAttrs["class"] = "form-control";
			$this->sort_order->EditCustomAttributes = "";
			$this->sort_order->EditValue = ew_HtmlEncode($this->sort_order->CurrentValue);
			$this->sort_order->PlaceHolder = ew_RemoveHtml($this->sort_order->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// project_id

			$this->project_id->HrefValue = "";

			// project_title
			$this->project_title->HrefValue = "";

			// project_small_pic
			$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
			if (!ew_Empty($this->project_small_pic->Upload->DbValue)) {
				$this->project_small_pic->HrefValue = ew_GetFileUploadUrl($this->project_small_pic, $this->project_small_pic->Upload->DbValue); // Add prefix/suffix
				$this->project_small_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->project_small_pic->HrefValue = ew_ConvertFullUrl($this->project_small_pic->HrefValue);
			} else {
				$this->project_small_pic->HrefValue = "";
			}
			$this->project_small_pic->HrefValue2 = $this->project_small_pic->UploadPath . $this->project_small_pic->Upload->DbValue;

			// project_pic
			$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
			if (!ew_Empty($this->project_pic->Upload->DbValue)) {
				$this->project_pic->HrefValue = ew_GetFileUploadUrl($this->project_pic, $this->project_pic->Upload->DbValue); // Add prefix/suffix
				$this->project_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->project_pic->HrefValue = ew_ConvertFullUrl($this->project_pic->HrefValue);
			} else {
				$this->project_pic->HrefValue = "";
			}
			$this->project_pic->HrefValue2 = $this->project_pic->UploadPath . $this->project_pic->Upload->DbValue;

			// project_content
			$this->project_content->HrefValue = "";

			// project_category_id
			$this->project_category_id->HrefValue = "";

			// project_date
			$this->project_date->HrefValue = "";

			// project_client
			$this->project_client->HrefValue = "";

			// project_location
			$this->project_location->HrefValue = "";

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
		if (!$this->project_title->FldIsDetailKey && !is_null($this->project_title->FormValue) && $this->project_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_title->FldCaption(), $this->project_title->ReqErrMsg));
		}
		if ($this->project_small_pic->Upload->FileName == "" && !$this->project_small_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_small_pic->FldCaption(), $this->project_small_pic->ReqErrMsg));
		}
		if ($this->project_pic->Upload->FileName == "" && !$this->project_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_pic->FldCaption(), $this->project_pic->ReqErrMsg));
		}
		if (!$this->project_content->FldIsDetailKey && !is_null($this->project_content->FormValue) && $this->project_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_content->FldCaption(), $this->project_content->ReqErrMsg));
		}
		if (!$this->project_category_id->FldIsDetailKey && !is_null($this->project_category_id->FormValue) && $this->project_category_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_category_id->FldCaption(), $this->project_category_id->ReqErrMsg));
		}
		if (!$this->project_date->FldIsDetailKey && !is_null($this->project_date->FormValue) && $this->project_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_date->FldCaption(), $this->project_date->ReqErrMsg));
		}
		if (!$this->project_client->FldIsDetailKey && !is_null($this->project_client->FormValue) && $this->project_client->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_client->FldCaption(), $this->project_client->ReqErrMsg));
		}
		if (!$this->project_location->FldIsDetailKey && !is_null($this->project_location->FormValue) && $this->project_location->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->project_location->FldCaption(), $this->project_location->ReqErrMsg));
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
			$this->project_small_pic->OldUploadPath = '../src/assets/images/resource/projects';
			$this->project_small_pic->UploadPath = $this->project_small_pic->OldUploadPath;
			$this->project_pic->OldUploadPath = '../src/assets/images/resource/projects';
			$this->project_pic->UploadPath = $this->project_pic->OldUploadPath;
			$rsnew = array();

			// project_title
			$this->project_title->SetDbValueDef($rsnew, $this->project_title->CurrentValue, "", $this->project_title->ReadOnly);

			// project_small_pic
			if (!($this->project_small_pic->ReadOnly) && !$this->project_small_pic->Upload->KeepFile) {
				$this->project_small_pic->Upload->DbValue = $rsold['project_small_pic']; // Get original value
				if ($this->project_small_pic->Upload->FileName == "") {
					$rsnew['project_small_pic'] = NULL;
				} else {
					$rsnew['project_small_pic'] = $this->project_small_pic->Upload->FileName;
				}
				$this->project_small_pic->ImageWidth = 380; // Resize width
				$this->project_small_pic->ImageHeight = 485; // Resize height
			}

			// project_pic
			if (!($this->project_pic->ReadOnly) && !$this->project_pic->Upload->KeepFile) {
				$this->project_pic->Upload->DbValue = $rsold['project_pic']; // Get original value
				if ($this->project_pic->Upload->FileName == "") {
					$rsnew['project_pic'] = NULL;
				} else {
					$rsnew['project_pic'] = $this->project_pic->Upload->FileName;
				}
				$this->project_pic->ImageWidth = 1050; // Resize width
				$this->project_pic->ImageHeight = 466; // Resize height
			}

			// project_content
			$this->project_content->SetDbValueDef($rsnew, $this->project_content->CurrentValue, "", $this->project_content->ReadOnly);

			// project_category_id
			$this->project_category_id->SetDbValueDef($rsnew, $this->project_category_id->CurrentValue, 0, $this->project_category_id->ReadOnly);

			// project_date
			$this->project_date->SetDbValueDef($rsnew, $this->project_date->CurrentValue, "", $this->project_date->ReadOnly);

			// project_client
			$this->project_client->SetDbValueDef($rsnew, $this->project_client->CurrentValue, "", $this->project_client->ReadOnly);

			// project_location
			$this->project_location->SetDbValueDef($rsnew, $this->project_location->CurrentValue, "", $this->project_location->ReadOnly);

			// sort_order
			$this->sort_order->SetDbValueDef($rsnew, $this->sort_order->CurrentValue, 0, $this->sort_order->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);
			if (!$this->project_small_pic->Upload->KeepFile) {
				$this->project_small_pic->UploadPath = '../src/assets/images/resource/projects';
				if (!ew_Empty($this->project_small_pic->Upload->Value)) {
					$rsnew['project_small_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->project_small_pic->UploadPath), $rsnew['project_small_pic']); // Get new file name
				}
			}
			if (!$this->project_pic->Upload->KeepFile) {
				$this->project_pic->UploadPath = '../src/assets/images/resource/projects';
				if (!ew_Empty($this->project_pic->Upload->Value)) {
					$rsnew['project_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->project_pic->UploadPath), $rsnew['project_pic']); // Get new file name
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
					if (!$this->project_small_pic->Upload->KeepFile) {
						if (!ew_Empty($this->project_small_pic->Upload->Value)) {
							$this->project_small_pic->Upload->Resize($this->project_small_pic->ImageWidth, $this->project_small_pic->ImageHeight);
							$this->project_small_pic->Upload->SaveToFile($this->project_small_pic->UploadPath, $rsnew['project_small_pic'], TRUE);
						}
					}
					if (!$this->project_pic->Upload->KeepFile) {
						if (!ew_Empty($this->project_pic->Upload->Value)) {
							$this->project_pic->Upload->Resize($this->project_pic->ImageWidth, $this->project_pic->ImageHeight);
							$this->project_pic->Upload->SaveToFile($this->project_pic->UploadPath, $rsnew['project_pic'], TRUE);
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

		// project_small_pic
		ew_CleanUploadTempPath($this->project_small_pic, $this->project_small_pic->Upload->Index);

		// project_pic
		ew_CleanUploadTempPath($this->project_pic, $this->project_pic->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "projectslist.php", "", $this->TableVar, TRUE);
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
if (!isset($projects_edit)) $projects_edit = new cprojects_edit();

// Page init
$projects_edit->Page_Init();

// Page main
$projects_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fprojectsedit = new ew_Form("fprojectsedit", "edit");

// Validate form
fprojectsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_project_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_title->FldCaption(), $projects->project_title->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_project_small_pic");
			elm = this.GetElements("fn_x" + infix + "_project_small_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_small_pic->FldCaption(), $projects->project_small_pic->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_project_pic");
			elm = this.GetElements("fn_x" + infix + "_project_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_pic->FldCaption(), $projects->project_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_project_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_content->FldCaption(), $projects->project_content->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_project_category_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_category_id->FldCaption(), $projects->project_category_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_project_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_date->FldCaption(), $projects->project_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_project_client");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_client->FldCaption(), $projects->project_client->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_project_location");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->project_location->FldCaption(), $projects->project_location->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->sort_order->FldCaption(), $projects->sort_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sort_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->sort_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->status->FldCaption(), $projects->status->ReqErrMsg)) ?>");

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
fprojectsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectsedit.ValidateRequired = true;
<?php } else { ?>
fprojectsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fprojectsedit.Lists["x_project_category_id"] = {"LinkField":"x_project_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_project_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectsedit.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectsedit.Lists["x_status"].Options = <?php echo json_encode($projects->status->Options()) ?>;

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
<?php $projects_edit->ShowPageHeader(); ?>
<?php
$projects_edit->ShowMessage();
?>
<form name="fprojectsedit" id="fprojectsedit" class="<?php echo $projects_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($projects->project_id->Visible) { // project_id ?>
	<div id="r_project_id" class="form-group">
		<label id="elh_projects_project_id" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_id->CellAttributes() ?>>
<span id="el_projects_project_id">
<span<?php echo $projects->project_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $projects->project_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="projects" data-field="x_project_id" name="x_project_id" id="x_project_id" value="<?php echo ew_HtmlEncode($projects->project_id->CurrentValue) ?>">
<?php echo $projects->project_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_title->Visible) { // project_title ?>
	<div id="r_project_title" class="form-group">
		<label id="elh_projects_project_title" for="x_project_title" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_title->CellAttributes() ?>>
<span id="el_projects_project_title">
<input type="text" data-table="projects" data-field="x_project_title" name="x_project_title" id="x_project_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->project_title->getPlaceHolder()) ?>" value="<?php echo $projects->project_title->EditValue ?>"<?php echo $projects->project_title->EditAttributes() ?>>
</span>
<?php echo $projects->project_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_small_pic->Visible) { // project_small_pic ?>
	<div id="r_project_small_pic" class="form-group">
		<label id="elh_projects_project_small_pic" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_small_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_small_pic->CellAttributes() ?>>
<span id="el_projects_project_small_pic">
<div id="fd_x_project_small_pic">
<span title="<?php echo $projects->project_small_pic->FldTitle() ? $projects->project_small_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($projects->project_small_pic->ReadOnly || $projects->project_small_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="projects" data-field="x_project_small_pic" name="x_project_small_pic" id="x_project_small_pic"<?php echo $projects->project_small_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_project_small_pic" id= "fn_x_project_small_pic" value="<?php echo $projects->project_small_pic->Upload->FileName ?>">
<?php if (@$_POST["fa_x_project_small_pic"] == "0") { ?>
<input type="hidden" name="fa_x_project_small_pic" id= "fa_x_project_small_pic" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_project_small_pic" id= "fa_x_project_small_pic" value="1">
<?php } ?>
<input type="hidden" name="fs_x_project_small_pic" id= "fs_x_project_small_pic" value="255">
<input type="hidden" name="fx_x_project_small_pic" id= "fx_x_project_small_pic" value="<?php echo $projects->project_small_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_project_small_pic" id= "fm_x_project_small_pic" value="<?php echo $projects->project_small_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_project_small_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $projects->project_small_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_pic->Visible) { // project_pic ?>
	<div id="r_project_pic" class="form-group">
		<label id="elh_projects_project_pic" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_pic->CellAttributes() ?>>
<span id="el_projects_project_pic">
<div id="fd_x_project_pic">
<span title="<?php echo $projects->project_pic->FldTitle() ? $projects->project_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($projects->project_pic->ReadOnly || $projects->project_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="projects" data-field="x_project_pic" name="x_project_pic" id="x_project_pic"<?php echo $projects->project_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_project_pic" id= "fn_x_project_pic" value="<?php echo $projects->project_pic->Upload->FileName ?>">
<?php if (@$_POST["fa_x_project_pic"] == "0") { ?>
<input type="hidden" name="fa_x_project_pic" id= "fa_x_project_pic" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_project_pic" id= "fa_x_project_pic" value="1">
<?php } ?>
<input type="hidden" name="fs_x_project_pic" id= "fs_x_project_pic" value="255">
<input type="hidden" name="fx_x_project_pic" id= "fx_x_project_pic" value="<?php echo $projects->project_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_project_pic" id= "fm_x_project_pic" value="<?php echo $projects->project_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_project_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $projects->project_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_content->Visible) { // project_content ?>
	<div id="r_project_content" class="form-group">
		<label id="elh_projects_project_content" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_content->CellAttributes() ?>>
<span id="el_projects_project_content">
<?php ew_AppendClass($projects->project_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="projects" data-field="x_project_content" name="x_project_content" id="x_project_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($projects->project_content->getPlaceHolder()) ?>"<?php echo $projects->project_content->EditAttributes() ?>><?php echo $projects->project_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fprojectsedit", "x_project_content", 35, 4, <?php echo ($projects->project_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $projects->project_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_category_id->Visible) { // project_category_id ?>
	<div id="r_project_category_id" class="form-group">
		<label id="elh_projects_project_category_id" for="x_project_category_id" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_category_id->CellAttributes() ?>>
<span id="el_projects_project_category_id">
<select data-table="projects" data-field="x_project_category_id" data-value-separator="<?php echo ew_HtmlEncode(is_array($projects->project_category_id->DisplayValueSeparator) ? json_encode($projects->project_category_id->DisplayValueSeparator) : $projects->project_category_id->DisplayValueSeparator) ?>" id="x_project_category_id" name="x_project_category_id"<?php echo $projects->project_category_id->EditAttributes() ?>>
<?php
if (is_array($projects->project_category_id->EditValue)) {
	$arwrk = $projects->project_category_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($projects->project_category_id->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $projects->project_category_id->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($projects->project_category_id->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($projects->project_category_id->CurrentValue) ?>" selected><?php echo $projects->project_category_id->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `project_category_id`, `project_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `project_categories`";
$sWhereWrk = "";
$projects->project_category_id->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$projects->project_category_id->LookupFilters += array("f0" => "`project_category_id` = {filter_value}", "t0" => "19", "fn0" => "");
$sSqlWrk = "";
$projects->Lookup_Selecting($projects->project_category_id, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $projects->project_category_id->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_project_category_id" id="s_x_project_category_id" value="<?php echo $projects->project_category_id->LookupFilterQuery() ?>">
</span>
<?php echo $projects->project_category_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_date->Visible) { // project_date ?>
	<div id="r_project_date" class="form-group">
		<label id="elh_projects_project_date" for="x_project_date" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_date->CellAttributes() ?>>
<span id="el_projects_project_date">
<input type="text" data-table="projects" data-field="x_project_date" name="x_project_date" id="x_project_date" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->project_date->getPlaceHolder()) ?>" value="<?php echo $projects->project_date->EditValue ?>"<?php echo $projects->project_date->EditAttributes() ?>>
</span>
<?php echo $projects->project_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_client->Visible) { // project_client ?>
	<div id="r_project_client" class="form-group">
		<label id="elh_projects_project_client" for="x_project_client" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_client->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_client->CellAttributes() ?>>
<span id="el_projects_project_client">
<input type="text" data-table="projects" data-field="x_project_client" name="x_project_client" id="x_project_client" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->project_client->getPlaceHolder()) ?>" value="<?php echo $projects->project_client->EditValue ?>"<?php echo $projects->project_client->EditAttributes() ?>>
</span>
<?php echo $projects->project_client->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_location->Visible) { // project_location ?>
	<div id="r_project_location" class="form-group">
		<label id="elh_projects_project_location" for="x_project_location" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_location->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_location->CellAttributes() ?>>
<span id="el_projects_project_location">
<input type="text" data-table="projects" data-field="x_project_location" name="x_project_location" id="x_project_location" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->project_location->getPlaceHolder()) ?>" value="<?php echo $projects->project_location->EditValue ?>"<?php echo $projects->project_location->EditAttributes() ?>>
</span>
<?php echo $projects->project_location->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->sort_order->Visible) { // sort_order ?>
	<div id="r_sort_order" class="form-group">
		<label id="elh_projects_sort_order" for="x_sort_order" class="col-sm-2 control-label ewLabel"><?php echo $projects->sort_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->sort_order->CellAttributes() ?>>
<span id="el_projects_sort_order">
<input type="text" data-table="projects" data-field="x_sort_order" name="x_sort_order" id="x_sort_order" size="30" placeholder="<?php echo ew_HtmlEncode($projects->sort_order->getPlaceHolder()) ?>" value="<?php echo $projects->sort_order->EditValue ?>"<?php echo $projects->sort_order->EditAttributes() ?>>
</span>
<?php echo $projects->sort_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_projects_status" class="col-sm-2 control-label ewLabel"><?php echo $projects->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->status->CellAttributes() ?>>
<span id="el_projects_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="projects" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($projects->status->DisplayValueSeparator) ? json_encode($projects->status->DisplayValueSeparator) : $projects->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $projects->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $projects->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($projects->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
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
<?php echo $projects->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $projects_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fprojectsedit.Init();
</script>
<?php
$projects_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$projects_edit->Page_Terminate();
?>
