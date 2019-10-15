<?php
namespace App\Logic;

use App\Libraries\Request;
use App\Libraries\SessionCache;
use App\Libraries\UserInfo;

class BaseLogic
{
    protected $request;
    protected $userInfo;

    /**
     * BaseLogic constructor.
     */
    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->userInfo = (new SessionCache())->get("userInfo");
    }
}