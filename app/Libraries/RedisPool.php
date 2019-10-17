<?php


namespace App\Libraries;


class RedisPool
{
    private static $_instance;
    private $poolLenth = 50;
    private $linkArray = [];

    /**
     * RedisPool constructor.
     * @param $poolLenth
     */
    private function __construct()
    {
    }

    /**
     * @return RedisPool
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
    public function pop()
    {
        if (count($this->linkArray) == 0) {
            return false;
        }
        return array_pop($this->linkArray);
    }

    /**
     * @param $link
     * @return bool
     */
    public function push(\Redis $link)
    {
        if (count($this->linkArray) < $this->poolLenth) {
            array_push($this->linkArray, $link);
            return true;
        }
        return false;
    }
}