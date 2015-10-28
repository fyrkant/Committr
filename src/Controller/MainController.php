<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:26
 */

namespace Committr\Controller;


use Committr\Model\DAL\GithubAPI;
use Committr\Model\DAL\MongoDAL;
use Committr\Model\LoginModel;
use Committr\Model\PostList;
use Committr\Model\RepoList;
use Committr\Model\User;
use Committr\View\LoginView;
use Committr\View\WriteView;

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
     * @var PostList
     */
    private $postList;
    /**
     * @var WriteView
     */
    private $writer;
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

    public function __construct(RepoList $repoList,
                                PostList $postList,
                                LoginView $loginView,
                                WriteView $writer,
                                LoginModel $loginModel,
                                MongoDAL $db)
    {
        $this->repoList = $repoList;
        $this->postList = $postList;
        $this->loginView = $loginView;
        $this->loginModel = $loginModel;
        $this->db = $db;
        $this->writer = $writer;
    }

    /**
     * @return mixed
     */
    public function getIsWriting()
    {
        return $this->isWriting;
    }

    public function doControl()
    {
        $currentUser = $this->loginView->getUserClient();
        $isLoggedIn = $this->loginModel->isLoggedIn($currentUser);

        $this->api = new GithubAPI();

        if ($this->loginView->userWantsToSeePosts()) {
            $userName = $this->loginView->getUserToShow();

            if ($this->db->postsExist($userName)) {
                $this->db->populatePostList($this->postList, $userName);
            }

        }


        if ($isLoggedIn) {
            /** @var User $user */
            $user = $this->loginModel->getLoggedInUser();

            $this->api->populateRepoList($this->repoList, $user);

            if ($this->loginView->userWantsToEditPost()) {
                //$sha = $this->loginView->getShaToEdit();
                echo "Sorry, this functionality has not been implemented yet.";
            }
            if ($this->loginView->userWantsToRemovePost()) {
                //$sha = $this->loginView->getShaToRemove();
                echo "Sorry, this functionality has not been implemented yet.";
            }

            if ($this->db->postsExist($user->getName())) {
                $this->db->populatePostList($this->postList, $user->getName());
            }

            if ($this->loginView->userWantsToWriteNewPost()) {

                $sha = $this->loginView->getNewPostCommitSHA();
                $this->api->populateCommitList($this->repoList->getCommitList(), $user, explode("_::_", $sha)[1]);

                if ($this->writer->userWantsToSaveNewPost()) {
                    $toSave = $this->writer->getNewPost();

                    if ($toSave != false) {
                        $this->db->saveNewPost($user, $toSave);
                        $this->loginView->setMessageKey("Saved");
                        $this->loginView->redirect();
                    }
                }

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