<?php

session_start();

require_once("AppSettings.php");
require_once("vendor/autoload.php");

if (\AppSettings::DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

$db = new Committr\Model\DAL\MongoDAL();


$loginModel = new \Committr\Model\LoginModel();

$commitList = new \Committr\Model\CommitList();
$repoList = new \Committr\Model\RepoList($commitList);

$postList = new \Committr\Model\PostList();
$messenger = new \Committr\View\Messenger();

$writer = new \Committr\View\WriteView($commitList, $messenger);

$loginView = new \Committr\View\LoginView($messenger);

$controller = new \Committr\Controller\MainController($repoList, $postList, $loginView, $writer, $loginModel, $db);
$controller->doControl();

$isLoggedIn = $controller->getIsLoggedIn();
$isWriting = $controller->getIsWriting();

$repoListView = new \Committr\View\RepoListView($repoList);
$postListView = new \Committr\View\PostListView($postList, $isLoggedIn);

$layout = new Committr\View\LayoutView($messenger);
$layout->renderPage($isLoggedIn, $isWriting, $loginView, $repoListView, $postListView, $writer);


