<?php

namespace Anunuka\RSStweeter;

use Exception;

class CsvReader
{
    public function getCompanyData()
    {
        $array = array();
        try {
            if (($handle = fopen(dirname(__FILE__) . "/company.csv", "r")) !== FALSE) {
                $row = 1;
                while (($data = fgetcsv($handle, 250, ",")) !== FALSE) {
                    $num = count($data);
                    if ($num != 3) throw new Exception("csvファイルの" . $row . "行目の構成が間違っています。");

                    $tmpArray = array('securitiesCode' => $data[0], 'name' => $data[1], 'url' => $data[2]);
                    array_push($array, $tmpArray);
                    $row++;
                }
                fclose($handle);
            }
        } catch (Exception $ex) {
            error_log(date("Y-m-d H:i:s") . "：" . $ex->getMessage() . "\n", 3, ERROR_DIR);
            $errStr = "CSVの構成に不備があります。";
            throw new Exception($errStr);
        }
        return $array;
    }
}
