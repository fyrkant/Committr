<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-26
 * Time: 14:12
 */

namespace Committr\Model;


class LoginModel
{

    private static $loginSessionLocation = "LoginModel::LoggedIn";

    public function isLoggedIn(UserClient $currentUser)
    {
        if (!isset($_SESSION[ self::$loginSessionLocation ])) {
            return false;
        } else {
            $sessionUser = unserialize($_SESSION[ self::$loginSessionLocation ]);
            $loggedInClient = $sessionUser->getUserClient();

            if ($currentUser->isSame($loggedInClient)) {
                return true;
            }

            return false;

        }
    }

    public function logOut()
    {
        $_SESSION[ self::$loginSessionLocation ] = null;
    }

    public function login(User $user)
    {
        $_SESSION[ self::$loginSessionLocation ] = serialize($user);
    }

    public function getLoggedInUser()
    {
        return unserialize($_SESSION[ self::$loginSessionLocation ]);
    }

}