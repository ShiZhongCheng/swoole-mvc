<?php


namespace App\Controller;


use App\Libraries\Request;
use App\Libraries\SessionCache;

class BaseController
{
    protected $request;
    protected $userInfo;

    /**
     * BaseController constructor.]
     */
    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->userInfo = (new SessionCache())->get("userInfo");
    }
}