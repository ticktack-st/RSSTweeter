<?php

namespace Anunuka\RSStweeter;

require "config/configReader.php";

use \Exception;
use Abraham\TwitterOAuth\TwitterOAuth;

class TweetUtil
{
    function getConnnection()
    {
        $config = new ConfigReader();
        $connection = new TwitterOAuth(
            $config->getTwitterClientKey(),
            $config->getTwitterClientSecret(),
            $config->getTwitterClientIdAccessToken(),
            $config->getTwitterClientIdAccessTokenSecret()
        );
        $connection->get('account/verify_credentials');
        if ($connection->getLastHttpCode() !== 200) {
            throw new Exception('twitterアカウント認証に失敗しました。');
        }
        return $connection;
    }

    function tweet($tweetLists, $log)
    {
        $connection = $this->getConnnection();

        foreach ($tweetLists as $tweetList) {
            $securitiesCode = $tweetList[0]["securitiesCode"];
            $name = $tweetList[0]["name"];

            foreach ($tweetList[1] as $tweet) {
                try {
                    // 本文の作成
                    $tw = $securitiesCode . ' ' . $name . ' ';
                    $tw .= $tweet['title'] . ' ' . $tweet['link'];

                    $res = $connection->post(
                        "statuses/update",
                        [
                            "status" => $tw
                        ]
                    );
                    if ($connection->getLastHttpCode() !== 200) {
                        $log->writeLog(date("Y-m-d H:i:s") . "：＜ツイート失敗＞" . $securitiesCode . ' ' . $name . "タイトル：" . $tweet['title'] . "\n");
                        error_log(date("Y-m-d H:i:s") . "：" . json_encode($res) . "\n", 3, ERROR_DIR);
                    } else {
                        $log->writeLog(date("Y-m-d H:i:s") . "：＜ツイート成功＞" . $securitiesCode . ' ' . $name . "タイトル：" . $tweet['title'] . "\n");
                    }
                } catch (Exception $e) {
                    $log->writeLog(date("Y-m-d H:i:s") . "：不明なエラー：" . $e->getMessage() . "\n");
                } finally {
                    sleep(5);
                }
            }
        }
    }
}
