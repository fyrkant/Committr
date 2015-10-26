<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-26
 * Time: 14:13
 */

namespace Committr\Model;


class UserClient
{

    private $ip;
    private $agent;

    public function __construct($ip, $agent)
    {
        $this->ip = $ip;
        $this->agent = $agent;
    }

    public function isSame(UserClient $uc)
    {
        return ($uc->agent === $this->agent && $uc->ip === $this->ip);
    }

}