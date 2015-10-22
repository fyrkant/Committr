<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-22
 * Time: 15:08
 */

namespace Committr\Model\DAL;


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
            $this->db = $m->selectDB("users")->selectCollection("creds");
        } catch (\MongoConnectionException $e) {
            echo $e->getMessage();
        }
    }

}