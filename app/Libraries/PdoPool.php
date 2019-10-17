<?php


namespace App\Libraries;


class PdoPool
{
    private static $_instance;
    private $poolLenth = 50;
    private $linkArray = [];

    /**
     * PdoPool constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return PdoPool
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return bool|mixed
     */
    public function pop($type)
    {
        if (!isset($this->linkArray[$type]) || count($this->linkArray[$type]) == 0) {
            return false;
        }
        return array_pop($this->linkArray[$type]);
    }

    /**
     * @param $link
     * @param string $type
     * @return bool
     */
    public function push($link, $type = "read")
    {
        if (!isset($this->linkArray[$type])) {
            $this->linkArray[$type] = [];
        }
        if (count($this->linkArray[$type]) < $this->poolLenth) {
            array_push($this->linkArray[$type], $link);
            return true;
        }
        return false;
    }
}