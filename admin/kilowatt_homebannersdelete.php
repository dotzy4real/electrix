<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "kilowatt_homebannersinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$kilowatt_homebanners_delete = NULL; // Initialize page object first

class ckilowatt_homebanners_delete extends ckilowatt_homebanners {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'kilowatt_homebanners';

	// Page object name
	var $PageObjName = 'kilowatt_homebanners_delete';

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

		// Table object (kilowatt_homebanners)
		if (!isset($GLOBALS["kilowatt_homebanners"]) || get_class($GLOBALS["kilowatt_homebanners"]) == "ckilowatt_homebanners") {
			$GLOBALS["kilowatt_homebanners"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["kilowatt_homebanners"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'kilowatt_homebanners', TRUE);

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
		$this->kilowatt_homebanner_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $kilowatt_homebanners;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($kilowatt_homebanners);
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
			$this->Page_Terminate("kilowatt_homebannerslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in kilowatt_homebanners class, kilowatt_homebannersinfo.php

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
		$this->kilowatt_homebanner_id->setDbValue($rs->fields('kilowatt_homebanner_id'));
		$this->kilowatt_homebanner_icontitle->setDbValue($rs->fields('kilowatt_homebanner_icontitle'));
		$this->kilowatt_homebanner_maintitle->setDbValue($rs->fields('kilowatt_homebanner_maintitle'));
		$this->kilowatt_homebanner_subtitle->setDbValue($rs->fields('kilowatt_homebanner_subtitle'));
		$this->kilowatt_homebanner_pic->Upload->DbValue = $rs->fields('kilowatt_homebanner_pic');
		$this->kilowatt_homebanner_pic->CurrentValue = $this->kilowatt_homebanner_pic->Upload->DbValue;
		$this->kilowatt_homebanner_buttontext->setDbValue($rs->fields('kilowatt_homebanner_buttontext'));
		$this->kilowatt_homebanner_buttonlink->setDbValue($rs->fields('kilowatt_homebanner_buttonlink'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kilowatt_homebanner_id->DbValue = $row['kilowatt_homebanner_id'];
		$this->kilowatt_homebanner_icontitle->DbValue = $row['kilowatt_homebanner_icontitle'];
		$this->kilowatt_homebanner_maintitle->DbValue = $row['kilowatt_homebanner_maintitle'];
		$this->kilowatt_homebanner_subtitle->DbValue = $row['kilowatt_homebanner_subtitle'];
		$this->kilowatt_homebanner_pic->Upload->DbValue = $row['kilowatt_homebanner_pic'];
		$this->kilowatt_homebanner_buttontext->DbValue = $row['kilowatt_homebanner_buttontext'];
		$this->kilowatt_homebanner_buttonlink->DbValue = $row['kilowatt_homebanner_buttonlink'];
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
		// kilowatt_homebanner_id
		// kilowatt_homebanner_icontitle
		// kilowatt_homebanner_maintitle
		// kilowatt_homebanner_subtitle
		// kilowatt_homebanner_pic
		// kilowatt_homebanner_buttontext
		// kilowatt_homebanner_buttonlink
		// sort_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kilowatt_homebanner_id
		$this->kilowatt_homebanner_id->ViewValue = $this->kilowatt_homebanner_id->CurrentValue;
		$this->kilowatt_homebanner_id->ViewCustomAttributes = "";

		// kilowatt_homebanner_icontitle
		$this->kilowatt_homebanner_icontitle->ViewValue = $this->kilowatt_homebanner_icontitle->CurrentValue;
		$this->kilowatt_homebanner_icontitle->ViewCustomAttributes = "";

		// kilowatt_homebanner_maintitle
		$this->kilowatt_homebanner_maintitle->ViewValue = $this->kilowatt_homebanner_maintitle->CurrentValue;
		$this->kilowatt_homebanner_maintitle->ViewCustomAttributes = "";

		// kilowatt_homebanner_subtitle
		$this->kilowatt_homebanner_subtitle->ViewValue = $this->kilowatt_homebanner_subtitle->CurrentValue;
		$this->kilowatt_homebanner_subtitle->ViewCustomAttributes = "";

		// kilowatt_homebanner_pic
		$this->kilowatt_homebanner_pic->UploadPath = '../src/assets/images/kilowatt/homebanners';
		if (!ew_Empty($this->kilowatt_homebanner_pic->Upload->DbValue)) {
			$this->kilowatt_homebanner_pic->ImageWidth = 120;
			$this->kilowatt_homebanner_pic->ImageHeight = 110;
			$this->kilowatt_homebanner_pic->ImageAlt = $this->kilowatt_homebanner_pic->FldAlt();
			$this->kilowatt_homebanner_pic->ViewValue = $this->kilowatt_homebanner_pic->Upload->DbValue;
		} else {
			$this->kilowatt_homebanner_pic->ViewValue = "";
		}
		$this->kilowatt_homebanner_pic->ViewCustomAttributes = "";

		// kilowatt_homebanner_buttontext
		$this->kilowatt_homebanner_buttontext->ViewValue = $this->kilowatt_homebanner_buttontext->CurrentValue;
		$this->kilowatt_homebanner_buttontext->ViewCustomAttributes = "";

		// kilowatt_homebanner_buttonlink
		$this->kilowatt_homebanner_buttonlink->ViewValue = $this->kilowatt_homebanner_buttonlink->CurrentValue;
		$this->kilowatt_homebanner_buttonlink->ViewCustomAttributes = "";

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

			// kilowatt_homebanner_id
			$this->kilowatt_homebanner_id->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_id->HrefValue = "";
			$this->kilowatt_homebanner_id->TooltipValue = "";

			// kilowatt_homebanner_icontitle
			$this->kilowatt_homebanner_icontitle->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_icontitle->HrefValue = "";
			$this->kilowatt_homebanner_icontitle->TooltipValue = "";

			// kilowatt_homebanner_maintitle
			$this->kilowatt_homebanner_maintitle->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_maintitle->HrefValue = "";
			$this->kilowatt_homebanner_maintitle->TooltipValue = "";

			// kilowatt_homebanner_subtitle
			$this->kilowatt_homebanner_subtitle->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_subtitle->HrefValue = "";
			$this->kilowatt_homebanner_subtitle->TooltipValue = "";

			// kilowatt_homebanner_pic
			$this->kilowatt_homebanner_pic->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_pic->UploadPath = '../src/assets/images/kilowatt/homebanners';
			if (!ew_Empty($this->kilowatt_homebanner_pic->Upload->DbValue)) {
				$this->kilowatt_homebanner_pic->HrefValue = ew_GetFileUploadUrl($this->kilowatt_homebanner_pic, $this->kilowatt_homebanner_pic->Upload->DbValue); // Add prefix/suffix
				$this->kilowatt_homebanner_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->kilowatt_homebanner_pic->HrefValue = ew_ConvertFullUrl($this->kilowatt_homebanner_pic->HrefValue);
			} else {
				$this->kilowatt_homebanner_pic->HrefValue = "";
			}
			$this->kilowatt_homebanner_pic->HrefValue2 = $this->kilowatt_homebanner_pic->UploadPath . $this->kilowatt_homebanner_pic->Upload->DbValue;
			$this->kilowatt_homebanner_pic->TooltipValue = "";
			if ($this->kilowatt_homebanner_pic->UseColorbox) {
				$this->kilowatt_homebanner_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->kilowatt_homebanner_pic->LinkAttrs["data-rel"] = "kilowatt_homebanners_x_kilowatt_homebanner_pic";

				//$this->kilowatt_homebanner_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->kilowatt_homebanner_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->kilowatt_homebanner_pic->LinkAttrs["data-container"] = "body";

				$this->kilowatt_homebanner_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// kilowatt_homebanner_buttontext
			$this->kilowatt_homebanner_buttontext->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_buttontext->HrefValue = "";
			$this->kilowatt_homebanner_buttontext->TooltipValue = "";

			// kilowatt_homebanner_buttonlink
			$this->kilowatt_homebanner_buttonlink->LinkCustomAttributes = "";
			$this->kilowatt_homebanner_buttonlink->HrefValue = "";
			$this->kilowatt_homebanner_buttonlink->TooltipValue = "";

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
				$sThisKey .= $row['kilowatt_homebanner_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "kilowatt_homebannerslist.php", "", $this->TableVar, TRUE);
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
if (!isset($kilowatt_homebanners_delete)) $kilowatt_homebanners_delete = new ckilowatt_homebanners_delete();

// Page init
$kilowatt_homebanners_delete->Page_Init();

// Page main
$kilowatt_homebanners_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$kilowatt_homebanners_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fkilowatt_homebannersdelete = new ew_Form("fkilowatt_homebannersdelete", "delete");

// Form_CustomValidate event
fkilowatt_homebannersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkilowatt_homebannersdelete.ValidateRequired = true;
<?php } else { ?>
fkilowatt_homebannersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fkilowatt_homebannersdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fkilowatt_homebannersdelete.Lists["x_status"].Options = <?php echo json_encode($kilowatt_homebanners->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($kilowatt_homebanners_delete->Recordset = $kilowatt_homebanners_delete->LoadRecordset())
	$kilowatt_homebanners_deleteTotalRecs = $kilowatt_homebanners_delete->Recordset->RecordCount(); // Get record count
if ($kilowatt_homebanners_deleteTotalRecs <= 0) { // No record found, exit
	if ($kilowatt_homebanners_delete->Recordset)
		$kilowatt_homebanners_delete->Recordset->Close();
	$kilowatt_homebanners_delete->Page_Terminate("kilowatt_homebannerslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $kilowatt_homebanners_delete->ShowPageHeader(); ?>
<?php
$kilowatt_homebanners_delete->ShowMessage();
?>
<form name="fkilowatt_homebannersdelete" id="fkilowatt_homebannersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($kilowatt_homebanners_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $kilowatt_homebanners_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="kilowatt_homebanners">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($kilowatt_homebanners_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $kilowatt_homebanners->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($kilowatt_homebanners->kilowatt_homebanner_id->Visible) { // kilowatt_homebanner_id ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_id" class="kilowatt_homebanners_kilowatt_homebanner_id"><?php echo $kilowatt_homebanners->kilowatt_homebanner_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_icontitle->Visible) { // kilowatt_homebanner_icontitle ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_icontitle" class="kilowatt_homebanners_kilowatt_homebanner_icontitle"><?php echo $kilowatt_homebanners->kilowatt_homebanner_icontitle->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_maintitle->Visible) { // kilowatt_homebanner_maintitle ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_maintitle" class="kilowatt_homebanners_kilowatt_homebanner_maintitle"><?php echo $kilowatt_homebanners->kilowatt_homebanner_maintitle->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_subtitle->Visible) { // kilowatt_homebanner_subtitle ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_subtitle" class="kilowatt_homebanners_kilowatt_homebanner_subtitle"><?php echo $kilowatt_homebanners->kilowatt_homebanner_subtitle->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_pic->Visible) { // kilowatt_homebanner_pic ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_pic" class="kilowatt_homebanners_kilowatt_homebanner_pic"><?php echo $kilowatt_homebanners->kilowatt_homebanner_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_buttontext->Visible) { // kilowatt_homebanner_buttontext ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_buttontext" class="kilowatt_homebanners_kilowatt_homebanner_buttontext"><?php echo $kilowatt_homebanners->kilowatt_homebanner_buttontext->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_buttonlink->Visible) { // kilowatt_homebanner_buttonlink ?>
		<th><span id="elh_kilowatt_homebanners_kilowatt_homebanner_buttonlink" class="kilowatt_homebanners_kilowatt_homebanner_buttonlink"><?php echo $kilowatt_homebanners->kilowatt_homebanner_buttonlink->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_kilowatt_homebanners_sort_order" class="kilowatt_homebanners_sort_order"><?php echo $kilowatt_homebanners->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($kilowatt_homebanners->status->Visible) { // status ?>
		<th><span id="elh_kilowatt_homebanners_status" class="kilowatt_homebanners_status"><?php echo $kilowatt_homebanners->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$kilowatt_homebanners_delete->RecCnt = 0;
$i = 0;
while (!$kilowatt_homebanners_delete->Recordset->EOF) {
	$kilowatt_homebanners_delete->RecCnt++;
	$kilowatt_homebanners_delete->RowCnt++;

	// Set row properties
	$kilowatt_homebanners->ResetAttrs();
	$kilowatt_homebanners->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$kilowatt_homebanners_delete->LoadRowValues($kilowatt_homebanners_delete->Recordset);

	// Render row
	$kilowatt_homebanners_delete->RenderRow();
?>
	<tr<?php echo $kilowatt_homebanners->RowAttributes() ?>>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_id->Visible) { // kilowatt_homebanner_id ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_id->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_id" class="kilowatt_homebanners_kilowatt_homebanner_id">
<span<?php echo $kilowatt_homebanners->kilowatt_homebanner_id->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->kilowatt_homebanner_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_icontitle->Visible) { // kilowatt_homebanner_icontitle ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_icontitle->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_icontitle" class="kilowatt_homebanners_kilowatt_homebanner_icontitle">
<span<?php echo $kilowatt_homebanners->kilowatt_homebanner_icontitle->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->kilowatt_homebanner_icontitle->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_maintitle->Visible) { // kilowatt_homebanner_maintitle ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_maintitle->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_maintitle" class="kilowatt_homebanners_kilowatt_homebanner_maintitle">
<span<?php echo $kilowatt_homebanners->kilowatt_homebanner_maintitle->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->kilowatt_homebanner_maintitle->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_subtitle->Visible) { // kilowatt_homebanner_subtitle ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_subtitle->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_subtitle" class="kilowatt_homebanners_kilowatt_homebanner_subtitle">
<span<?php echo $kilowatt_homebanners->kilowatt_homebanner_subtitle->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->kilowatt_homebanner_subtitle->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_pic->Visible) { // kilowatt_homebanner_pic ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_pic->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_pic" class="kilowatt_homebanners_kilowatt_homebanner_pic">
<span>
<?php echo ew_GetFileViewTag($kilowatt_homebanners->kilowatt_homebanner_pic, $kilowatt_homebanners->kilowatt_homebanner_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_buttontext->Visible) { // kilowatt_homebanner_buttontext ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_buttontext->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_buttontext" class="kilowatt_homebanners_kilowatt_homebanner_buttontext">
<span<?php echo $kilowatt_homebanners->kilowatt_homebanner_buttontext->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->kilowatt_homebanner_buttontext->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->kilowatt_homebanner_buttonlink->Visible) { // kilowatt_homebanner_buttonlink ?>
		<td<?php echo $kilowatt_homebanners->kilowatt_homebanner_buttonlink->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_kilowatt_homebanner_buttonlink" class="kilowatt_homebanners_kilowatt_homebanner_buttonlink">
<span<?php echo $kilowatt_homebanners->kilowatt_homebanner_buttonlink->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->kilowatt_homebanner_buttonlink->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->sort_order->Visible) { // sort_order ?>
		<td<?php echo $kilowatt_homebanners->sort_order->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_sort_order" class="kilowatt_homebanners_sort_order">
<span<?php echo $kilowatt_homebanners->sort_order->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($kilowatt_homebanners->status->Visible) { // status ?>
		<td<?php echo $kilowatt_homebanners->status->CellAttributes() ?>>
<span id="el<?php echo $kilowatt_homebanners_delete->RowCnt ?>_kilowatt_homebanners_status" class="kilowatt_homebanners_status">
<span<?php echo $kilowatt_homebanners->status->ViewAttributes() ?>>
<?php echo $kilowatt_homebanners->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$kilowatt_homebanners_delete->Recordset->MoveNext();
}
$kilowatt_homebanners_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $kilowatt_homebanners_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fkilowatt_homebannersdelete.Init();
</script>
<?php
$kilowatt_homebanners_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$kilowatt_homebanners_delete->Page_Terminate();
?>
