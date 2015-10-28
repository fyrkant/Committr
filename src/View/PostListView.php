<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 23:48
 */

namespace Committr\View;


use Committr\Model\LoginModel;
use Committr\Model\Post;
use Committr\Model\PostList;

class PostListView
{

    /**
     * @var PostList
     */
    private $postList;
    /**
     * @var LoginModel
     */
    private $isLoggedIn;

    public function __construct(PostList $postList, $loggedIn)
    {

        $this->postList = $postList;
        $this->isLoggedIn = $loggedIn;
    }

    public function render()
    {
        if (count($this->postList->getList()) > 0) {

            $returnString = "<h2>Posts</h2><ul>";

            /** @var Post $post */
            foreach ($this->postList->getList() as $post) {
                $commitMessage = $post->getCommit()->getMessage();
                $commitUrl = $post->getCommit()->getURL();
                $commitSHA = $post->getCommit()->getSha();
                $title = $post->getTitle();
                $content = $post->getContent();

                $html = "<li>
                            <p><strong>Based on:</strong> <a href=\"$commitUrl\">$commitMessage</a></p>
                            <p><strong>Title:</strong> $title</p>
                            <p><strong>Content:</strong> $content</p>
                            ". ($this->isLoggedIn ?
                            "<p>
                                <a class=\"btn btn-warning\" href=\"?edit=$commitSHA\">Update</a>
                                <a class=\"btn btn-danger\" href=\"?remove=$commitSHA\">Remove</a>
                            </p>" : "") ."
                         </li>";

                $returnString .= $html;

            }

            $returnString .= "</ul>";

            return $returnString;

        }
    }


}