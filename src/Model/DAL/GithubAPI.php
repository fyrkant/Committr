<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 11:44
 */

namespace Committr\Model\DAL;


use Committr\Model\Repo;
use Committr\Model\RepoList;
use Committr\Model\User;

class GithubAPI
{

    private $data;
    private $username;

    public function __construct()
    {
    }

    public function authorize($code)
    {
        $settings = array(
            "client_id"     => \AppSettings::GITHUB_API_CLIENT_ID,
            "client_secret" => \AppSettings::GITHUB_API_CLIENT_SECRET,
            "code"          => $code
        );

        $headerSetting = array("Accept: application/json");

        $oauth2TokenURL = "https://github.com/login/oauth/access_token";

        $content = null;


        try {
            $curlHandle = curl_init();

            if ($curlHandle === false) {
                throw new \Exception("Failed to init cURL");
            }

            curl_setopt($curlHandle, CURLOPT_URL, $oauth2TokenURL);
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $settings);
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headerSetting);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_USERAGENT, "committr");
//            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 1);
            $content = curl_exec($curlHandle);

            if ($content === false) {
                throw new \Exception(curl_error($curlHandle), curl_errno($curlHandle));
            }
            curl_close($curlHandle);
        } catch (\Exception $e) {

            trigger_error(sprintf('cURL failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }

        $JSON = json_decode($content, 1);

        $token = $JSON["access_token"];

        return $token;

    }

    public function getUserFromToken($token)
    {

        $headerSettings = array(
            "Authorization: token $token"
        );

        $userTokenURL = "https://api.github.com/user";

        $content = null;
        try {
            $curlHandle = curl_init();

            if ($curlHandle === false) {
                throw new \Exception("Failed to init cURL");
            }

            curl_setopt($curlHandle, CURLOPT_URL, $userTokenURL);
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headerSettings);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_USERAGENT, "committr");
//            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 1);
            $content = curl_exec($curlHandle);

            if ($content === false) {
                throw new \Exception(curl_error($curlHandle), curl_errno($curlHandle));
            }
            curl_close($curlHandle);
        } catch (\Exception $e) {

            trigger_error(sprintf('cURL failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }

        $JSON = json_decode($content, 1);

        $userName = $JSON["login"];
        $userID = $JSON["id"];
        $userAvatar = $JSON["avatar_url"];
        $userURL = $JSON["html_url"];

        $user = new User($userName, $userID, $userAvatar, $userURL);

        return $user;
    }

    public function getPayload($username, $isInitial)
    {
        $this->username = $username;

        $content = null;

        $urlToUse = null;

        if ($isInitial) {
            $urlToUse = "https://api.github.com/users/" . $this->username . "/repos";
        } else {
            $urlToUse = "https://api.github.com/repos/" . $this->username . "/repos";
        }
        try {
            $curlHandle = curl_init();

            if ($curlHandle === false) {
                throw new \Exception("Failed to init cURL");
            }

            curl_setopt($curlHandle, CURLOPT_URL, $urlToUse);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_USERAGENT, "committr");
//            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 1);
            $content = curl_exec($curlHandle);

            if ($content === false) {
                throw new \Exception(curl_error($curlHandle), curl_errno($curlHandle));
            }
            curl_close($curlHandle);
        } catch (\Exception $e) {

            trigger_error(sprintf('cURL failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }

        $this->data = $content;

        return $content;

    }

    public function getReposJSON($content)
    {

    }

    public function test()
    {
        $plugin = "overlay";
        $pathToCache = $_SERVER['DOCUMENT_ROOT'] . '/plugin-cache/';
        $fileCache = $plugin . '-github.txt';
        $githubJSON = $this->getRepositoryJSONData($pathToCache . $fileCache, $plugin);


    }

    public function getRepositoryJSONData($file, $plugin)
    {
        $currrentTime = time();
        $expireTime = 24 * 60 * 60;
        $fileTime = filemtime($file);

        if (file_exists($file) && ($currrentTime - $expireTime < $fileTime)) {
            return json_decode(file_get_contents($file));
        } else {
            $JSON = array();

        }
    }

    public function populateRepoList(RepoList $repoList)
    {
        $JSON = json_decode($this->data, 1);

        foreach ($JSON as $repo) {
            $name = $repo["name"];
            $description = $repo["description"];
            $url = $repo["url"];
            $toSave = new Repo($name, $description, $url);

            $repoList->addToList($toSave);
        }
    }


}