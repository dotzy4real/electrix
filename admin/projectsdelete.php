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

$projects_delete = NULL; // Initialize page object first

class cprojects_delete extends cprojects {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
			$this->Page_Terminate("projectslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in projects class, projectsinfo.php

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
				$sThisKey .= $row['project_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "projectslist.php", "", $this->TableVar, TRUE);
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
if (!isset($projects_delete)) $projects_delete = new cprojects_delete();

// Page init
$projects_delete->Page_Init();

// Page main
$projects_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fprojectsdelete = new ew_Form("fprojectsdelete", "delete");

// Form_CustomValidate event
fprojectsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectsdelete.ValidateRequired = true;
<?php } else { ?>
fprojectsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fprojectsdelete.Lists["x_project_category_id"] = {"LinkField":"x_project_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_project_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectsdelete.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fprojectsdelete.Lists["x_status"].Options = <?php echo json_encode($projects->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($projects_delete->Recordset = $projects_delete->LoadRecordset())
	$projects_deleteTotalRecs = $projects_delete->Recordset->RecordCount(); // Get record count
if ($projects_deleteTotalRecs <= 0) { // No record found, exit
	if ($projects_delete->Recordset)
		$projects_delete->Recordset->Close();
	$projects_delete->Page_Terminate("projectslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $projects_delete->ShowPageHeader(); ?>
<?php
$projects_delete->ShowMessage();
?>
<form name="fprojectsdelete" id="fprojectsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($projects_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $projects->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($projects->project_id->Visible) { // project_id ?>
		<th><span id="elh_projects_project_id" class="projects_project_id"><?php echo $projects->project_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_title->Visible) { // project_title ?>
		<th><span id="elh_projects_project_title" class="projects_project_title"><?php echo $projects->project_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_small_pic->Visible) { // project_small_pic ?>
		<th><span id="elh_projects_project_small_pic" class="projects_project_small_pic"><?php echo $projects->project_small_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_pic->Visible) { // project_pic ?>
		<th><span id="elh_projects_project_pic" class="projects_project_pic"><?php echo $projects->project_pic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_category_id->Visible) { // project_category_id ?>
		<th><span id="elh_projects_project_category_id" class="projects_project_category_id"><?php echo $projects->project_category_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_date->Visible) { // project_date ?>
		<th><span id="elh_projects_project_date" class="projects_project_date"><?php echo $projects->project_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_client->Visible) { // project_client ?>
		<th><span id="elh_projects_project_client" class="projects_project_client"><?php echo $projects->project_client->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->project_location->Visible) { // project_location ?>
		<th><span id="elh_projects_project_location" class="projects_project_location"><?php echo $projects->project_location->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->sort_order->Visible) { // sort_order ?>
		<th><span id="elh_projects_sort_order" class="projects_sort_order"><?php echo $projects->sort_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->status->Visible) { // status ?>
		<th><span id="elh_projects_status" class="projects_status"><?php echo $projects->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$projects_delete->RecCnt = 0;
$i = 0;
while (!$projects_delete->Recordset->EOF) {
	$projects_delete->RecCnt++;
	$projects_delete->RowCnt++;

	// Set row properties
	$projects->ResetAttrs();
	$projects->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$projects_delete->LoadRowValues($projects_delete->Recordset);

	// Render row
	$projects_delete->RenderRow();
?>
	<tr<?php echo $projects->RowAttributes() ?>>
<?php if ($projects->project_id->Visible) { // project_id ?>
		<td<?php echo $projects->project_id->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_id" class="projects_project_id">
<span<?php echo $projects->project_id->ViewAttributes() ?>>
<?php echo $projects->project_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_title->Visible) { // project_title ?>
		<td<?php echo $projects->project_title->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_title" class="projects_project_title">
<span<?php echo $projects->project_title->ViewAttributes() ?>>
<?php echo $projects->project_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_small_pic->Visible) { // project_small_pic ?>
		<td<?php echo $projects->project_small_pic->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_small_pic" class="projects_project_small_pic">
<span>
<?php echo ew_GetFileViewTag($projects->project_small_pic, $projects->project_small_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_pic->Visible) { // project_pic ?>
		<td<?php echo $projects->project_pic->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_pic" class="projects_project_pic">
<span>
<?php echo ew_GetFileViewTag($projects->project_pic, $projects->project_pic->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_category_id->Visible) { // project_category_id ?>
		<td<?php echo $projects->project_category_id->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_category_id" class="projects_project_category_id">
<span<?php echo $projects->project_category_id->ViewAttributes() ?>>
<?php echo $projects->project_category_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_date->Visible) { // project_date ?>
		<td<?php echo $projects->project_date->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_date" class="projects_project_date">
<span<?php echo $projects->project_date->ViewAttributes() ?>>
<?php echo $projects->project_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_client->Visible) { // project_client ?>
		<td<?php echo $projects->project_client->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_client" class="projects_project_client">
<span<?php echo $projects->project_client->ViewAttributes() ?>>
<?php echo $projects->project_client->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->project_location->Visible) { // project_location ?>
		<td<?php echo $projects->project_location->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_project_location" class="projects_project_location">
<span<?php echo $projects->project_location->ViewAttributes() ?>>
<?php echo $projects->project_location->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->sort_order->Visible) { // sort_order ?>
		<td<?php echo $projects->sort_order->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_sort_order" class="projects_sort_order">
<span<?php echo $projects->sort_order->ViewAttributes() ?>>
<?php echo $projects->sort_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->status->Visible) { // status ?>
		<td<?php echo $projects->status->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_status" class="projects_status">
<span<?php echo $projects->status->ViewAttributes() ?>>
<?php echo $projects->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$projects_delete->Recordset->MoveNext();
}
$projects_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $projects_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fprojectsdelete.Init();
</script>
<?php
$projects_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$projects_delete->Page_Terminate();
?>
