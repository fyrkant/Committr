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

    public function response($isLoggedIn)
    {
        $response = null;

        if (@$isLoggedIn) {

            $response = $this->generateLogoutButton();

        } else {

            $response = $this->generateLoginButton();
        }

        return $response;
    }

    private function generateLogoutButton()
    {
        return '
        <form method="post">
          <input type="submit" name="' . self::$logout . '" value="Login with GitHub" />
        </form>
        ';
    }

    private function generateLoginButton()
    {
        return '
        <form method="post">
          <input type="submit" name="' . self::$oauth . '" value="Login with GitHub" />
        </form>
        ';
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

    public function userHasOAuthCode()
    {
        return isset($_GET[ self::$oauthGET ]);
    }

    public function getOAuthCode()
    {
        return $_GET[ self::$oauthGET ];
    }

    public function githubRedirect()
    {
        header("Location: " . "https://github.com/login/oauth/authorize?client_id=" . \AppSettings::GITHUB_API_CLIENT_ID);
        die();
    }

}