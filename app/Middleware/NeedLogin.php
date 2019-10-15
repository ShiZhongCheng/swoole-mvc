<?php

namespace App\Middleware;

use App\Libraries\HttpDistribute;
use App\Libraries\Request;
use App\Libraries\SessionCache;
use App\Libraries\UserInfo;
use Utils\CommonUtil;
use Utils\ConfGet;

class NeedLogin
{
    private $request;
    private $sessionCache;

    /**
     * NeedLogin constructor.
     * @throws \Exceptions\ApiException
     */
    public function __construct()
    {
        $this->request = Request::getInstance();
        $sessionTokenCookie = $this->request->getCookie(ConfGet::get('server.HTTP.session_token'));
        if (!empty($sessionTokenCookie)) {
            $this->sessionCache = new SessionCache();
        }
        $this->middle();
    }

    /**
     * @return bool
     * @throws \Exceptions\ApiException
     */
    public function middle()
    {
        if (empty($this->sessionCache)) CommonUtil::throwApiException(100, "未登录");
        $userInfo = $this->sessionCache->get("userInfo");
        if (empty($userInfo)) {
            CommonUtil::throwApiException(100, "未登录");
        }
        return true;
    }
}