<?php

namespace Anunuka\RSStweeter;

class ArrayUtil
{
    function sortList($array, $sortKey)
    {
        foreach ($array as $key => $value) {
            $sort[$key] = $value[$sortKey];
        }
        array_multisort($sort, SORT_ASC, $array);
        return $array;
    }
}
