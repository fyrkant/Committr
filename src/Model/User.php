<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-26
 * Time: 11:26
 */

namespace Committr\Model;


class User
{

    private $name;
    private $id;
    private $avatar;
    private $githubUrl;

    public function __construct($name, $id, $avatar, $githubUrl)
    {

        $this->name = $name;
        $this->id = $id;
        $this->avatar = $avatar;
        $this->githubUrl = $githubUrl;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return mixed
     */
    public function getGithubUrl()
    {
        return $this->githubUrl;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}