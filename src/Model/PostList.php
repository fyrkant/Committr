<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 12:52
 */

namespace Committr\Model;


class PostList
{

    private $list;

    public function __construct($list)
    {

        $this->list = $list;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    public function addToList(Post $post)
    {
        $this->list[] = $post;
    }

}