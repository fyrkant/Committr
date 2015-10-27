<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:06
 */

namespace Committr\View;


use Committr\Model\UserClient;

class LoginView
{

    private static $logout = "LoginView::Logout";
    private static $oauth = "LoginView::OAuth";
    private static $oauthGET = "code";
    private static $repoGET = "repo";
    private static $newPostGET = "newPost";
    /**
     * @var
     */
    private $messenger;

    public function __construct(Messenger $messenger)
    {
        $this->messenger = $messenger;
    }

    public function response($isLoggedIn)
    {
        $response = null;

        if ($isLoggedIn) {

            $response = $this->generateLogoutButton();

        } else {

            $response = $this->generateLoginButton();
        }

        return $response;
    }

    private function generateLogoutButton()
    {
        return '
        <form method="post" class="form-inline down">
            <div class="form-group">
                <input class="btn btn-danger btn-lg down" type="submit" name="' . self::$logout . '" value="Logout" />
            </div>
        </form>
        ';
    }

    private function generateLoginButton()
    {
        return '
        <div class="jumbotron">
            <h1>Don\'t wait, login now!</h1>
            <p class="lead">Just press the button</p>
            <form method="post" class="form-inline down">
                <div class="form-group">
                    <input class="btn btn-success btn-lg down" type="submit" name="' . self::$oauth . '" value="Login with GitHub" />
                </div>
            </form>
        </div>

        ';
    }

    public function setMessageKey($key)
    {
        $this->messenger->setMessageKey($key);
    }

    public function getUserClient()
    {
        $userClient = new UserClient($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);

        return $userClient;
    }

    public function userWantToAuthenticate()
    {
        return isset($_POST[ self::$oauth ]);
    }

    public function userWantsToLogOut()
    {
        return isset($_POST[ self::$logout ]);
    }

    public function userHasSelectedRepo()
    {
        return isset($_GET[ self::$repoGET ]);
    }

    public function getUserSelectedRepo()
    {
        return $_GET[ self::$repoGET ];
    }

    public function userHasOAuthCode()
    {
        return isset($_GET[ self::$oauthGET ]);
    }

    public function getOAuthCode()
    {
        return $_GET[ self::$oauthGET ];
    }

    public function userWantsToWriteNewPost()
    {
        return isset($_GET[ self::$newPostGET ]);
    }

    public function getNewPostCommitSHA()
    {
        return $_GET[ self::$newPostGET ];
    }

    public function githubRedirect()
    {
        header("Location: " . "https://github.com/login/oauth/authorize?client_id=" . \AppSettings::GITHUB_API_CLIENT_ID);
        die();
    }

    public function redirect()
    {
        $actual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        header("Location: $actual");
        die();
    }

}