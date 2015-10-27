<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 14:54
 */

namespace Committr\Model;


class CommitList
{

    private $commitList;
    private $parentRepoName;

    public function __construct()
    {
        $this->commitList = array();
    }

    /**
     * @return mixed
     */
    public function getParentRepoName()
    {
        return $this->parentRepoName;
    }

    /**
     * @param mixed $parentRepoName
     */
    public function setParentRepoName($parentRepoName)
    {
        $this->parentRepoName = $parentRepoName;
    }

    public function addToList(Commit $commit)
    {
        $this->commitList[] = $commit;

    }

    /**
     * @return array
     */
    public function getCommitList()
    {
        return $this->commitList;
    }

}