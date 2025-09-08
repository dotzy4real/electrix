<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "management_teaminfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$management_team_delete = NULL; // Initialize page object first

class cmanagement_team_delete extends cmanagement_team {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'management_team';

	// Page object name
	var $PageObjName = 'management_team_delete';

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

		// Table object (management_team)
		if (!isset($GLOBALS["management_team"]) || get_class($GLOBALS["management_team"]) == "cmanagement_team") {
			$GLOBALS["management_team"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["management_team"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'management_team', TRUE);

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
		$this->management_team_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $management_team;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($management_team);
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
			$this->Page_Terminate("management_teamlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in management_team class, management_teaminfo.php

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
		$this->management_team_id->setDbValue($rs->fields('management_team_id'));
		$this->management_team_pic->Upload->DbValue = $rs->fields('management_team_pic');
		$this->management_team_pic->CurrentValue = $this->management_team_pic->Upload->DbValue;
		$this->management_team_name->setDbValue($rs->fields('management_team_name'));
		$this->management_team_designation->setDbValue($rs->fields('management_team_designation'));
		$this->management_team_content->setDbValue($rs->fields('management_team_content'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
		$this->management_team_linkedin->setDbValue($rs->fields('management_team_linkedin'));
		$this->management_team_facebook->setDbValue($rs->fields('management_team_facebook'));
		$this->management_team_twitter->setDbValue($rs->fields('management_team_twitter'));
		$this->management_team_email->setDbValue($rs->fields('management_team_email'));
		$this->management_team_phone->setDbValue($rs->fields('management_team_phone'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->management_team_id->DbValue = $row['management_team_id'];
		$this->management_team_pic->Upload->DbValue = $row['management_team_pic'];
		$this->management_team_name->DbValue = $row['management_team_name'];
		$this->management_team_designation->DbValue = $row['management_team_designation'];
		$this->management_team_content->DbValue = $row['management_team_content'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
		$this->management_team_linkedin->DbValue = $row['management_team_linkedin'];
		$this->management_team_facebook->DbValue = $row['management_team_facebook'];
		$this->management_team_twitter->DbValue = $row['management_team_twitter'];
		$this->management_team_email->DbValue = $row['management_team_email'];
		$this->management_team_phone->DbValue = $row['management_team_phone'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// management_team_id
		// management_team_pic
		// management_team_name
		// management_team_designation
		// management_team_content
		// sort_order
		// status
		// management_team_linkedin
		// management_team_facebook
		// management_team_twitter
		// management_team_email
		// management_team_phone

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// management_team_id
		$this->management_team_id->ViewValue = $this->management_team_id->CurrentValue;
		$this->management_team_id->ViewCustomAttributes = "";

		// management_team_pic
		$this->management_team_pic->UploadPath = '../src/assets/images/resource/management_team';
		if (!ew_Empty($this->management_team_pic->Upload->DbValue)) {
			$this->management_team_pic->ImageWidth = 100;
			$this->management_team_pic->ImageHeight = 120;
			$this->management_team_pic->ImageAlt = $this->management_team_pic->FldAlt();
			$this->management_team_pic->ViewValue = $this->management_team_pic->Upload->DbValue;
		} else {
			$this->management_team_pic->ViewValue = "";
		}
		$this->management_team_pic->ViewCustomAttributes = "";

		// management_team_name
		$this->management_team_name->ViewValue = $this->management_team_name->CurrentValue;
		$this->management_team_name->ViewCustomAttributes = "";

		// management_team_designation
		$this->management_team_designation->ViewValue = $this->management_team_designation->CurrentValue;
		$this->management_team_designation->ViewCustomAttributes = "";

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

		// management_team_linkedin
		$this->management_team_linkedin->ViewValue = $this->management_team_linkedin->CurrentValue;
		$this->management_team_linkedin->ViewCustomAttributes = "";

		// management_team_facebook
		$this->management_team_facebook->ViewValue = $this->management_team_facebook->CurrentValue;
		$this->management_team_facebook->ViewCustomAttributes = "";

		// management_team_twitter
		$this->management_team_twitter->ViewValue = $this->management_team_twitter->CurrentValue;
		$this->management_team_twitter->ViewCustomAttributes = "";

		// management_team_email
		$this->management_team_email->ViewValue = $this->management_team_email->CurrentValue;
		$this->management_team_email->ViewCustomAttributes = "";

		// management_team_phone
		$this->management_team_phone->ViewValue = $this->management_team_phone->CurrentValue;
		$this->management_team_phone->ViewCustomAttributes = "";

			// management_team_id
			$this->management_team_id->LinkCustomAttributes = "";
			$this->management_team_id->HrefValue = "";
			$this->management_team_id->TooltipValue = "";

			// management_team_pic
			$this->management_team_pic->LinkCustomAttributes = "";
			$this->management_team_pic->UploadPath = '../src/assets/images/resource/management_team';
			if (!ew_Empty($this->management_team_pic->Upload->DbValue)) {
				$this->management_team_pic->HrefValue = ew_GetFileUploadUrl($this->management_team_pic, $this->management_team_pic->Upload->DbValue); // Add prefix/suffix
				$this->management_team_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->management_team_pic->HrefValue = ew_ConvertFullUrl($this->management_team_pic->HrefValue);
			} else {
				$this->management_team_pic->HrefValue = "";
			}
			$this->management_team_pic->HrefValue2 = $this->management_team_pic->UploadPath . $this->management_team_pic->Upload->DbValue;
			$this->management_team_pic->TooltipValue = "";
			if ($this->management_team_pic->UseColorbox) {
				$this->management_team_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->management_team_pic->LinkAttrs["data-rel"] = "management_team_x_management_team_pic";

				//$this->management_team_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->management_team_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->management_team_pic->LinkAttrs["data-container"] = "body";

				$this->management_team_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// management_team_name
			$this->management_team_name->LinkCustomAttributes = "";
			$this->management_team_name->HrefValue = "";
			$this->management_team_name->TooltipValue = "";

			// management_team_designation
			$this->management_team_designation->LinkCustomAttributes = "";
			$this->management_team_designation->HrefValue = "";
			$this->management_team_designation->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// management_team_linkedin
			$this->management_team_linkedin->LinkCustomAttributes = "";
			$this->management_team_linkedin->HrefValue = "";
			$this->management_team_linkedin->TooltipValue = "";

			// management_team_facebook
			$this->management_team_facebook->LinkCustomAttributes = "";
			$this->management_team_facebook->HrefValue = "";
			$this->management_team_facebook->TooltipValue = "";

			// management_team_twitter
			$this->management_team_twitter->LinkCustomAttributes = "";
			$this->management_team_twitter->HrefValue = "";
			$this->management_team_twitter->TooltipValue = "";

			// management_team_email
			$this->management_team_email->LinkCustomAttributes = "";
			$this->management_team_email->HrefValue = "";
			$this->management_team_email->TooltipValue = "";

			// management_team_phone
			$this->management_team_phone->LinkCustomAttributes = "";
			$this->management_team_phone->HrefValue = "";
			$this->management_team_phone->TooltipValue = "";
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
				$sThisKey .= $row['management_team_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "management_teamlist.php", "", $this->TableVar, TRUE);
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
if (!isset($management_team_delete)) $management_team_delete = new cmanagement_team_delete();

// Page init
$management_team_delete->Page_Init();

// Page main
$management_team_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$management_team_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fmanagement_teamdelete = new ew_Form("fmanagement_teamdelete", "delete");

// Form_CustomValidate event
fmanagement_teamdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmanagement_teamdelete.ValidateRequired = true;
<?php } else { ?>
fmanagement_teamdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmanagement_teamdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmanagement_teamdelete.Lists["x_status"].Options = <?php echo json_encode($management_team->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($management_team_delete->Recordset = $management_team_delete->LoadRecordset())
	$management_team_deleteTotalRecs = $management_team_delete->Recordset->RecordCount(); // Get record count
if ($management_team_deleteTotalRecs <= 0) { // No record found, exit
	if ($management_team_delete->Recordset)
		$management_team_delete->Recordset->Close();
	$management_team_delete->Page_Terminate("management_teamlist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $management_team_delete->ShowPageHeader(); ?>
<?php
$management_team_delete->ShowMessage();
?>
<form name="fmanagement_teamdelete" id="fmanagement_teamdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($management_team_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $management_team_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="management_team">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($management_team_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $management_team->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($management_team->management_team_id->Visible) { // management_team_id ?>
		<th><span id="elh_management_team_management_team_id" class="management_team_management_team_id"><?php echo $management_team->management_team_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_pic->Visible) { // management_team_pic ?>
		<th><span id="elh_management_team_management_team_pic" class="management_team_management_team_pic"><?php echo $management_team->management_team_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_name->Visible) { // management_team_name ?>
		<th><span id="elh_management_team_management_team_name" class="management_team_management_team_name"><?php echo $management_team->management_team_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_designation->Visible) { // management_team_designation ?>
		<th><span id="elh_management_team_management_team_designation" class="management_team_management_team_designation"><?php echo $management_team->management_team_designation->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_management_team_sort_order" class="management_team_sort_order"><?php echo $management_team->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->status->Visible) { // status ?>
		<th><span id="elh_management_team_status" class="management_team_status"><?php echo $management_team->status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_linkedin->Visible) { // management_team_linkedin ?>
		<th><span id="elh_management_team_management_team_linkedin" class="management_team_management_team_linkedin"><?php echo $management_team->management_team_linkedin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_facebook->Visible) { // management_team_facebook ?>
		<th><span id="elh_management_team_management_team_facebook" class="management_team_management_team_facebook"><?php echo $management_team->management_team_facebook->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_twitter->Visible) { // management_team_twitter ?>
		<th><span id="elh_management_team_management_team_twitter" class="management_team_management_team_twitter"><?php echo $management_team->management_team_twitter->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_email->Visible) { // management_team_email ?>
		<th><span id="elh_management_team_management_team_email" class="management_team_management_team_email"><?php echo $management_team->management_team_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($management_team->management_team_phone->Visible) { // management_team_phone ?>
		<th><span id="elh_management_team_management_team_phone" class="management_team_management_team_phone"><?php echo $management_team->management_team_phone->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$management_team_delete->RecCnt = 0;
$i = 0;
while (!$management_team_delete->Recordset->EOF) {
	$management_team_delete->RecCnt++;
	$management_team_delete->RowCnt++;

	// Set row properties
	$management_team->ResetAttrs();
	$management_team->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$management_team_delete->LoadRowValues($management_team_delete->Recordset);

	// Render row
	$management_team_delete->RenderRow();
?>
	<tr<?php echo $management_team->RowAttributes() ?>>
<?php if ($management_team->management_team_id->Visible) { // management_team_id ?>
		<td<?php echo $management_team->management_team_id->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_id" class="management_team_management_team_id">
<span<?php echo $management_team->management_team_id->ViewAttributes() ?>>
<?php echo $management_team->management_team_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_pic->Visible) { // management_team_pic ?>
		<td<?php echo $management_team->management_team_pic->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_pic" class="management_team_management_team_pic">
<span>
<?php echo ew_GetFileViewTag($management_team->management_team_pic, $management_team->management_team_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_name->Visible) { // management_team_name ?>
		<td<?php echo $management_team->management_team_name->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_name" class="management_team_management_team_name">
<span<?php echo $management_team->management_team_name->ViewAttributes() ?>>
<?php echo $management_team->management_team_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_designation->Visible) { // management_team_designation ?>
		<td<?php echo $management_team->management_team_designation->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_designation" class="management_team_management_team_designation">
<span<?php echo $management_team->management_team_designation->ViewAttributes() ?>>
<?php echo $management_team->management_team_designation->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->sort_order->Visible) { // sort_order ?>
		<td<?php echo $management_team->sort_order->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_sort_order" class="management_team_sort_order">
<span<?php echo $management_team->sort_order->ViewAttributes() ?>>
<?php echo $management_team->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->status->Visible) { // status ?>
		<td<?php echo $management_team->status->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_status" class="management_team_status">
<span<?php echo $management_team->status->ViewAttributes() ?>>
<?php echo $management_team->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_linkedin->Visible) { // management_team_linkedin ?>
		<td<?php echo $management_team->management_team_linkedin->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_linkedin" class="management_team_management_team_linkedin">
<span<?php echo $management_team->management_team_linkedin->ViewAttributes() ?>>
<?php echo $management_team->management_team_linkedin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_facebook->Visible) { // management_team_facebook ?>
		<td<?php echo $management_team->management_team_facebook->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_facebook" class="management_team_management_team_facebook">
<span<?php echo $management_team->management_team_facebook->ViewAttributes() ?>>
<?php echo $management_team->management_team_facebook->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_twitter->Visible) { // management_team_twitter ?>
		<td<?php echo $management_team->management_team_twitter->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_twitter" class="management_team_management_team_twitter">
<span<?php echo $management_team->management_team_twitter->ViewAttributes() ?>>
<?php echo $management_team->management_team_twitter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_email->Visible) { // management_team_email ?>
		<td<?php echo $management_team->management_team_email->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_email" class="management_team_management_team_email">
<span<?php echo $management_team->management_team_email->ViewAttributes() ?>>
<?php echo $management_team->management_team_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($management_team->management_team_phone->Visible) { // management_team_phone ?>
		<td<?php echo $management_team->management_team_phone->CellAttributes() ?>>
<span id="el<?php echo $management_team_delete->RowCnt ?>_management_team_management_team_phone" class="management_team_management_team_phone">
<span<?php echo $management_team->management_team_phone->ViewAttributes() ?>>
<?php echo $management_team->management_team_phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$management_team_delete->Recordset->MoveNext();
}
$management_team_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $management_team_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fmanagement_teamdelete.Init();
</script>
<?php
$management_team_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$management_team_delete->Page_Terminate();
?>
