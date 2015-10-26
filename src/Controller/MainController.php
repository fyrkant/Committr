<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:26
 */

namespace Committr\Controller;


use Committr\Model\DAL\GithubAPI;
use Committr\Model\RepoList;
use Committr\Model\User;
use Committr\View\LoginView;

class MainController
{
    /**
     * @var RepoList
     */
    private $repoList;
    /**
     * @var LoginView
     */
    private $loginView;

    private $api;

    public function __construct(RepoList $repoList, LoginView $loginView)
    {
        $this->repoList = $repoList;
        $this->loginView = $loginView;
    }

    public function doControl()
    {
        $this->api = new GithubAPI();

        if ($this->loginView->userHasOAuthCode()) {
            $code = $this->loginView->getOAuthCode();

            $token = $this->api->authorize($code);

            $user = $this->api->getUserFromToken($token);



            var_dump($user);
            die();
        }


        if ($this->loginView->userWantToAuthenticate()) {
            $this->loginView->githubRedirect();
        }

        if ($this->loginView->userTriedLogin()) {
            $username = $this->loginView->getNameInput();
            $this->api->getPayload($username, true);
            //TODO: try-catch for github name
            $this->api->populateRepoList($this->repoList);

            return true;
        } else {
            return false;
        }
    }

}