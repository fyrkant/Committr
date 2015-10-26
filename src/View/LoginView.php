<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:06
 */

namespace Committr\View;


class LoginView
{

    private static $name = "LoginView::Name";
    private static $login = "LoginView::Login";
    private static $oauth = "LoginView::OAuth";
    private static $oauthGET = "code";

    public function response()
    {
        $response = null;


        $response = $this->generateLoginButton();


        return $response;
    }

    private function generateLoginButton()
    {
        return '
        <form method="post">
          <fieldset>
			<legend>Login - enter Github username</legend>

			  <label for="' . self::$name . '">Username :</label>
			  <input type="text" id="' . self::$name . '" name="' . self::$name . '" />

			  <input type="submit" name="' . self::$oauth . '" value="go to github" />

			  <input type="submit" name="' . self::$login . '" value="login" />
			</fieldset>
        </form>

        ';
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

    public function userTriedLogin()
    {
        if (isset($_POST[ self::$login ])) {
            return true;
        } else {
            return false;
        }
    }

    public function getNameInput()
    {
        if (!isset($_POST[ self::$name ])) {
            return "";
        } else {
            return filter_var(trim($_POST[ self::$name ]), FILTER_SANITIZE_STRING);
        }
    }

    public function githubRedirect()
    {
        header("Location: " . "https://github.com/login/oauth/authorize?client_id=" . \AppSettings::GITHUB_API_CLIENT_ID);
        die();
    }

}