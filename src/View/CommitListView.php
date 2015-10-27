<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 09:30
 */

namespace Committr\View;


use Committr\Model\CommitList;

class CommitListView
{

    /**
     * @var CommitList
     */
    private $commitList;

    public function __construct(CommitList $commitList)
    {

        $this->commitList = $commitList;
    }

    public function renderListHTML()
    {
        $parentRepoName = $this->commitList->getParentRepoName();

        $returnString = "<h2>List of commits in repository $parentRepoName</h2><ul>";

        foreach ($this->commitList->getCommitList() as $commit) {
            $message = $commit->getMessage();
            $sha = $commit->getSha();
            $dateTime = $commit->getDateTime();
            $URL = $commit->getURL();

            $html = "<li>
                       <p><strong>Comment:</strong> <em>$message</em></p>
                       <p><strong>Date: </strong> $dateTime</p>
                       <p><a href=\"$URL\">Link to commit</a></p>
                       <p><a href=\"?sha=$sha\">Create post based on this.</a></p>
                     </li>";

            $returnString .= $html;
        }


        $returnString .= "</ul>";

        return $returnString;
    }

}