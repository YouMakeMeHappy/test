<?php


class ArrayDataMerge {

    public static function merge($fArray, $sArray, $pk)
    {
        $mergedArray = [];

        foreach ($fArray as $fKey => $fVal)
        {
            $_tmp = [];

            foreach ($sArray as $sKey => $sVal) {
                if ($fVal[$pk] != $sVal[$pk]) {
                    continue;
                }

                $_tmp = array_merge($fVal, $sVal);
                unset($sArray[$sKey]);

                break;
            }

            $mergedArray[] = $_tmp;
        }

        return $mergedArray;
    }
}