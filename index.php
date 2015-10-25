<?php

require_once("AppSettings.php");
require_once("vendor/autoload.php");

if (\AppSettings::DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

$db = new Committr\Model\DAL\MongoDAL();

$layout = new Committr\View\LayoutView();
$layout->renderPage();


