<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-22
 * Time: 15:08
 */

namespace Committr\Model\DAL;


use Committr\Model\Post;
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

    public function postsExist(User $user)
    {
        $something = $this->db->selectCollection($user->getName())->findOne();

        return isset($something["title"]) === false;
    }

    public function saveNewPost(User $user, Post $post)
    {
        $toSave = [
            "title" => $post->getTitle(),
            "content" => $post->getContent()
        ];
        $this->db->selectCollection($user->getName())->save($toSave);

        //var_dump($this->db->selectCollection($user->getName())->find());

    }



}