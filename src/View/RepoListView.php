<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 21:55
 */

namespace Committr\View;


use Committr\Model\RepoList;

class RepoListView
{

    /**
     * @var RepoList
     */
    private $repoList;

    public function __construct(RepoList $repoList)
    {
        $this->repoList = $repoList;
    }

    public function renderListHTML()
    {
        if ($this->repoList->hasCommitList()) {
            $commitListView = new CommitListView($this->repoList->getCommitList());
            return $commitListView->renderListHTML();
        } else {
            $returnString = "<h2>List of all repositories:</h2><ul>";

            foreach ($this->repoList->getList() as $repo) {

                $title = $repo->getTitle();
                $description = strlen($repo->getDescription()) > 0 ? $repo->getDescription() : "This repository has no despriction text.";
                $link = $repo->getURL();

                $html = "<li>
                           <h3><a href=\"?repo=$title\">$title</a></h3>
                           <p><strong>Description:</strong> $description</p>
                           <p><a href='$link'>Link to repo</a></p>
                         </li>";

                $returnString .= $html;
            }

            $returnString .= "</ul>";

            return $returnString;
        }
    }

}