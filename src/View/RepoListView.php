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

    public function renderList()
    {
        $returnString = "<div>";

        foreach ($this->repoList->getList() as $repo) {

            $title = $repo->getTitle();
            $description = $repo->getDescription();
            $link = $repo->getURL();

            $html = "<h3>$title</h3><p>$description<a href='$link'>Link to repo</a></p>";

            $returnString .= $html;
        }

        $returnString .= "</div>";

        return $returnString;
    }

}