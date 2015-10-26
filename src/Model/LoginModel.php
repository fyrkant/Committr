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

            if ($currentUser->isSame($sessionUser)) {
                return true;
            }

            return false;

        }
    }

    public function logOut()
    {
        $_SESSION[ self::$loginSessionLocation ] = null;
    }

    public function login(UserClient $currentUser)
    {
        $_SESSION[ self::$loginSessionLocation ] = serialize($currentUser);
    }

}