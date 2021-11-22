<?php

namespace Anunuka\RSStweeter;

use \Exception;

class RssUtil
{
    function getWebResource($url)
    {
        $array = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Content-Type:application/xml' . "\r\n"
                // . 'Authorization: Basic ' . base64_encode($config->getRSSId() . ':' . $config->getRSSPass()) . " \r\n",
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false
            )
        );
        return file_get_contents($url, false, stream_context_create($array));
    }

    function getNewerRssContents($company, $timestamp)
    {
        try {
            $tweetArray = [];
            $xmlStr = $this->getWebResource($company["url"]);
            $xml = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            foreach ($xml->channel->item as $item) {
                $dcdate = strtotime($item->pubDate);
                if ($timestamp->isNew($dcdate)) {
                    array_push($tweetArray, [
                        'title' => trim((string) $item->title),
                        'link' => trim((string) $item->link),
                        'timestamp' => strtotime($item->pubDate)
                    ]);
                }
            }
            return $tweetArray;
        } catch (Exception $e) {
            error_log(date("Y-m-d H:i:s") . "：" . $e->getMessage() . "\n", 3, ERROR_DIR);
            $errStr = $company["name"] . "のRSS収集でエラー発生";
            throw new Exception($errStr);
        }
    }
}
