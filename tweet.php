<?php

namespace Anunuka\RSStweeter;

require "vendor/autoload.php";
require "util/log.php";
require "util/timestamp.php";
require "csv/csvReader.php";
require "util/rssUtil.php";
require "util/arrayUtil.php";
require "util/tweetUtil.php";

use \Exception;

date_default_timezone_set('Asia/Tokyo');
setlocale(LC_ALL, 'ja_JP.UTF-8');
$log = new Logger();
$timestamp = new TimeStamp();
$csv = new CsvReader();
$rssUtil = new RssUtil();
$arrayUtil = new ArrayUtil();
$tweetUtil = new TweetUtil();

define('ERROR_DIR', dirname(__FILE__) . "/logs/error.log");

$log->startProcess();
try {
    $companies = $csv->getCompanyData();
    $tweetLists = array();
    foreach ($companies as $company) {
        try {
            $rssList = $rssUtil->getNewerRssContents($company, $timestamp);
        } catch (Exception $e) {
            $log->writeLog(date("Y-m-d H:i:s") . "：" . $e->getMessage() . "\n");
            continue;
        }
        if (count($rssList) <= 0) continue;

        $tweetList = $arrayUtil->sortList($rssList, 'timestamp');
        array_push($tweetLists, [$company, $tweetList]);
    }
    $tweetUtil->tweet($tweetLists, $log);
} catch (Exception $e) {
    $log->writeLog(date("Y-m-d H:i:s") . "：" . $e->getMessage() . "\n");
} finally {
    $timestamp->update();
    $log->closeProcess();
}
