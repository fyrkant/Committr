<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 14:53
 */

namespace Committr\Model;


class RepoList
{

    private $list;


    public function __construct()
    {
        $this->list = array();
    }

    public function addToList(\Committr\Model\Repo $repo)
    {
        $this->list[] = $repo;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }


}