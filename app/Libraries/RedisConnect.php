<?php


namespace App\Libraries;


use Utils\ConfGet;

class RedisConnect
{
    protected $redisHandle;
    protected $config;

    /**
     * RedisConnect constructor.
     */
    public function __construct()
    {
        $this->config = $this->getConfig();
        $this->redisHandle = new \Redis();
        $this->redisHandle->pconnect($this->config['host'], $this->config['port']);
        if (isset($this->config['password']) && !empty($this->config['password'])) {
            $this->redisHandle->auth($this->config['password']);
        }
    }

    public function __destruct()
    {
        $this->redisHandle->close();
    }

    /**
     * 序列化操作
     * @param $data
     * @return string
     */
    private function serialize($data)
    {
        if (is_array($data) || is_object($data) || is_bool($data) || is_null($data)) {
            $data = serialize($data);
        }
        return $data;
    }

    /**
     * 反序列化，判断操作
     * @param $data
     * @return bool|mixed|null
     */
    private function unSerialize($data)
    {
        if (is_string($data)) {
            if ($data == "N;") return null;
            if (substr($data, 1, 1) == ":") {
                if ($data == "b:0;") return false;
                $_data = @unserialize($data);
                if ($_data !== false) {
                    return $_data;
                }
            }
        }
        return $data;
    }

    /**
     * @return mixed
     */
    private function getConfig()
    {
        $redisConfig = ConfGet::get("redis");
        $count = count($redisConfig);
        if ($count == 1) {
            return $redisConfig[0];
        }
        return $redisConfig[rand(0, $count)];
    }

    /**
     * @return \Redis
     */
    public function getHandle()
    {
        return $this->redisHandle;
    }

    /**
     * @param $key
     * @param $val
     * @param float|int $timeout
     * @return bool
     */
    public function set($key, $val, $timeout = 24 * 60 * 60)
    {
        $val = $this->serialize($val);
        return $this->redisHandle->set($key, $val, $timeout);
    }

    /**
     * @param $key
     * @return bool|mixed|null
     */
    public function get($key)
    {
        $res = $this->redisHandle->get($key);
        return $this->unSerialize($res);
    }
}