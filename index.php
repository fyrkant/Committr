<?php

require_once("AppSettings.php");
require_once("vendor/autoload.php");

$db = new Committr\Model\DAL\MongoDAL();

$layout = new Committr\View\LayoutView();
$layout->renderPage();


