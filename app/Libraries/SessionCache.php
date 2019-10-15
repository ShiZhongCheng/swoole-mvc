<?php


namespace App\Libraries;


use Utils\ConfGet;

class SessionCache
{
    private $uniqueKey;
    private $redis;
    private $bigVal = [];
    private $timeOut = 12 * 60 * 60;

    /**
     * SessionCache constructor.
     */
    public function __construct()
    {
        $sessionTokenCookie = Request::getInstance()->getCookie(ConfGet::get('server.HTTP.session_token'));
        if (!$sessionTokenCookie) {
            $sessionTokenCookie = Response::getInstance()->setSessionCookie();
        }
        $this->uniqueKey = md5("Session_" . (!$sessionTokenCookie ? "" : $sessionTokenCookie));
        $this->redis = new RedisConnect();
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->uniqueKey;
    }

    /**
     * @param $key
     * @param $val
     * @return bool
     */
    public function set($key, $val)
    {
        $allVal = $this->getAll();
        if (is_array($allVal)) {
            foreach ($allVal as $keyTmp => $valTmp) {
                $this->bigVal[$keyTmp] = $valTmp;
            }
        }
        $this->bigVal[$key] = $val;
        return $this->redis->set($this->uniqueKey, $this->bigVal, $this->timeOut);
    }

    /**
     * @param $key
     * @param string $defaultVal
     * @return mixed|string
     */
    public function get($key, $defaultVal = "")
    {
        $allVal = $this->getAll();
        if (!isset($allVal[$key])) {
            return $defaultVal;
        }
        return $allVal[$key];
    }

    /**
     * @return bool|mixed|null
     */
    private function getAll()
    {
        return $this->redis->get($this->uniqueKey);
    }
}