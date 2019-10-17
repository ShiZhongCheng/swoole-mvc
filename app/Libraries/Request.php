<?php


namespace App\Libraries;


class Request
{
    private static $_instance;
    public $request;

    /**
     * Request constructor.
     * @param \Swoole\Http\Request $request
     */
    private function __construct(\Swoole\Http\Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self(new \Swoole\Http\Request());
        }
        return self::$_instance;
    }

    /**
     * @param \Swoole\Http\Request $request
     * @return Request
     */
    public static function setInstance(\Swoole\Http\Request $request)
    {
        self::$_instance = new self($request);
        return self::$_instance;
    }

    /**
     * @return mixed
     */
    public function getFd()
    {
        return $this->request->fd;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->request->header;
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->request->server;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $this->getServer()["request_method"];
    }

    /**
     * @return mixed
     */
    public function getRequestUri()
    {
        return $this->getServer()["request_uri"];
    }

    /**
     * @return mixed
     */
    public function getPathInfo()
    {
        return $this->getServer()["path_info"];
    }

    /**
     * @param string $key
     * @return array|bool
     */
    public function getCookie($key = "")
    {
        if (empty($key)) {
            return $this->request->cookie;
        }
        if (!isset($this->request->cookie[$key])) return false;
        return $this->request->cookie[$key];
    }

    public function getGetData($key = "")
    {

    }

    public function getPostData($key = "")
    {

    }

    public function getInputData($key = "")
    {

    }
}