<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 09:30
 */

namespace Committr\View;


use Committr\Model\Commit;
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

    /**
     * @return string
     */
    public function render()
    {
        $parentRepoName = $this->commitList->getParentRepoName();

        $returnString = "<p><a class=\"btn btn-default\" href=\"?\">Back to repository list.</a></p>
                         <h2>List of commits in repository $parentRepoName</h2><ul>";

        /** @var Commit $commit */
        foreach ($this->commitList->getCommitList() as $commit) {
            $message = $commit->getMessage();
            $sha = $commit->getSha();
            $dateTime = $commit->getDateTime();
            $URL = $commit->getURL();

            $getText = $sha ."_::_" . $parentRepoName;

            $html = "<li>
                       <p><strong>SHA:</strong> $sha</p>
                       <p><strong>Comment:</strong> <em>$message</em></p>
                       <p><strong>Date: </strong> $dateTime</p>
                       <p><a class=\"btn btn-info\" href=\"$URL\">Link to commit</a></p>
                       <p><a class=\"btn btn-primary\" href=\"?newPost=$getText\">Create post based on this.</a></p>
                     </li>";

            $returnString .= $html;
        }


        $returnString .= "</ul>";

        return $returnString;
    }

}