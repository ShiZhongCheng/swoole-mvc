<?php


namespace App\Libraries;


use Utils\ConfGet;

class Response
{
    private static $_instance;
    public $response;

    /**
     * Response constructor.
     * @param \Swoole\Http\Response $response
     */
    public function __construct(\Swoole\Http\Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self(new \Swoole\Http\Response());
        }
        return self::$_instance;
    }

    /**
     * @param \Swoole\Http\Response $response
     * @return Response
     */
    public static function setInstance(\Swoole\Http\Response $response)
    {
        self::$_instance = new self($response);
        return self::$_instance;
    }

    /**
     * @param $key
     * @param $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     */
    public function setCookie($key, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        $this->response->cookie($key, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * @param $key
     * @param $value
     * @param bool $ucfirst
     */
    public function setHeader($key, $value, $ucfirst = true)
    {
        $this->response->header($key, $value, $ucfirst);
    }

    /**
     * @param string $html
     */
    public function end($html = '')
    {
        // set session_cookie
        $this->setSessionCookie();
        $this->response->end($html);
    }

    /**
     * @param $json
     */
    public function jsonEnd($json)
    {
        $this->setHeader("Content-Type", "application/json; charset=utf-8");
        if (!is_string($json)) {
            $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        }
        // set session_cookie
        $this->setSessionCookie();
        $this->response->end($json);
    }

    /**
     * @return string
     */
    private function creatSessionCookie()
    {
        return md5(uniqid(rand(), TRUE));
    }

    /**
     * @return array|bool|string
     */
    public function setSessionCookie()
    {
        // set session_cookie
        $sessionTokenCookie = Request::getInstance()->getCookie(ConfGet::get('server.HTTP.session_token'));
        if (!$sessionTokenCookie) {
            $sessionTokenCookie = $this->creatSessionCookie();
            $this->setCookie(ConfGet::get('server.HTTP.session_token'), $sessionTokenCookie);
        }
        return $sessionTokenCookie;
    }
}