<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 11:44
 */

namespace Committr\Model\DAL;


use Committr\Model\Commit;
use Committr\Model\CommitList;
use Committr\Model\Repo;
use Committr\Model\RepoList;
use Committr\Model\User;

class GithubAPI
{
    public function __construct()
    {
    }

    private function authenticate($code)
    {
        $settings = array(
            "client_id"     => \AppSettings::GITHUB_API_CLIENT_ID,
            "client_secret" => \AppSettings::GITHUB_API_CLIENT_SECRET,
            "code"          => $code
        );

        $headerSetting = array("Accept: application/json");

        $oauth2TokenURL = "https://github.com/login/oauth/access_token";

        $content = $this->cURL($oauth2TokenURL, $settings, $headerSetting);

        $JSON = json_decode($content, 1);

        $token = $JSON["access_token"];

        return $token;

    }

    private function getUserFromToken($token)
    {

        $headerSettings = array(
            "Authorization: token $token"
        );

        $userTokenURL = "https://api.github.com/user";

        $content = $this->cURL($userTokenURL, [], $headerSettings);

        $JSON = json_decode($content, 1);

        $userName = $JSON["login"];
        $userID = $JSON["id"];
        $userAvatar = $JSON["avatar_url"];
        $userURL = $JSON["html_url"];

        $user = new User($userName, $userID, $userAvatar, $userURL, $token);

        return $user;
    }

    public function authenticateAndGetUser($code)
    {
        $token = $this->authenticate($code);
        $user = $this->getUserFromToken($token);

        return $user;
    }

    public function getPayload(User $user, $repoName = "")
    {
        $username = $user->getName();
        $token = $user->getToken();

        $headerSettings = array(
            "Authorization: token $token"
        );

        $urlToUse = null;

        if ($repoName == "") {
            $urlToUse = "https://api.github.com/users/" . $username . "/repos";
        } else {
            $urlToUse = "https://api.github.com/repos/" . $username . "/" . $repoName . "/commits";
        }

        $content = $this->cURL($urlToUse, [], $headerSettings);

        return $content;

    }


    public function populateRepoList(RepoList $repoList, User $user)
    {
        $payload = $this->getPayload($user);

        $JSON = json_decode($payload, 1);

        foreach ($JSON as $repo) {

            $name = $repo["name"];
            $description = $repo["description"];
            $url = $repo["html_url"];

            $toSave = new Repo($name, $description, $url);

            $repoList->addToList($toSave);
        }
    }

    public function populateCommitList(CommitList $commitList, User $user, $repoName)
    {
        $payload = $this->getPayload($user, $repoName);

        $JSON = json_decode($payload, 1);

        foreach ($JSON as $commit) {

            $message = $commit["commit"]["message"];
            $sha = $commit["sha"];
            $dateTime = $commit["commit"]["author"]["date"];
            $URL = $commit["html_url"];

            $commitToSave = new Commit($message, $sha, $dateTime, $URL);

            $commitList->addToList($commitToSave);
        }

        $commitList->setParentRepoName($repoName);

    }

    public function findRepoNameWithCommitSHA(User $user, $sha)
    {
        $username = $user->getName();
        $token = $user->getToken();

        $headerSettings = array(
            "Authorization: token $token"
        );

        $URL = "https://api.github.com/repos/" . $username . "/";


        $found = $sha;

        return $found;

    }

    /**
     * @param $URL
     * @param $settings
     * @param $headerSettings
     *
     * @return mixed|null
     */
    public function cURL($URL, $settings, $headerSettings)
    {
        $content = null;

        try {
            $curlHandle = curl_init();

            if ($curlHandle === false) {
                throw new \Exception("Failed to init cURL");
            }

            curl_setopt($curlHandle, CURLOPT_URL, $URL);

            if (count($settings) > 0) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $settings);
            }

            if (count($headerSettings)) {
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headerSettings);
            }

            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_USERAGENT, \AppSettings::GITHUB_API_USER_AGENT);
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

        return $content;
    }
}