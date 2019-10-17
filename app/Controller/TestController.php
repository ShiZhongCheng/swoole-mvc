<?php

namespace App\Controller;

use App\Libraries\SessionCache;
use App\Libraries\UserInfo;
use App\Model\OposUserModel;
use Exception;
use Utils\CommonUtil;
use Utils\ConfGet;

class TestController extends BaseController
{
    /**
     * @return array
     * @throws \Exceptions\ApiException
     * @throws Exception
     */
    public function test()
    {
        $userModel = new OposUserModel();
        CommonUtil::throwApiException(1, "msg", $userModel->setWriteConnect()->where('id=1025')->save(['phone' => '18258205329']));
        return [$this->request, $this->userInfo, $this->request->getCookie(ConfGet::get('server.HTTP.session_token')), (new SessionCache())->getKey()];
    }

    /**
     * @throws \Exceptions\ApiException
     */
    public function test2()
    {
        CommonUtil::throwApiException(-1, "sdasdasda", $this->userInfo);
    }

    public function test3()
    {
        $userInfo = new UserInfo(['userId' => 100, 'userName' => 'szc', 'fd' => $this->request->getFd()]);
        (new SessionCache())->set('userInfo', $userInfo);
        return [$userInfo, ['userId' => 100, 'userName' => 'szc', 'fd' => $this->request->getFd()]];
    }
}