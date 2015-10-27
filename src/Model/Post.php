<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 12:53
 */

namespace Committr\Model;


use Committr\Exceptions\AllEmptyException;
use Committr\Exceptions\ContentEmptyException;
use Committr\Exceptions\TitleEmptyException;
use Committr\Exceptions\UnsanitaryException;

class Post
{

    /**
     * @var Commit
     */
    private $parentRepoName;
    private $title;
    private $content;

    public function __construct($parentRepoName, $title, $content)
    {
        if ($title == "" && $content == "") {
            throw new AllEmptyException();
        }
        if ($title == "") {
            throw new TitleEmptyException();
        }
        if ($content == "") {
            throw new ContentEmptyException();
        }

        if (filter_var($title, FILTER_SANITIZE_STRING) !== $title || filter_var($content, FILTER_SANITIZE_STRING) !== $content) {
            throw new UnsanitaryException();
        }

        $this->parentRepoName = $parentRepoName;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return Commit
     */
    public function getParentRepoName()
    {
        return $this->parentRepoName;
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