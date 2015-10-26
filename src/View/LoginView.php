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
        $message = $this->messenger->getMessage();

        $response = null;

        if ($isLoggedIn) {

            $response = $this->generateLogoutButton($message);

        } else {

            $response = $this->generateLoginButton($message);
        }

        return $response;
    }

    private function generateLogoutButton($message)
    {
        return '
        <form method="post">
          <p>' . $message . '</p>
          <input type="submit" name="' . self::$logout . '" value="Logout" />
        </form>
        ';
    }

    private function generateLoginButton($message)
    {
        return '
        <form method="post">
          <p>' . $message . '</p>
          <input type="submit" name="' . self::$oauth . '" value="Login with GitHub" />
        </form>
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

    public function redirect()
    {
        $actual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        header("Location: $actual");
        die();
    }

}