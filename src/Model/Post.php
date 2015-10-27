<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 12:53
 */

namespace Committr\Model;


class Post
{

    /**
     * @var Commit
     */
    private $commit;
    private $title;
    private $content;

    public function __construct(Commit $commit, $title, $content)
    {
        $this->commit = $commit;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return Commit
     */
    public function getCommit()
    {
        return $this->commit;
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
    public function getContent()
    {
        return $this->content;
    }

}