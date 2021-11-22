<?php
namespace Anunuka\RSStweeter;

class Logger {

    function __construct() {
        $file = "./app.log";
        if (!file_exists($file)) {
            touch($file);
            }
    }

    function writeLog($data) {
        $file = "./app.log";
        file_put_contents($file, $data, FILE_APPEND);
    }

    function startProcess() {
        $this->writeLog(date("Y-m-d H:i:s") . "：処理開始" . "\n");
    }
    
    function closeProcess() {
        $this->writeLog(date("Y-m-d H:i:s") . "：処理終了" . "\n");
    }
}
