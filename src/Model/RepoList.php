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

    /**
     * @var array
     */
    private $list;

    /**
     * @var CommitList
     */
    private $commitList = null;

    /**
     * @param CommitList $commitList
     */
    public function __construct(CommitList $commitList)
    {
        $this->list = array();
        $this->commitList = $commitList;
    }

    public function hasCommitList()
    {
        return count($this->commitList->getCommitList()) > 0;
    }

    /**
     * @return CommitList
     */
    public function getCommitList()
    {
        return $this->commitList;
    }

    /**
     * @param Repo $repo
     */
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