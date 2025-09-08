<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "armese_management_teaminfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$armese_management_team_delete = NULL; // Initialize page object first

class carmese_management_team_delete extends carmese_management_team {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'armese_management_team';

	// Page object name
	var $PageObjName = 'armese_management_team_delete';

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

		// Table object (armese_management_team)
		if (!isset($GLOBALS["armese_management_team"]) || get_class($GLOBALS["armese_management_team"]) == "carmese_management_team") {
			$GLOBALS["armese_management_team"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["armese_management_team"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'armese_management_team', TRUE);

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
		$this->armese_management_team_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $armese_management_team;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($armese_management_team);
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
			$this->Page_Terminate("armese_management_teamlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in armese_management_team class, armese_management_teaminfo.php

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
		$this->armese_management_team_id->setDbValue($rs->fields('armese_management_team_id'));
		$this->armese_management_team_pic->Upload->DbValue = $rs->fields('armese_management_team_pic');
		$this->armese_management_team_pic->CurrentValue = $this->armese_management_team_pic->Upload->DbValue;
		$this->armese_management_team_name->setDbValue($rs->fields('armese_management_team_name'));
		$this->armese_management_team_designation->setDbValue($rs->fields('armese_management_team_designation'));
		$this->armese_management_team_content->setDbValue($rs->fields('armese_management_team_content'));
		$this->sort_order->setDbValue($rs->fields('sort_order'));
		$this->status->setDbValue($rs->fields('status'));
		$this->armese_management_team_linkedin->setDbValue($rs->fields('armese_management_team_linkedin'));
		$this->armese_management_team_facebook->setDbValue($rs->fields('armese_management_team_facebook'));
		$this->armese_management_team_twitter->setDbValue($rs->fields('armese_management_team_twitter'));
		$this->armese_management_team_email->setDbValue($rs->fields('armese_management_team_email'));
		$this->armese_management_team_phone->setDbValue($rs->fields('armese_management_team_phone'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->armese_management_team_id->DbValue = $row['armese_management_team_id'];
		$this->armese_management_team_pic->Upload->DbValue = $row['armese_management_team_pic'];
		$this->armese_management_team_name->DbValue = $row['armese_management_team_name'];
		$this->armese_management_team_designation->DbValue = $row['armese_management_team_designation'];
		$this->armese_management_team_content->DbValue = $row['armese_management_team_content'];
		$this->sort_order->DbValue = $row['sort_order'];
		$this->status->DbValue = $row['status'];
		$this->armese_management_team_linkedin->DbValue = $row['armese_management_team_linkedin'];
		$this->armese_management_team_facebook->DbValue = $row['armese_management_team_facebook'];
		$this->armese_management_team_twitter->DbValue = $row['armese_management_team_twitter'];
		$this->armese_management_team_email->DbValue = $row['armese_management_team_email'];
		$this->armese_management_team_phone->DbValue = $row['armese_management_team_phone'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// armese_management_team_id
		// armese_management_team_pic
		// armese_management_team_name
		// armese_management_team_designation
		// armese_management_team_content
		// sort_order
		// status
		// armese_management_team_linkedin
		// armese_management_team_facebook
		// armese_management_team_twitter
		// armese_management_team_email
		// armese_management_team_phone

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// armese_management_team_id
		$this->armese_management_team_id->ViewValue = $this->armese_management_team_id->CurrentValue;
		$this->armese_management_team_id->ViewCustomAttributes = "";

		// armese_management_team_pic
		$this->armese_management_team_pic->UploadPath = '../src/assets/images/armese/team';
		if (!ew_Empty($this->armese_management_team_pic->Upload->DbValue)) {
			$this->armese_management_team_pic->ImageWidth = 105;
			$this->armese_management_team_pic->ImageHeight = 120;
			$this->armese_management_team_pic->ImageAlt = $this->armese_management_team_pic->FldAlt();
			$this->armese_management_team_pic->ViewValue = $this->armese_management_team_pic->Upload->DbValue;
		} else {
			$this->armese_management_team_pic->ViewValue = "";
		}
		$this->armese_management_team_pic->ViewCustomAttributes = "";

		// armese_management_team_name
		$this->armese_management_team_name->ViewValue = $this->armese_management_team_name->CurrentValue;
		$this->armese_management_team_name->ViewCustomAttributes = "";

		// armese_management_team_designation
		$this->armese_management_team_designation->ViewValue = $this->armese_management_team_designation->CurrentValue;
		$this->armese_management_team_designation->ViewCustomAttributes = "";

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

		// armese_management_team_linkedin
		$this->armese_management_team_linkedin->ViewValue = $this->armese_management_team_linkedin->CurrentValue;
		$this->armese_management_team_linkedin->ViewCustomAttributes = "";

		// armese_management_team_facebook
		$this->armese_management_team_facebook->ViewValue = $this->armese_management_team_facebook->CurrentValue;
		$this->armese_management_team_facebook->ViewCustomAttributes = "";

		// armese_management_team_twitter
		$this->armese_management_team_twitter->ViewValue = $this->armese_management_team_twitter->CurrentValue;
		$this->armese_management_team_twitter->ViewCustomAttributes = "";

		// armese_management_team_email
		$this->armese_management_team_email->ViewValue = $this->armese_management_team_email->CurrentValue;
		$this->armese_management_team_email->ViewCustomAttributes = "";

		// armese_management_team_phone
		$this->armese_management_team_phone->ViewValue = $this->armese_management_team_phone->CurrentValue;
		$this->armese_management_team_phone->ViewCustomAttributes = "";

			// armese_management_team_id
			$this->armese_management_team_id->LinkCustomAttributes = "";
			$this->armese_management_team_id->HrefValue = "";
			$this->armese_management_team_id->TooltipValue = "";

			// armese_management_team_pic
			$this->armese_management_team_pic->LinkCustomAttributes = "";
			$this->armese_management_team_pic->UploadPath = '../src/assets/images/armese/team';
			if (!ew_Empty($this->armese_management_team_pic->Upload->DbValue)) {
				$this->armese_management_team_pic->HrefValue = ew_GetFileUploadUrl($this->armese_management_team_pic, $this->armese_management_team_pic->Upload->DbValue); // Add prefix/suffix
				$this->armese_management_team_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->armese_management_team_pic->HrefValue = ew_ConvertFullUrl($this->armese_management_team_pic->HrefValue);
			} else {
				$this->armese_management_team_pic->HrefValue = "";
			}
			$this->armese_management_team_pic->HrefValue2 = $this->armese_management_team_pic->UploadPath . $this->armese_management_team_pic->Upload->DbValue;
			$this->armese_management_team_pic->TooltipValue = "";
			if ($this->armese_management_team_pic->UseColorbox) {
				$this->armese_management_team_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->armese_management_team_pic->LinkAttrs["data-rel"] = "armese_management_team_x_armese_management_team_pic";

				//$this->armese_management_team_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->armese_management_team_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->armese_management_team_pic->LinkAttrs["data-container"] = "body";

				$this->armese_management_team_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// armese_management_team_name
			$this->armese_management_team_name->LinkCustomAttributes = "";
			$this->armese_management_team_name->HrefValue = "";
			$this->armese_management_team_name->TooltipValue = "";

			// armese_management_team_designation
			$this->armese_management_team_designation->LinkCustomAttributes = "";
			$this->armese_management_team_designation->HrefValue = "";
			$this->armese_management_team_designation->TooltipValue = "";

			// sort_order
			$this->sort_order->LinkCustomAttributes = "";
			$this->sort_order->HrefValue = "";
			$this->sort_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// armese_management_team_linkedin
			$this->armese_management_team_linkedin->LinkCustomAttributes = "";
			$this->armese_management_team_linkedin->HrefValue = "";
			$this->armese_management_team_linkedin->TooltipValue = "";

			// armese_management_team_facebook
			$this->armese_management_team_facebook->LinkCustomAttributes = "";
			$this->armese_management_team_facebook->HrefValue = "";
			$this->armese_management_team_facebook->TooltipValue = "";

			// armese_management_team_twitter
			$this->armese_management_team_twitter->LinkCustomAttributes = "";
			$this->armese_management_team_twitter->HrefValue = "";
			$this->armese_management_team_twitter->TooltipValue = "";

			// armese_management_team_email
			$this->armese_management_team_email->LinkCustomAttributes = "";
			$this->armese_management_team_email->HrefValue = "";
			$this->armese_management_team_email->TooltipValue = "";

			// armese_management_team_phone
			$this->armese_management_team_phone->LinkCustomAttributes = "";
			$this->armese_management_team_phone->HrefValue = "";
			$this->armese_management_team_phone->TooltipValue = "";
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
				$sThisKey .= $row['armese_management_team_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "armese_management_teamlist.php", "", $this->TableVar, TRUE);
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
if (!isset($armese_management_team_delete)) $armese_management_team_delete = new carmese_management_team_delete();

// Page init
$armese_management_team_delete->Page_Init();

// Page main
$armese_management_team_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$armese_management_team_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = farmese_management_teamdelete = new ew_Form("farmese_management_teamdelete", "delete");

// Form_CustomValidate event
farmese_management_teamdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
farmese_management_teamdelete.ValidateRequired = true;
<?php } else { ?>
farmese_management_teamdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
farmese_management_teamdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farmese_management_teamdelete.Lists["x_status"].Options = <?php echo json_encode($armese_management_team->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($armese_management_team_delete->Recordset = $armese_management_team_delete->LoadRecordset())
	$armese_management_team_deleteTotalRecs = $armese_management_team_delete->Recordset->RecordCount(); // Get record count
if ($armese_management_team_deleteTotalRecs <= 0) { // No record found, exit
	if ($armese_management_team_delete->Recordset)
		$armese_management_team_delete->Recordset->Close();
	$armese_management_team_delete->Page_Terminate("armese_management_teamlist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $armese_management_team_delete->ShowPageHeader(); ?>
<?php
$armese_management_team_delete->ShowMessage();
?>
<form name="farmese_management_teamdelete" id="farmese_management_teamdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($armese_management_team_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $armese_management_team_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="armese_management_team">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($armese_management_team_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $armese_management_team->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($armese_management_team->armese_management_team_id->Visible) { // armese_management_team_id ?>
		<th><span id="elh_armese_management_team_armese_management_team_id" class="armese_management_team_armese_management_team_id"><?php echo $armese_management_team->armese_management_team_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_pic->Visible) { // armese_management_team_pic ?>
		<th><span id="elh_armese_management_team_armese_management_team_pic" class="armese_management_team_armese_management_team_pic"><?php echo $armese_management_team->armese_management_team_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_name->Visible) { // armese_management_team_name ?>
		<th><span id="elh_armese_management_team_armese_management_team_name" class="armese_management_team_armese_management_team_name"><?php echo $armese_management_team->armese_management_team_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_designation->Visible) { // armese_management_team_designation ?>
		<th><span id="elh_armese_management_team_armese_management_team_designation" class="armese_management_team_armese_management_team_designation"><?php echo $armese_management_team->armese_management_team_designation->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_armese_management_team_sort_order" class="armese_management_team_sort_order"><?php echo $armese_management_team->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->status->Visible) { // status ?>
		<th><span id="elh_armese_management_team_status" class="armese_management_team_status"><?php echo $armese_management_team->status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_linkedin->Visible) { // armese_management_team_linkedin ?>
		<th><span id="elh_armese_management_team_armese_management_team_linkedin" class="armese_management_team_armese_management_team_linkedin"><?php echo $armese_management_team->armese_management_team_linkedin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_facebook->Visible) { // armese_management_team_facebook ?>
		<th><span id="elh_armese_management_team_armese_management_team_facebook" class="armese_management_team_armese_management_team_facebook"><?php echo $armese_management_team->armese_management_team_facebook->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_twitter->Visible) { // armese_management_team_twitter ?>
		<th><span id="elh_armese_management_team_armese_management_team_twitter" class="armese_management_team_armese_management_team_twitter"><?php echo $armese_management_team->armese_management_team_twitter->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_email->Visible) { // armese_management_team_email ?>
		<th><span id="elh_armese_management_team_armese_management_team_email" class="armese_management_team_armese_management_team_email"><?php echo $armese_management_team->armese_management_team_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_phone->Visible) { // armese_management_team_phone ?>
		<th><span id="elh_armese_management_team_armese_management_team_phone" class="armese_management_team_armese_management_team_phone"><?php echo $armese_management_team->armese_management_team_phone->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$armese_management_team_delete->RecCnt = 0;
$i = 0;
while (!$armese_management_team_delete->Recordset->EOF) {
	$armese_management_team_delete->RecCnt++;
	$armese_management_team_delete->RowCnt++;

	// Set row properties
	$armese_management_team->ResetAttrs();
	$armese_management_team->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$armese_management_team_delete->LoadRowValues($armese_management_team_delete->Recordset);

	// Render row
	$armese_management_team_delete->RenderRow();
?>
	<tr<?php echo $armese_management_team->RowAttributes() ?>>
<?php if ($armese_management_team->armese_management_team_id->Visible) { // armese_management_team_id ?>
		<td<?php echo $armese_management_team->armese_management_team_id->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_id" class="armese_management_team_armese_management_team_id">
<span<?php echo $armese_management_team->armese_management_team_id->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_pic->Visible) { // armese_management_team_pic ?>
		<td<?php echo $armese_management_team->armese_management_team_pic->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_pic" class="armese_management_team_armese_management_team_pic">
<span>
<?php echo ew_GetFileViewTag($armese_management_team->armese_management_team_pic, $armese_management_team->armese_management_team_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_name->Visible) { // armese_management_team_name ?>
		<td<?php echo $armese_management_team->armese_management_team_name->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_name" class="armese_management_team_armese_management_team_name">
<span<?php echo $armese_management_team->armese_management_team_name->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_designation->Visible) { // armese_management_team_designation ?>
		<td<?php echo $armese_management_team->armese_management_team_designation->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_designation" class="armese_management_team_armese_management_team_designation">
<span<?php echo $armese_management_team->armese_management_team_designation->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_designation->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->sort_order->Visible) { // sort_order ?>
		<td<?php echo $armese_management_team->sort_order->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_sort_order" class="armese_management_team_sort_order">
<span<?php echo $armese_management_team->sort_order->ViewAttributes() ?>>
<?php echo $armese_management_team->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->status->Visible) { // status ?>
		<td<?php echo $armese_management_team->status->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_status" class="armese_management_team_status">
<span<?php echo $armese_management_team->status->ViewAttributes() ?>>
<?php echo $armese_management_team->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_linkedin->Visible) { // armese_management_team_linkedin ?>
		<td<?php echo $armese_management_team->armese_management_team_linkedin->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_linkedin" class="armese_management_team_armese_management_team_linkedin">
<span<?php echo $armese_management_team->armese_management_team_linkedin->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_linkedin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_facebook->Visible) { // armese_management_team_facebook ?>
		<td<?php echo $armese_management_team->armese_management_team_facebook->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_facebook" class="armese_management_team_armese_management_team_facebook">
<span<?php echo $armese_management_team->armese_management_team_facebook->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_facebook->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_twitter->Visible) { // armese_management_team_twitter ?>
		<td<?php echo $armese_management_team->armese_management_team_twitter->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_twitter" class="armese_management_team_armese_management_team_twitter">
<span<?php echo $armese_management_team->armese_management_team_twitter->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_twitter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_email->Visible) { // armese_management_team_email ?>
		<td<?php echo $armese_management_team->armese_management_team_email->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_email" class="armese_management_team_armese_management_team_email">
<span<?php echo $armese_management_team->armese_management_team_email->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($armese_management_team->armese_management_team_phone->Visible) { // armese_management_team_phone ?>
		<td<?php echo $armese_management_team->armese_management_team_phone->CellAttributes() ?>>
<span id="el<?php echo $armese_management_team_delete->RowCnt ?>_armese_management_team_armese_management_team_phone" class="armese_management_team_armese_management_team_phone">
<span<?php echo $armese_management_team->armese_management_team_phone->ViewAttributes() ?>>
<?php echo $armese_management_team->armese_management_team_phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$armese_management_team_delete->Recordset->MoveNext();
}
$armese_management_team_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $armese_management_team_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
farmese_management_teamdelete.Init();
</script>
<?php
$armese_management_team_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$armese_management_team_delete->Page_Terminate();
?>
