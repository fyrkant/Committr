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
        if ($this->loginView->userTriedLogin()) {
            $username = $this->loginView->getNameInput();

            //TODO: try-catch for github name
            $this->api = new GithubAPI($username);
            $this->api->populateRepoList($this->repoList);

            return true;
        } else {
            return false;
        }
    }

}