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
    private $userClient;
    private $token;

    public function __construct($name, $id, $avatar, $githubUrl, $token)
    {

        $this->name = $name;
        $this->id = $id;
        $this->avatar = $avatar;
        $this->githubUrl = $githubUrl;
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
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

    /**
     * @return UserClient
     */
    public function getUserClient()
    {
        return $this->userClient;
    }

    /**
     * @param UserClient $userClient
     */
    public function setUserClient(UserClient $userClient)
    {
        $this->userClient = $userClient;
    }



}