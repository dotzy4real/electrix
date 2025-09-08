<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "skyview_homebannersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$skyview_homebanners_delete = NULL; // Initialize page object first

class cskyview_homebanners_delete extends cskyview_homebanners {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'skyview_homebanners';

	// Page object name
	var $PageObjName = 'skyview_homebanners_delete';

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

		// Table object (skyview_homebanners)
		if (!isset($GLOBALS["skyview_homebanners"]) || get_class($GLOBALS["skyview_homebanners"]) == "cskyview_homebanners") {
			$GLOBALS["skyview_homebanners"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["skyview_homebanners"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'skyview_homebanners', TRUE);

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
		$this->skyview_homebanner_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $skyview_homebanners;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($skyview_homebanners);
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
			$this->Page_Terminate("skyview_homebannerslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in skyview_homebanners class, skyview_homebannersinfo.php

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
		$this->skyview_homebanner_id->setDbValue($rs->fields('skyview_homebanner_id'));
		$this->skyview_homebanner_top_title->setDbValue($rs->fields('skyview_homebanner_top_title'));
		$this->skyview_homebanner_main_title->setDbValue($rs->fields('skyview_homebanner_main_title'));
		$this->skyview_homebanner_pic->Upload->DbValue = $rs->fields('skyview_homebanner_pic');
		$this->skyview_homebanner_pic->CurrentValue = $this->skyview_homebanner_pic->Upload->DbValue;
		$this->skyview_homebanner_button_text->setDbValue($rs->fields('skyview_homebanner_button_text'));
		$this->skyview_homebanner_button_link->setDbValue($rs->fields('skyview_homebanner_button_link'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->skyview_homebanner_id->DbValue = $row['skyview_homebanner_id'];
		$this->skyview_homebanner_top_title->DbValue = $row['skyview_homebanner_top_title'];
		$this->skyview_homebanner_main_title->DbValue = $row['skyview_homebanner_main_title'];
		$this->skyview_homebanner_pic->Upload->DbValue = $row['skyview_homebanner_pic'];
		$this->skyview_homebanner_button_text->DbValue = $row['skyview_homebanner_button_text'];
		$this->skyview_homebanner_button_link->DbValue = $row['skyview_homebanner_button_link'];
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
		// skyview_homebanner_id
		// skyview_homebanner_top_title
		// skyview_homebanner_main_title
		// skyview_homebanner_pic
		// skyview_homebanner_button_text
		// skyview_homebanner_button_link
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// skyview_homebanner_id
		$this->skyview_homebanner_id->ViewValue = $this->skyview_homebanner_id->CurrentValue;
		$this->skyview_homebanner_id->ViewCustomAttributes = "";

		// skyview_homebanner_top_title
		$this->skyview_homebanner_top_title->ViewValue = $this->skyview_homebanner_top_title->CurrentValue;
		$this->skyview_homebanner_top_title->ViewCustomAttributes = "";

		// skyview_homebanner_main_title
		$this->skyview_homebanner_main_title->ViewValue = $this->skyview_homebanner_main_title->CurrentValue;
		$this->skyview_homebanner_main_title->ViewCustomAttributes = "";

		// skyview_homebanner_pic
		$this->skyview_homebanner_pic->UploadPath = '../src/assets/images/skyview/homebanners';
		if (!ew_Empty($this->skyview_homebanner_pic->Upload->DbValue)) {
			$this->skyview_homebanner_pic->ImageWidth = 120;
			$this->skyview_homebanner_pic->ImageHeight = 65;
			$this->skyview_homebanner_pic->ImageAlt = $this->skyview_homebanner_pic->FldAlt();
			$this->skyview_homebanner_pic->ViewValue = $this->skyview_homebanner_pic->Upload->DbValue;
		} else {
			$this->skyview_homebanner_pic->ViewValue = "";
		}
		$this->skyview_homebanner_pic->ViewCustomAttributes = "";

		// skyview_homebanner_button_text
		$this->skyview_homebanner_button_text->ViewValue = $this->skyview_homebanner_button_text->CurrentValue;
		$this->skyview_homebanner_button_text->ViewCustomAttributes = "";

		// skyview_homebanner_button_link
		$this->skyview_homebanner_button_link->ViewValue = $this->skyview_homebanner_button_link->CurrentValue;
		$this->skyview_homebanner_button_link->ViewCustomAttributes = "";

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

			// skyview_homebanner_id
			$this->skyview_homebanner_id->LinkCustomAttributes = "";
			$this->skyview_homebanner_id->HrefValue = "";
			$this->skyview_homebanner_id->TooltipValue = "";

			// skyview_homebanner_top_title
			$this->skyview_homebanner_top_title->LinkCustomAttributes = "";
			$this->skyview_homebanner_top_title->HrefValue = "";
			$this->skyview_homebanner_top_title->TooltipValue = "";

			// skyview_homebanner_main_title
			$this->skyview_homebanner_main_title->LinkCustomAttributes = "";
			$this->skyview_homebanner_main_title->HrefValue = "";
			$this->skyview_homebanner_main_title->TooltipValue = "";

			// skyview_homebanner_pic
			$this->skyview_homebanner_pic->LinkCustomAttributes = "";
			$this->skyview_homebanner_pic->UploadPath = '../src/assets/images/skyview/homebanners';
			if (!ew_Empty($this->skyview_homebanner_pic->Upload->DbValue)) {
				$this->skyview_homebanner_pic->HrefValue = ew_GetFileUploadUrl($this->skyview_homebanner_pic, $this->skyview_homebanner_pic->Upload->DbValue); // Add prefix/suffix
				$this->skyview_homebanner_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->skyview_homebanner_pic->HrefValue = ew_ConvertFullUrl($this->skyview_homebanner_pic->HrefValue);
			} else {
				$this->skyview_homebanner_pic->HrefValue = "";
			}
			$this->skyview_homebanner_pic->HrefValue2 = $this->skyview_homebanner_pic->UploadPath . $this->skyview_homebanner_pic->Upload->DbValue;
			$this->skyview_homebanner_pic->TooltipValue = "";
			if ($this->skyview_homebanner_pic->UseColorbox) {
				$this->skyview_homebanner_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->skyview_homebanner_pic->LinkAttrs["data-rel"] = "skyview_homebanners_x_skyview_homebanner_pic";

				//$this->skyview_homebanner_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->skyview_homebanner_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->skyview_homebanner_pic->LinkAttrs["data-container"] = "body";

				$this->skyview_homebanner_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// skyview_homebanner_button_text
			$this->skyview_homebanner_button_text->LinkCustomAttributes = "";
			$this->skyview_homebanner_button_text->HrefValue = "";
			$this->skyview_homebanner_button_text->TooltipValue = "";

			// skyview_homebanner_button_link
			$this->skyview_homebanner_button_link->LinkCustomAttributes = "";
			$this->skyview_homebanner_button_link->HrefValue = "";
			$this->skyview_homebanner_button_link->TooltipValue = "";

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
				$sThisKey .= $row['skyview_homebanner_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "skyview_homebannerslist.php", "", $this->TableVar, TRUE);
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
if (!isset($skyview_homebanners_delete)) $skyview_homebanners_delete = new cskyview_homebanners_delete();

// Page init
$skyview_homebanners_delete->Page_Init();

// Page main
$skyview_homebanners_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$skyview_homebanners_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fskyview_homebannersdelete = new ew_Form("fskyview_homebannersdelete", "delete");

// Form_CustomValidate event
fskyview_homebannersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fskyview_homebannersdelete.ValidateRequired = true;
<?php } else { ?>
fskyview_homebannersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fskyview_homebannersdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fskyview_homebannersdelete.Lists["x_status"].Options = <?php echo json_encode($skyview_homebanners->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($skyview_homebanners_delete->Recordset = $skyview_homebanners_delete->LoadRecordset())
	$skyview_homebanners_deleteTotalRecs = $skyview_homebanners_delete->Recordset->RecordCount(); // Get record count
if ($skyview_homebanners_deleteTotalRecs <= 0) { // No record found, exit
	if ($skyview_homebanners_delete->Recordset)
		$skyview_homebanners_delete->Recordset->Close();
	$skyview_homebanners_delete->Page_Terminate("skyview_homebannerslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $skyview_homebanners_delete->ShowPageHeader(); ?>
<?php
$skyview_homebanners_delete->ShowMessage();
?>
<form name="fskyview_homebannersdelete" id="fskyview_homebannersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($skyview_homebanners_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $skyview_homebanners_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="skyview_homebanners">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($skyview_homebanners_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $skyview_homebanners->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($skyview_homebanners->skyview_homebanner_id->Visible) { // skyview_homebanner_id ?>
		<th><span id="elh_skyview_homebanners_skyview_homebanner_id" class="skyview_homebanners_skyview_homebanner_id"><?php echo $skyview_homebanners->skyview_homebanner_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_top_title->Visible) { // skyview_homebanner_top_title ?>
		<th><span id="elh_skyview_homebanners_skyview_homebanner_top_title" class="skyview_homebanners_skyview_homebanner_top_title"><?php echo $skyview_homebanners->skyview_homebanner_top_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_main_title->Visible) { // skyview_homebanner_main_title ?>
		<th><span id="elh_skyview_homebanners_skyview_homebanner_main_title" class="skyview_homebanners_skyview_homebanner_main_title"><?php echo $skyview_homebanners->skyview_homebanner_main_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_pic->Visible) { // skyview_homebanner_pic ?>
		<th><span id="elh_skyview_homebanners_skyview_homebanner_pic" class="skyview_homebanners_skyview_homebanner_pic"><?php echo $skyview_homebanners->skyview_homebanner_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_button_text->Visible) { // skyview_homebanner_button_text ?>
		<th><span id="elh_skyview_homebanners_skyview_homebanner_button_text" class="skyview_homebanners_skyview_homebanner_button_text"><?php echo $skyview_homebanners->skyview_homebanner_button_text->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_button_link->Visible) { // skyview_homebanner_button_link ?>
		<th><span id="elh_skyview_homebanners_skyview_homebanner_button_link" class="skyview_homebanners_skyview_homebanner_button_link"><?php echo $skyview_homebanners->skyview_homebanner_button_link->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_skyview_homebanners_sort_order" class="skyview_homebanners_sort_order"><?php echo $skyview_homebanners->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($skyview_homebanners->status->Visible) { // status ?>
		<th><span id="elh_skyview_homebanners_status" class="skyview_homebanners_status"><?php echo $skyview_homebanners->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$skyview_homebanners_delete->RecCnt = 0;
$i = 0;
while (!$skyview_homebanners_delete->Recordset->EOF) {
	$skyview_homebanners_delete->RecCnt++;
	$skyview_homebanners_delete->RowCnt++;

	// Set row properties
	$skyview_homebanners->ResetAttrs();
	$skyview_homebanners->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$skyview_homebanners_delete->LoadRowValues($skyview_homebanners_delete->Recordset);

	// Render row
	$skyview_homebanners_delete->RenderRow();
?>
	<tr<?php echo $skyview_homebanners->RowAttributes() ?>>
<?php if ($skyview_homebanners->skyview_homebanner_id->Visible) { // skyview_homebanner_id ?>
		<td<?php echo $skyview_homebanners->skyview_homebanner_id->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_skyview_homebanner_id" class="skyview_homebanners_skyview_homebanner_id">
<span<?php echo $skyview_homebanners->skyview_homebanner_id->ViewAttributes() ?>>
<?php echo $skyview_homebanners->skyview_homebanner_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_top_title->Visible) { // skyview_homebanner_top_title ?>
		<td<?php echo $skyview_homebanners->skyview_homebanner_top_title->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_skyview_homebanner_top_title" class="skyview_homebanners_skyview_homebanner_top_title">
<span<?php echo $skyview_homebanners->skyview_homebanner_top_title->ViewAttributes() ?>>
<?php echo $skyview_homebanners->skyview_homebanner_top_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_main_title->Visible) { // skyview_homebanner_main_title ?>
		<td<?php echo $skyview_homebanners->skyview_homebanner_main_title->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_skyview_homebanner_main_title" class="skyview_homebanners_skyview_homebanner_main_title">
<span<?php echo $skyview_homebanners->skyview_homebanner_main_title->ViewAttributes() ?>>
<?php echo $skyview_homebanners->skyview_homebanner_main_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_pic->Visible) { // skyview_homebanner_pic ?>
		<td<?php echo $skyview_homebanners->skyview_homebanner_pic->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_skyview_homebanner_pic" class="skyview_homebanners_skyview_homebanner_pic">
<span>
<?php echo ew_GetFileViewTag($skyview_homebanners->skyview_homebanner_pic, $skyview_homebanners->skyview_homebanner_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_button_text->Visible) { // skyview_homebanner_button_text ?>
		<td<?php echo $skyview_homebanners->skyview_homebanner_button_text->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_skyview_homebanner_button_text" class="skyview_homebanners_skyview_homebanner_button_text">
<span<?php echo $skyview_homebanners->skyview_homebanner_button_text->ViewAttributes() ?>>
<?php echo $skyview_homebanners->skyview_homebanner_button_text->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->skyview_homebanner_button_link->Visible) { // skyview_homebanner_button_link ?>
		<td<?php echo $skyview_homebanners->skyview_homebanner_button_link->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_skyview_homebanner_button_link" class="skyview_homebanners_skyview_homebanner_button_link">
<span<?php echo $skyview_homebanners->skyview_homebanner_button_link->ViewAttributes() ?>>
<?php echo $skyview_homebanners->skyview_homebanner_button_link->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->sort_order->Visible) { // sort_order ?>
		<td<?php echo $skyview_homebanners->sort_order->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_sort_order" class="skyview_homebanners_sort_order">
<span<?php echo $skyview_homebanners->sort_order->ViewAttributes() ?>>
<?php echo $skyview_homebanners->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($skyview_homebanners->status->Visible) { // status ?>
		<td<?php echo $skyview_homebanners->status->CellAttributes() ?>>
<span id="el<?php echo $skyview_homebanners_delete->RowCnt ?>_skyview_homebanners_status" class="skyview_homebanners_status">
<span<?php echo $skyview_homebanners->status->ViewAttributes() ?>>
<?php echo $skyview_homebanners->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$skyview_homebanners_delete->Recordset->MoveNext();
}
$skyview_homebanners_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $skyview_homebanners_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fskyview_homebannersdelete.Init();
</script>
<?php
$skyview_homebanners_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$skyview_homebanners_delete->Page_Terminate();
?>
