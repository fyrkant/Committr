<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-25
 * Time: 11:44
 */

namespace Committr\Model\DAL;


class GetGithubData
{

    private $data;

    public function getContentFromGithub($url)
    {
        $content = null;

        try {
            $curlHandle = curl_init();

            if ($curlHandle === false) {
                throw new \Exception("Failed to init cURL");
            }

            curl_setopt($curlHandle, CURLOPT_URL, $url);
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


}