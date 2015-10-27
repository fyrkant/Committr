<?php

session_start();

require_once("AppSettings.php");
require_once("vendor/autoload.php");

if (\AppSettings::DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

$db = new Committr\Model\DAL\MongoDAL();

$layout = new Committr\View\LayoutView();

$loginModel = new \Committr\Model\LoginModel();

$commitList = new \Committr\Model\CommitList();
$repoList = new \Committr\Model\RepoList($commitList);

$messenger = new \Committr\View\Messenger();
$loginView = new \Committr\View\LoginView($messenger);

$controller = new \Committr\Controller\MainController($repoList, $loginView, $loginModel, $db);
$controller->doControl();

$isLoggedIn = $controller->getIsLoggedIn();
$isWriting = $controller->getIsWriting();

$repoListView = new \Committr\View\RepoListView($repoList);

$layout->renderPage($isLoggedIn, $isWriting, $loginView, $repoListView);


