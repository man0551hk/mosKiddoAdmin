<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();
include_once 'helpers/session_helper.php';
include_once 'helpers/cookie_helper.php';
include_once 'helpers/encrypt_helper.php';
include_once 'helpers/url_helper.php';
include_once 'helpers/ui_helper.php';
include_once 'helpers/permission_helper.php';
include_once 'controllers/PageController.php';

$pageName = "index";
if (isset($_GET["pageName"])) {
	$pageName = $_GET["pageName"];
}
$page_controller = new PageController();
$page_controller->show($pageName . '.php');
ob_end_flush();
