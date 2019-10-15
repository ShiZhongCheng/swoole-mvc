<?php

namespace Utils;

class ConfGet
{
    private static $fileMap = [];

    public static function includeConf($fileDir)
    {
        if (isset(self::$fileMap[$fileDir])) {
            return self::$fileMap[$fileDir];
        }
        $fileContent = include $fileDir;
        self::$fileMap[$fileDir] = $fileContent;
        return $fileContent;
    }

    public static function get($symbol, $defaultVal = "")
    {
        $symbolArray = explode(".", $symbol);
        if (empty($symbolArray)) return $defaultVal;
        $fileDir = DIR . '/config/' . $symbolArray[0] . '.php';
        if (count($symbolArray) == 1) {
            if (!file_exists($fileDir)) return $defaultVal;
            return self::includeConf($fileDir);
        }
        unset($symbolArray[0]);
        if (empty($symbolArray)) return $defaultVal;
        if (!file_exists($fileDir)) return $defaultVal;
        $conf = self::includeConf($fileDir);
        foreach ($symbolArray as $sa) {
            if (!isset($conf[$sa])) {
                return $defaultVal;
            }
            $conf = $conf[$sa];
        }

        return $conf;
    }
}