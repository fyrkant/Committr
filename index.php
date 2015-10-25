<?php

require_once("AppSettings.php");
require_once("vendor/autoload.php");

if (\AppSettings::DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

$db = new Committr\Model\DAL\MongoDAL();

$layout = new Committr\View\LayoutView();

$api = new \Committr\Model\DAL\GithubAPI("mw222rs");
$dataTest = $api->getPayload(true);

$repoList = new \Committr\Model\RepoList();
$loginView = new \Committr\View\LoginView();

$controller = new \Committr\Controller\MainController($repoList, $loginView);
$isLoggedIn = $controller->doControl();

$repoListView = new \Committr\View\RepoListView($repoList);

$layout->renderPage($isLoggedIn, $loginView, $repoListView);
//
//foreach (json_decode($dataTest, 1) as $repo) {
//    echo $repo['name'] . "<br />";
//    echo $repo['description'] . "<br /><br />";
//}
//
//
//var_dump($dataTest);
