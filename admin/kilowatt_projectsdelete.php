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

$kilowatt_projects_delete = NULL; // Initialize page object first

class ckilowatt_projects_delete extends ckilowatt_projects {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'kilowatt_projects';

	// Page object name
	var $PageObjName = 'kilowatt_projects_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->kilowatt_project_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("kilowatt_projectslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in kilowatt_projects class, kilowatt_projectsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
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

			// kilowatt_project_id
			$this->kilowatt_project_id->LinkCustomAttributes = "";
			$this->kilowatt_project_id->HrefValue = "";
			$this->kilowatt_project_id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['kilowatt_project_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "kilowatt_projectslist.php", "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($kilowatt_projects_delete)) $kilowatt_projects_delete = new ckilowatt_projects_delete();

// Page init
$kilowatt_projects_delete->Page_Init();

// Page main
$kilowatt_projects_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$kilowatt_projects_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fkilowatt_projectsdelete = new ew_Form("fkilowatt_projectsdelete", "delete");

// Form_CustomValidate event
fkilowatt_projectsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkilowatt_projectsdelete.ValidateRequired = true;
<?php } else { ?>
fkilowatt_projectsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fkilowatt_projectsdelete.Lists["x_kilowatt_service_category_id"] = {"LinkField":"x_kilowatt_service_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kilowatt_service_category_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fkilowatt_projectsdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fkilowatt_projectsdelete.Lists["x_status"].Options = <?php echo json_encode($kilowatt_projects->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($kilowatt_projects_delete->Recordset = $kilowatt_projects_delete->LoadRecordset())
	$kilowatt_projects_deleteTotalRecs = $kilowatt_projects_delete->Recordset->RecordCount(); // Get record count
if ($kilowatt_projects_deleteTotalRecs <= 0) { // No record found, exit
	if ($kilowatt_projects_delete->Recordset)
		$kilowatt_projects_delete->Recordset->Close();
	$kilowatt_projects_delete->Page_Terminate("kilowatt_projectslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $kilowatt_projects_delete->ShowPageHeader(); ?>
<?php
$kilowatt_projects_delete->ShowMessage();
?>
<form name="fkilowatt_projectsdelete" id="fkilowatt_projectsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($kilowatt_projects_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $kilowatt_projects_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="kilowatt_projects">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($kilowatt_projects_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $kilowatt_projects->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($kilowatt_projects->kilowatt_project_id->Visible) { // kilowatt_project_id ?>
		<th><span id="elh_kilowatt_projects_kilowatt_project_id" class="kilowatt_projects_kilowatt_project_id"><?php echo $kilowatt_projects->kilowatt_project_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_project_pic->Visible) { // kilowatt_project_pic ?>
		<th><span id="elh_kilowatt_projects_kilowatt_project_pic" class="kilowatt_projects_kilowatt_project_pic"><?php echo $kilowatt_projects->kilowatt_project_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_project_title->Visible) { // kilowatt_project_title ?>
		<th><span id="elh_kilowatt_projects_kilowatt_project_title" class="kilowatt_projects_kilowatt_project_title"><?php echo $kilowatt_projects->kilowatt_project_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_service_category_id->Visible) { // kilowatt_service_category_id ?>
		<th><span id="elh_kilowatt_projects_kilowatt_service_category_id" class="kilowatt_projects_kilowatt_service_category_id"><?php echo $kilowatt_projects->kilowatt_service_category_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_projects->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_kilowatt_projects_sort_order" class="kilowatt_projects_sort_order"><?php echo $kilowatt_projects->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_projects->status->Visible) { // status ?>
		<th><span id="elh_kilowatt_projects_status" class="kilowatt_projects_status"><?php echo $kilowatt_projects->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$kilowatt_projects_delete->RecCnt = 0;
$i = 0;
while (!$kilowatt_projects_delete->Recordset->EOF) {
	$kilowatt_projects_delete->RecCnt++;
	$kilowatt_projects_delete->RowCnt++;

	// Set row properties
	$kilowatt_projects->ResetAttrs();
	$kilowatt_projects->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$kilowatt_projects_delete->LoadRowValues($kilowatt_projects_delete->Recordset);

	// Render row
	$kilowatt_projects_delete->RenderRow();
?>
	<tr<?php echo $kilowatt_projects->RowAttributes() ?>>
<?php if ($kilowatt_projects->kilowatt_project_id->Visible) { // kilowatt_project_id ?>
		<td<?php echo $kilowatt_projects->kilowatt_project_id->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_projects_delete->RowCnt ?>_kilowatt_projects_kilowatt_project_id" class="kilowatt_projects_kilowatt_project_id">
<span<?php echo $kilowatt_projects->kilowatt_project_id->ViewAttributes() ?>>
<?php echo $kilowatt_projects->kilowatt_project_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_project_pic->Visible) { // kilowatt_project_pic ?>
		<td<?php echo $kilowatt_projects->kilowatt_project_pic->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_projects_delete->RowCnt ?>_kilowatt_projects_kilowatt_project_pic" class="kilowatt_projects_kilowatt_project_pic">
<span>
<?php echo ew_GetFileViewTag($kilowatt_projects->kilowatt_project_pic, $kilowatt_projects->kilowatt_project_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_project_title->Visible) { // kilowatt_project_title ?>
		<td<?php echo $kilowatt_projects->kilowatt_project_title->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_projects_delete->RowCnt ?>_kilowatt_projects_kilowatt_project_title" class="kilowatt_projects_kilowatt_project_title">
<span<?php echo $kilowatt_projects->kilowatt_project_title->ViewAttributes() ?>>
<?php echo $kilowatt_projects->kilowatt_project_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_projects->kilowatt_service_category_id->Visible) { // kilowatt_service_category_id ?>
		<td<?php echo $kilowatt_projects->kilowatt_service_category_id->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_projects_delete->RowCnt ?>_kilowatt_projects_kilowatt_service_category_id" class="kilowatt_projects_kilowatt_service_category_id">
<span<?php echo $kilowatt_projects->kilowatt_service_category_id->ViewAttributes() ?>>
<?php echo $kilowatt_projects->kilowatt_service_category_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_projects->sort_order->Visible) { // sort_order ?>
		<td<?php echo $kilowatt_projects->sort_order->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_projects_delete->RowCnt ?>_kilowatt_projects_sort_order" class="kilowatt_projects_sort_order">
<span<?php echo $kilowatt_projects->sort_order->ViewAttributes() ?>>
<?php echo $kilowatt_projects->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_projects->status->Visible) { // status ?>
		<td<?php echo $kilowatt_projects->status->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_projects_delete->RowCnt ?>_kilowatt_projects_status" class="kilowatt_projects_status">
<span<?php echo $kilowatt_projects->status->ViewAttributes() ?>>
<?php echo $kilowatt_projects->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$kilowatt_projects_delete->Recordset->MoveNext();
}
$kilowatt_projects_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $kilowatt_projects_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fkilowatt_projectsdelete.Init();
</script>
<?php
$kilowatt_projects_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$kilowatt_projects_delete->Page_Terminate();
?>
