<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 14:54
 */

namespace Committr\Model;


class Commit
{

    private $message;
    private $dateTime;
    private $URL;

    public function __construct($message, $dateTime, $URL)
    {

        $this->message = $message;
        $this->dateTime = $dateTime;
        $this->URL = $URL;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return mixed
     */
    public function getURL()
    {
        return $this->URL;
    }

}