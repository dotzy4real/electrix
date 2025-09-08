<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "bloginfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$blog_add = NULL; // Initialize page object first

class cblog_add extends cblog {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C922A933-D668-4910-9FB5-9885A2020F86}";

	// Table name
	var $TableName = 'blog';

	// Page object name
	var $PageObjName = 'blog_add';

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

		// Table object (blog)
		if (!isset($GLOBALS["blog"]) || get_class($GLOBALS["blog"]) == "cblog") {
			$GLOBALS["blog"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["blog"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'blog', TRUE);

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
		global $EW_EXPORT, $blog;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($blog);
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
			if (@$_GET["blog_id"] != "") {
				$this->blog_id->setQueryStringValue($_GET["blog_id"]);
				$this->setKey("blog_id", $this->blog_id->CurrentValue); // Set up key
			} else {
				$this->setKey("blog_id", ""); // Clear key
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
					$this->Page_Terminate("bloglist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "blogview.php")
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
		$this->blog_pic->Upload->Index = $objForm->Index;
		$this->blog_pic->Upload->UploadFile();
		$this->blog_pic->CurrentValue = $this->blog_pic->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->blog_title->CurrentValue = NULL;
		$this->blog_title->OldValue = $this->blog_title->CurrentValue;
		$this->blog_content->CurrentValue = NULL;
		$this->blog_content->OldValue = $this->blog_content->CurrentValue;
		$this->blog_pic->Upload->DbValue = NULL;
		$this->blog_pic->OldValue = $this->blog_pic->Upload->DbValue;
		$this->blog_pic->CurrentValue = NULL; // Clear file related field
		$this->blog_category_id->CurrentValue = NULL;
		$this->blog_category_id->OldValue = $this->blog_category_id->CurrentValue;
		$this->status->CurrentValue = "active";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->blog_title->FldIsDetailKey) {
			$this->blog_title->setFormValue($objForm->GetValue("x_blog_title"));
		}
		if (!$this->blog_content->FldIsDetailKey) {
			$this->blog_content->setFormValue($objForm->GetValue("x_blog_content"));
		}
		if (!$this->blog_category_id->FldIsDetailKey) {
			$this->blog_category_id->setFormValue($objForm->GetValue("x_blog_category_id"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->blog_title->CurrentValue = $this->blog_title->FormValue;
		$this->blog_content->CurrentValue = $this->blog_content->FormValue;
		$this->blog_category_id->CurrentValue = $this->blog_category_id->FormValue;
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
		$this->blog_id->setDbValue($rs->fields('blog_id'));
		$this->blog_title->setDbValue($rs->fields('blog_title'));
		$this->blog_content->setDbValue($rs->fields('blog_content'));
		$this->blog_pic->Upload->DbValue = $rs->fields('blog_pic');
		$this->blog_pic->CurrentValue = $this->blog_pic->Upload->DbValue;
		$this->blog_category_id->setDbValue($rs->fields('blog_category_id'));
		$this->status->setDbValue($rs->fields('status'));
		$this->added_time->setDbValue($rs->fields('added_time'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->blog_id->DbValue = $row['blog_id'];
		$this->blog_title->DbValue = $row['blog_title'];
		$this->blog_content->DbValue = $row['blog_content'];
		$this->blog_pic->Upload->DbValue = $row['blog_pic'];
		$this->blog_category_id->DbValue = $row['blog_category_id'];
		$this->status->DbValue = $row['status'];
		$this->added_time->DbValue = $row['added_time'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("blog_id")) <> "")
			$this->blog_id->CurrentValue = $this->getKey("blog_id"); // blog_id
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
		// blog_id
		// blog_title
		// blog_content
		// blog_pic
		// blog_category_id
		// status
		// added_time

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// blog_id
		$this->blog_id->ViewValue = $this->blog_id->CurrentValue;
		$this->blog_id->ViewCustomAttributes = "";

		// blog_title
		$this->blog_title->ViewValue = $this->blog_title->CurrentValue;
		$this->blog_title->ViewCustomAttributes = "";

		// blog_content
		$this->blog_content->ViewValue = $this->blog_content->CurrentValue;
		$this->blog_content->ViewCustomAttributes = "";

		// blog_pic
		$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
		if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
			$this->blog_pic->ImageWidth = 120;
			$this->blog_pic->ImageHeight = 55;
			$this->blog_pic->ImageAlt = $this->blog_pic->FldAlt();
			$this->blog_pic->ViewValue = $this->blog_pic->Upload->DbValue;
		} else {
			$this->blog_pic->ViewValue = "";
		}
		$this->blog_pic->ViewCustomAttributes = "";

		// blog_category_id
		if (strval($this->blog_category_id->CurrentValue) <> "") {
			$sFilterWrk = "`blog_category_id`" . ew_SearchString("=", $this->blog_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `blog_category_id`, `blog_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `blog_categories`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->blog_category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->blog_category_id->ViewValue = $this->blog_category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->blog_category_id->ViewValue = $this->blog_category_id->CurrentValue;
			}
		} else {
			$this->blog_category_id->ViewValue = NULL;
		}
		$this->blog_category_id->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// added_time
		$this->added_time->ViewValue = $this->added_time->CurrentValue;
		$this->added_time->ViewValue = ew_FormatDateTime($this->added_time->ViewValue, 5);
		$this->added_time->ViewCustomAttributes = "";

			// blog_title
			$this->blog_title->LinkCustomAttributes = "";
			$this->blog_title->HrefValue = "";
			$this->blog_title->TooltipValue = "";

			// blog_content
			$this->blog_content->LinkCustomAttributes = "";
			$this->blog_content->HrefValue = "";
			$this->blog_content->TooltipValue = "";

			// blog_pic
			$this->blog_pic->LinkCustomAttributes = "";
			$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
			if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
				$this->blog_pic->HrefValue = ew_GetFileUploadUrl($this->blog_pic, $this->blog_pic->Upload->DbValue); // Add prefix/suffix
				$this->blog_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->blog_pic->HrefValue = ew_ConvertFullUrl($this->blog_pic->HrefValue);
			} else {
				$this->blog_pic->HrefValue = "";
			}
			$this->blog_pic->HrefValue2 = $this->blog_pic->UploadPath . $this->blog_pic->Upload->DbValue;
			$this->blog_pic->TooltipValue = "";
			if ($this->blog_pic->UseColorbox) {
				$this->blog_pic->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->blog_pic->LinkAttrs["data-rel"] = "blog_x_blog_pic";

				//$this->blog_pic->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->blog_pic->LinkAttrs["data-placement"] = "bottom";
				//$this->blog_pic->LinkAttrs["data-container"] = "body";

				$this->blog_pic->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// blog_category_id
			$this->blog_category_id->LinkCustomAttributes = "";
			$this->blog_category_id->HrefValue = "";
			$this->blog_category_id->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// blog_title
			$this->blog_title->EditAttrs["class"] = "form-control";
			$this->blog_title->EditCustomAttributes = "";
			$this->blog_title->EditValue = ew_HtmlEncode($this->blog_title->CurrentValue);
			$this->blog_title->PlaceHolder = ew_RemoveHtml($this->blog_title->FldCaption());

			// blog_content
			$this->blog_content->EditAttrs["class"] = "form-control";
			$this->blog_content->EditCustomAttributes = "";
			$this->blog_content->EditValue = ew_HtmlEncode($this->blog_content->CurrentValue);
			$this->blog_content->PlaceHolder = ew_RemoveHtml($this->blog_content->FldCaption());

			// blog_pic
			$this->blog_pic->EditAttrs["class"] = "form-control";
			$this->blog_pic->EditCustomAttributes = "";
			$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
			if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
				$this->blog_pic->ImageWidth = 120;
				$this->blog_pic->ImageHeight = 55;
				$this->blog_pic->ImageAlt = $this->blog_pic->FldAlt();
				$this->blog_pic->EditValue = $this->blog_pic->Upload->DbValue;
			} else {
				$this->blog_pic->EditValue = "";
			}
			if (!ew_Empty($this->blog_pic->CurrentValue))
				$this->blog_pic->Upload->FileName = $this->blog_pic->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->blog_pic);

			// blog_category_id
			$this->blog_category_id->EditAttrs["class"] = "form-control";
			$this->blog_category_id->EditCustomAttributes = "";
			if (trim(strval($this->blog_category_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`blog_category_id`" . ew_SearchString("=", $this->blog_category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `blog_category_id`, `blog_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `blog_categories`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->blog_category_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->blog_category_id->EditValue = $arwrk;

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Edit refer script
			// blog_title

			$this->blog_title->HrefValue = "";

			// blog_content
			$this->blog_content->HrefValue = "";

			// blog_pic
			$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
			if (!ew_Empty($this->blog_pic->Upload->DbValue)) {
				$this->blog_pic->HrefValue = ew_GetFileUploadUrl($this->blog_pic, $this->blog_pic->Upload->DbValue); // Add prefix/suffix
				$this->blog_pic->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->blog_pic->HrefValue = ew_ConvertFullUrl($this->blog_pic->HrefValue);
			} else {
				$this->blog_pic->HrefValue = "";
			}
			$this->blog_pic->HrefValue2 = $this->blog_pic->UploadPath . $this->blog_pic->Upload->DbValue;

			// blog_category_id
			$this->blog_category_id->HrefValue = "";

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
		if (!$this->blog_title->FldIsDetailKey && !is_null($this->blog_title->FormValue) && $this->blog_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blog_title->FldCaption(), $this->blog_title->ReqErrMsg));
		}
		if (!$this->blog_content->FldIsDetailKey && !is_null($this->blog_content->FormValue) && $this->blog_content->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blog_content->FldCaption(), $this->blog_content->ReqErrMsg));
		}
		if ($this->blog_pic->Upload->FileName == "" && !$this->blog_pic->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blog_pic->FldCaption(), $this->blog_pic->ReqErrMsg));
		}
		if (!$this->blog_category_id->FldIsDetailKey && !is_null($this->blog_category_id->FormValue) && $this->blog_category_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blog_category_id->FldCaption(), $this->blog_category_id->ReqErrMsg));
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
			$this->blog_pic->OldUploadPath = '../src/assets/images/resource/blog';
			$this->blog_pic->UploadPath = $this->blog_pic->OldUploadPath;
		}
		$rsnew = array();

		// blog_title
		$this->blog_title->SetDbValueDef($rsnew, $this->blog_title->CurrentValue, "", FALSE);

		// blog_content
		$this->blog_content->SetDbValueDef($rsnew, $this->blog_content->CurrentValue, "", FALSE);

		// blog_pic
		if (!$this->blog_pic->Upload->KeepFile) {
			$this->blog_pic->Upload->DbValue = ""; // No need to delete old file
			if ($this->blog_pic->Upload->FileName == "") {
				$rsnew['blog_pic'] = NULL;
			} else {
				$rsnew['blog_pic'] = $this->blog_pic->Upload->FileName;
			}
		}

		// blog_category_id
		$this->blog_category_id->SetDbValueDef($rsnew, $this->blog_category_id->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");
		if (!$this->blog_pic->Upload->KeepFile) {
			$this->blog_pic->UploadPath = '../src/assets/images/resource/blog';
			if (!ew_Empty($this->blog_pic->Upload->Value)) {
				$rsnew['blog_pic'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->blog_pic->UploadPath), $rsnew['blog_pic']); // Get new file name
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
				$this->blog_id->setDbValue($conn->Insert_ID());
				$rsnew['blog_id'] = $this->blog_id->DbValue;
				if (!$this->blog_pic->Upload->KeepFile) {
					if (!ew_Empty($this->blog_pic->Upload->Value)) {
						$this->blog_pic->Upload->SaveToFile($this->blog_pic->UploadPath, $rsnew['blog_pic'], TRUE);
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

		// blog_pic
		ew_CleanUploadTempPath($this->blog_pic, $this->blog_pic->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "bloglist.php", "", $this->TableVar, TRUE);
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
if (!isset($blog_add)) $blog_add = new cblog_add();

// Page init
$blog_add->Page_Init();

// Page main
$blog_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$blog_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fblogadd = new ew_Form("fblogadd", "add");

// Validate form
fblogadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_blog_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $blog->blog_title->FldCaption(), $blog->blog_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_blog_content");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $blog->blog_content->FldCaption(), $blog->blog_content->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_blog_pic");
			elm = this.GetElements("fn_x" + infix + "_blog_pic");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $blog->blog_pic->FldCaption(), $blog->blog_pic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_blog_category_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $blog->blog_category_id->FldCaption(), $blog->blog_category_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $blog->status->FldCaption(), $blog->status->ReqErrMsg)) ?>");

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
fblogadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fblogadd.ValidateRequired = true;
<?php } else { ?>
fblogadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fblogadd.Lists["x_blog_category_id"] = {"LinkField":"x_blog_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blog_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fblogadd.Lists["x_status"] = {"LinkField":"","Ajax":false,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fblogadd.Lists["x_status"].Options = <?php echo json_encode($blog->status->Options()) ?>;

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
<?php $blog_add->ShowPageHeader(); ?>
<?php
$blog_add->ShowMessage();
?>
<form name="fblogadd" id="fblogadd" class="<?php echo $blog_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($blog_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $blog_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="blog">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($blog->blog_title->Visible) { // blog_title ?>
	<div id="r_blog_title" class="form-group">
		<label id="elh_blog_blog_title" for="x_blog_title" class="col-sm-2 control-label ewLabel"><?php echo $blog->blog_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $blog->blog_title->CellAttributes() ?>>
<span id="el_blog_blog_title">
<input type="text" data-table="blog" data-field="x_blog_title" name="x_blog_title" id="x_blog_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($blog->blog_title->getPlaceHolder()) ?>" value="<?php echo $blog->blog_title->EditValue ?>"<?php echo $blog->blog_title->EditAttributes() ?>>
</span>
<?php echo $blog->blog_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($blog->blog_content->Visible) { // blog_content ?>
	<div id="r_blog_content" class="form-group">
		<label id="elh_blog_blog_content" class="col-sm-2 control-label ewLabel"><?php echo $blog->blog_content->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $blog->blog_content->CellAttributes() ?>>
<span id="el_blog_blog_content">
<?php ew_AppendClass($blog->blog_content->EditAttrs["class"], "editor"); ?>
<textarea data-table="blog" data-field="x_blog_content" name="x_blog_content" id="x_blog_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($blog->blog_content->getPlaceHolder()) ?>"<?php echo $blog->blog_content->EditAttributes() ?>><?php echo $blog->blog_content->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fblogadd", "x_blog_content", 35, 4, <?php echo ($blog->blog_content->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $blog->blog_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($blog->blog_pic->Visible) { // blog_pic ?>
	<div id="r_blog_pic" class="form-group">
		<label id="elh_blog_blog_pic" class="col-sm-2 control-label ewLabel"><?php echo $blog->blog_pic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $blog->blog_pic->CellAttributes() ?>>
<span id="el_blog_blog_pic">
<div id="fd_x_blog_pic">
<span title="<?php echo $blog->blog_pic->FldTitle() ? $blog->blog_pic->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($blog->blog_pic->ReadOnly || $blog->blog_pic->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="blog" data-field="x_blog_pic" name="x_blog_pic" id="x_blog_pic"<?php echo $blog->blog_pic->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_blog_pic" id= "fn_x_blog_pic" value="<?php echo $blog->blog_pic->Upload->FileName ?>">
<input type="hidden" name="fa_x_blog_pic" id= "fa_x_blog_pic" value="0">
<input type="hidden" name="fs_x_blog_pic" id= "fs_x_blog_pic" value="255">
<input type="hidden" name="fx_x_blog_pic" id= "fx_x_blog_pic" value="<?php echo $blog->blog_pic->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_blog_pic" id= "fm_x_blog_pic" value="<?php echo $blog->blog_pic->UploadMaxFileSize ?>">
</div>
<table id="ft_x_blog_pic" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $blog->blog_pic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($blog->blog_category_id->Visible) { // blog_category_id ?>
	<div id="r_blog_category_id" class="form-group">
		<label id="elh_blog_blog_category_id" for="x_blog_category_id" class="col-sm-2 control-label ewLabel"><?php echo $blog->blog_category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $blog->blog_category_id->CellAttributes() ?>>
<span id="el_blog_blog_category_id">
<select data-table="blog" data-field="x_blog_category_id" data-value-separator="<?php echo ew_HtmlEncode(is_array($blog->blog_category_id->DisplayValueSeparator) ? json_encode($blog->blog_category_id->DisplayValueSeparator) : $blog->blog_category_id->DisplayValueSeparator) ?>" id="x_blog_category_id" name="x_blog_category_id"<?php echo $blog->blog_category_id->EditAttributes() ?>>
<?php
if (is_array($blog->blog_category_id->EditValue)) {
	$arwrk = $blog->blog_category_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($blog->blog_category_id->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $blog->blog_category_id->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($blog->blog_category_id->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($blog->blog_category_id->CurrentValue) ?>" selected><?php echo $blog->blog_category_id->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `blog_category_id`, `blog_category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `blog_categories`";
$sWhereWrk = "";
$blog->blog_category_id->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$blog->blog_category_id->LookupFilters += array("f0" => "`blog_category_id` = {filter_value}", "t0" => "19", "fn0" => "");
$sSqlWrk = "";
$blog->Lookup_Selecting($blog->blog_category_id, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $blog->blog_category_id->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_blog_category_id" id="s_x_blog_category_id" value="<?php echo $blog->blog_category_id->LookupFilterQuery() ?>">
</span>
<?php echo $blog->blog_category_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($blog->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_blog_status" class="col-sm-2 control-label ewLabel"><?php echo $blog->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $blog->status->CellAttributes() ?>>
<span id="el_blog_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="blog" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($blog->status->DisplayValueSeparator) ? json_encode($blog->status->DisplayValueSeparator) : $blog->status->DisplayValueSeparator) ?>" name="x_status" id="x_status" value="{value}"<?php echo $blog->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList"><div>
<?php
$arwrk = $blog->status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($blog->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-table="blog" data-field="x_status" name="x_status" id="x_status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $blog->status->EditAttributes() ?>><?php echo $blog->status->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
	if ($emptywrk && strval($blog->status->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="blog" data-field="x_status" name="x_status" id="x_status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($blog->status->CurrentValue) ?>" checked<?php echo $blog->status->EditAttributes() ?>><?php echo $blog->status->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $blog->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $blog_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fblogadd.Init();
</script>
<?php
$blog_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$blog_add->Page_Terminate();
?>
