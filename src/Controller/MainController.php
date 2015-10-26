<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:26
 */

namespace Committr\Controller;


use Committr\Model\DAL\GithubAPI;
use Committr\Model\LoginModel;
use Committr\Model\RepoList;
use Committr\View\LoginView;

class MainController
{

    private $isLoggedIn;

    /**
     * @var RepoList
     */
    private $repoList;
    /**
     * @var LoginView
     */
    private $loginView;


    private $api;
    /**
     * @var LoginModel
     */
    private $loginModel;

    public function __construct(RepoList $repoList, LoginView $loginView, LoginModel $loginModel)
    {
        $this->repoList = $repoList;
        $this->loginView = $loginView;
        $this->loginModel = $loginModel;
    }

    public function doControl()
    {
        $this->api = new GithubAPI();

        $currentUser = $this->loginView->getUserClient();

        $this->isLoggedIn = $this->loginModel->isLoggedIn($currentUser);


        if ($this->loginView->userHasOAuthCode()) {
            $code = $this->loginView->getOAuthCode();

            $user = $this->api->authenticateAndGetUser($code);

            var_dump($user);
            die();
        }


        if ($this->loginView->userWantToAuthenticate()) {
            $this->loginView->githubRedirect();
        }

    }

    public function getIsLoggedIn()
    {
        return $this->isLoggedIn;
    }

}