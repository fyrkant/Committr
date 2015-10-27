<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:26
 */

namespace Committr\Controller;


use Committr\Model\CommitList;
use Committr\Model\DAL\GithubAPI;
use Committr\Model\DAL\MongoDAL;
use Committr\Model\LoginModel;
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


    private $isWriting;

    /**
     * @return mixed
     */
    public function getIsWriting()
    {
        return $this->isWriting;
    }

    /**
     * @var GithubAPI
     */
    private $api;
    /**
     * @var LoginModel
     */
    private $loginModel;
    /**
     * @var MongoDAL
     */
    private $db;

    public function __construct(RepoList $repoList, LoginView $loginView, LoginModel $loginModel, MongoDAL $db)
    {
        $this->repoList = $repoList;
        $this->loginView = $loginView;
        $this->loginModel = $loginModel;
        $this->db = $db;
    }

    public function doControl()
    {
        $currentUser = $this->loginView->getUserClient();
        $isLoggedIn = $this->loginModel->isLoggedIn($currentUser);

        $this->api = new GithubAPI();

        if ($isLoggedIn) {


            $user = $this->loginModel->getLoggedInUser();
            $this->api->populateRepoList($this->repoList, $user);

//            if ($this->db->postsExist($user->getName())) {
//                echo "no posts";
//            } else {
//                echo "some posts";
//            }


            if ($this->loginView->userWantsToWriteNewPost()) {
                $sha = $this->loginView->getNewPostCommitSHA();

                $this->isWriting = true;

            }


            if ($this->loginView->userHasSelectedRepo()) {
                $repoName = $this->loginView->getUserSelectedRepo();

                $this->api->populateCommitList($this->repoList->getCommitList(), $user, $repoName);

            }
            if ($this->loginView->userWantsToLogOut()) {
                $this->loginModel->logOut();
                $this->loginView->setMessageKey("Logout");
                $this->loginView->redirect();
            }
        } else {

            if ($this->loginView->userWantToAuthenticate()) {
                $this->loginView->githubRedirect();
            }

            if ($this->loginView->userHasOAuthCode()) {
                $code = $this->loginView->getOAuthCode();

                $user = $this->api->authenticateAndGetUser($code);
                $user->setUserClient($currentUser);

                $this->loginModel->login($user);
                $this->loginView->setMessageKey("Login");
                $this->loginView->redirect();
            }

        }

    }

    public function getIsLoggedIn()
    {
        $currentUser = $this->loginView->getUserClient();

        return $this->loginModel->isLoggedIn($currentUser);
    }

}