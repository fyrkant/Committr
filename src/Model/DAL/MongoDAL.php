<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-22
 * Time: 15:08
 */

namespace Committr\Model\DAL;


use Committr\Model\Commit;
use Committr\Model\Post;
use Committr\Model\PostList;
use Committr\Model\User;

class MongoDAL
{

    /*
     * Using MongoDB driver
     * URL: http://php.net/mongo
     */

    private $db;

    public function __construct()
    {
        try {
            $serverString = "mongodb://"
                . \AppSettings::MONGO_USERNAME . ":"
                . \AppSettings::MONGO_PASSWORD . "@"
                . \AppSettings::MONGO_IP;
            $m = new \MongoClient($serverString);
            $this->db = $m->selectDB("committr");
        } catch (\MongoConnectionException $e) {
            echo $e->getMessage();
        }
    }

    public function postsExist($userName)
    {
        $something = $this->db->selectCollection($userName)->findOne();

        return isset($something["title"]);
    }

    public function populatePostList(PostList $postList, $userName)
    {
        $posts = $this->db->selectCollection($userName)->find();

        foreach ($posts as $post) {

            $message = $post["commit"]["message"];
            $sha = $post["commit"]["sha"];
            $dateTime = $post["commit"]["dateTime"];
            $URL = $post["commit"]["url"];

            $commitToSave = new Commit($message, $sha, $dateTime, $URL);

            $title = $post["title"];
            $content = $post["content"];

            $toSave = new Post($commitToSave, $title, $content);

            $postList->addToList($toSave);
        }


    }

    public function saveNewPost(User $user, Post $post)
    {
        $toSave = [
            "title"   => $post->getTitle(),
            "content" => $post->getContent(),
            "commit"  => [
                "message" => $post->getCommit()->getMessage(),
                "url"     => $post->getCommit()->getURL(),
                "sha" => $post->getCommit()->getSha(),
                "dateTime" => $post->getCommit()->getDateTime()
            ]
        ];

        $this->db->selectCollection($user->getName())->save($toSave);

        //var_dump($this->db->selectCollection($user->getName())->find());

    }


}