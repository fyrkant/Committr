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

    public function __construct()
    {
        $this->commitList = array();
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