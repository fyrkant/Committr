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

$data = new \Committr\Model\DAL\GetGithubData();
$dataTest = $data->getContentFromGithub('https://api.github.com/users/mw222rs/repos');

foreach (json_decode($dataTest, 1) as $repo) {
    echo $repo['name'] . "<br />";
    echo $repo['description'] . "<br /><br />";
}


var_dump($dataTest);
