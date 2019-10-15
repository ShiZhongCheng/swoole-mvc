<?php

namespace App\Controller;

use App\Libraries\RedisConnect;
use App\Libraries\SessionCache;
use App\Libraries\UserInfo;
use Exception;
use Utils\CommonUtil;
use Utils\ConfGet;

class TestController extends BaseController
{
    public function test()
    {
        return [$this->request, $this->userInfo, $this->request->getCookie(ConfGet::get('server.HTTP.session_token')), (new SessionCache())->getKey()];
    }

    /**
     * @throws \Exceptions\ApiException
     */
    public function test2()
    {
        CommonUtil::throwApiException(-1, "test", $this->userInfo);
    }

    public function test3()
    {
        $userInfo = new UserInfo(['userId' => 100, 'userName' => 'szc', 'fd' => $this->request->getFd()]);
        (new SessionCache())->set('userInfo', $userInfo);
        return [$userInfo, ['userId' => 100, 'userName' => 'szc', 'fd' => $this->request->getFd()]];
    }
}