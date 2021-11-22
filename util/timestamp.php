<?php
namespace Anunuka\RSStweeter;

class TimeStamp {

    function __construct() {
        $file = "./timestamp.txt";
        if (!file_exists($file)) {
            $now = strtotime("now");
            $display = $this->toStrTime($now);
            file_put_contents($file, $display);
        }
    }

    function update() {
        $file = "./timestamp.txt";
        $now = strtotime("now");
        $display = $this->toStrTime($now);
        file_put_contents($file, $display);
}

    function isNew($dateString) {
        $file = "./timestamp.txt";
        if (!file_exists($file)) {
            return false;
        }
        else {
            $content = file_get_contents($file);
            $contentTimeStamp = $this->toTimeStamp($content);
            if ($dateString > $contentTimeStamp) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    function toTimeStamp($time) {
        return strtotime($time);
    }

    function toStrTime($time) {
        return date("Y/m/d H:i:s", $time);
    }
}

?>
