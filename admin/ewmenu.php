<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_accomplishments", $Language->MenuPhrase("1", "MenuText"), "accomplishmentslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(2, "mi_armese_about", $Language->MenuPhrase("2", "MenuText"), "armese_aboutlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(3, "mi_armese_capabilities", $Language->MenuPhrase("3", "MenuText"), "armese_capabilitieslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(4, "mi_armese_client_partners", $Language->MenuPhrase("4", "MenuText"), "armese_client_partnerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(5, "mi_armese_contact_info", $Language->MenuPhrase("5", "MenuText"), "armese_contact_infolist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(6, "mi_armese_homebanners", $Language->MenuPhrase("6", "MenuText"), "armese_homebannerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(7, "mi_armese_management_team", $Language->MenuPhrase("7", "MenuText"), "armese_management_teamlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(8, "mi_armese_opening_hours", $Language->MenuPhrase("8", "MenuText"), "armese_opening_hourslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(9, "mi_armese_project_categories", $Language->MenuPhrase("9", "MenuText"), "armese_project_categorieslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(10, "mi_armese_projects", $Language->MenuPhrase("10", "MenuText"), "armese_projectslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(11, "mi_armese_services", $Language->MenuPhrase("11", "MenuText"), "armese_serviceslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(12, "mi_blog", $Language->MenuPhrase("12", "MenuText"), "bloglist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(13, "mi_blog_categories", $Language->MenuPhrase("13", "MenuText"), "blog_categorieslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(14, "mi_blog_tag_map", $Language->MenuPhrase("14", "MenuText"), "blog_tag_maplist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(15, "mi_blog_tags", $Language->MenuPhrase("15", "MenuText"), "blog_tagslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(16, "mi_board_directors", $Language->MenuPhrase("16", "MenuText"), "board_directorslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(17, "mi_contact_info", $Language->MenuPhrase("17", "MenuText"), "contact_infolist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(18, "mi_feature_lists", $Language->MenuPhrase("18", "MenuText"), "feature_listslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(19, "mi_features", $Language->MenuPhrase("19", "MenuText"), "featureslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(20, "mi_home_about", $Language->MenuPhrase("20", "MenuText"), "home_aboutlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(21, "mi_homebanners", $Language->MenuPhrase("21", "MenuText"), "homebannerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(22, "mi_job_submissions", $Language->MenuPhrase("22", "MenuText"), "job_submissionslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(23, "mi_job_vacancies", $Language->MenuPhrase("23", "MenuText"), "job_vacancieslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(24, "mi_job_vacancy_section", $Language->MenuPhrase("24", "MenuText"), "job_vacancy_sectionlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(25, "mi_kilowatt_about", $Language->MenuPhrase("25", "MenuText"), "kilowatt_aboutlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(26, "mi_kilowatt_benefits", $Language->MenuPhrase("26", "MenuText"), "kilowatt_benefitslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(27, "mi_kilowatt_contact_info", $Language->MenuPhrase("27", "MenuText"), "kilowatt_contact_infolist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(28, "mi_kilowatt_homebanners", $Language->MenuPhrase("28", "MenuText"), "kilowatt_homebannerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(29, "mi_kilowatt_management_team", $Language->MenuPhrase("29", "MenuText"), "kilowatt_management_teamlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(30, "mi_kilowatt_projects", $Language->MenuPhrase("30", "MenuText"), "kilowatt_projectslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(31, "mi_kilowatt_service_category", $Language->MenuPhrase("31", "MenuText"), "kilowatt_service_categorylist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(32, "mi_kilowatt_services", $Language->MenuPhrase("32", "MenuText"), "kilowatt_serviceslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(33, "mi_kilowatt_work_how", $Language->MenuPhrase("33", "MenuText"), "kilowatt_work_howlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(34, "mi_management_team", $Language->MenuPhrase("34", "MenuText"), "management_teamlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(35, "mi_mission_vision", $Language->MenuPhrase("35", "MenuText"), "mission_visionlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(36, "mi_msmsl_about", $Language->MenuPhrase("36", "MenuText"), "msmsl_aboutlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(37, "mi_msmsl_choose_us", $Language->MenuPhrase("37", "MenuText"), "msmsl_choose_uslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(38, "mi_msmsl_choose_us_items", $Language->MenuPhrase("38", "MenuText"), "msmsl_choose_us_itemslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(39, "mi_msmsl_client_partners", $Language->MenuPhrase("39", "MenuText"), "msmsl_client_partnerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(40, "mi_msmsl_contact_info", $Language->MenuPhrase("40", "MenuText"), "msmsl_contact_infolist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(41, "mi_msmsl_equipments", $Language->MenuPhrase("41", "MenuText"), "msmsl_equipmentslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(42, "mi_msmsl_homebanners", $Language->MenuPhrase("42", "MenuText"), "msmsl_homebannerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(43, "mi_msmsl_management_team", $Language->MenuPhrase("43", "MenuText"), "msmsl_management_teamlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(44, "mi_msmsl_mission_edge", $Language->MenuPhrase("44", "MenuText"), "msmsl_mission_edgelist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(45, "mi_msmsl_project_categories", $Language->MenuPhrase("45", "MenuText"), "msmsl_project_categorieslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(46, "mi_msmsl_projects", $Language->MenuPhrase("46", "MenuText"), "msmsl_projectslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(47, "mi_our_edge", $Language->MenuPhrase("47", "MenuText"), "our_edgelist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(48, "mi_our_values", $Language->MenuPhrase("48", "MenuText"), "our_valueslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(49, "mi_pages", $Language->MenuPhrase("49", "MenuText"), "pageslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(50, "mi_project_categories", $Language->MenuPhrase("50", "MenuText"), "project_categorieslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(51, "mi_project_section", $Language->MenuPhrase("51", "MenuText"), "project_sectionlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(52, "mi_projects", $Language->MenuPhrase("52", "MenuText"), "projectslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(53, "mi_request_quote", $Language->MenuPhrase("53", "MenuText"), "request_quotelist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(54, "mi_services", $Language->MenuPhrase("54", "MenuText"), "serviceslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(55, "mi_skyview_about", $Language->MenuPhrase("55", "MenuText"), "skyview_aboutlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(56, "mi_skyview_contact_info", $Language->MenuPhrase("56", "MenuText"), "skyview_contact_infolist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(57, "mi_skyview_homebanners", $Language->MenuPhrase("57", "MenuText"), "skyview_homebannerslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(58, "mi_skyview_services", $Language->MenuPhrase("58", "MenuText"), "skyview_serviceslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(59, "mi_what_we_offer", $Language->MenuPhrase("59", "MenuText"), "what_we_offerlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
