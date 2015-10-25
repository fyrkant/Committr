<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 14:53
 */

namespace Committr\Model;


class Repo
{

    private $title;
    private $description;
    private $URL;
    private $commitList;

    public function __construct($title, $description, $URL)
    {

        $this->title = $title;
        $this->description = $description;
        $this->URL = $URL;
        $this->commitList = new CommitList();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getURL()
    {
        return $this->URL;
    }

}