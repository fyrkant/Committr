<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-26
 * Time: 20:22
 */

namespace Committr\View;


class Messenger
{

    private static $messageKeyPosition = "Messenger::MessageKey";

    private static $messages = [
        "Login"        => "Welcome!",
        "Logout"       => "Goodbye!",
        "Unsanitary"   => "Hmm, I think you were doing something bad, stop it! Only clean input!",
        "TitleEmpty"   => "Please enter a title to save new post.",
        "ContentEmpty" => "Please enter some content to save a new post",
        "AllEmpty"     => "Please enter a title and some content to save new post.",
        "Saved"        => "Post successfully saved."
    ];

    /**
     * @return string
     */
    public function getMessage()
    {
        $messageKey = isset($_COOKIE[ self::$messageKeyPosition ]) ? $_COOKIE[ self::$messageKeyPosition ] : "";

        unset($_COOKIE[ self::$messageKeyPosition ]);
        setcookie(self::$messageKeyPosition, null, -1, "/");

        $message = isset(self::$messages[ $messageKey ]) ? self::$messages[ $messageKey ] : "";

        return $message;
    }

    /**
     * @param $key
     */
    public function setMessageKey($key)
    {
        setcookie(self::$messageKeyPosition, $key, 0, "/");
        $_COOKIE[ self::$messageKeyPosition ] = $key;
    }


}