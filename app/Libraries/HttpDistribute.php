<?php

namespace App\Libraries;

use Exception;
use Exceptions\ApiException;
use Utils\ConfGet;

class HttpDistribute
{
    public $request = [];
    public $fd = "";
    public $requestUri = "";
    public $uriConf = [];
    public $controller = "";
    public $action = "";
    public $middleware = "";
    public $permissions = [];

    public $userInfo = [];

    /**
     * HttpDistribute constructor.
     */
    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->fd = $this->request->getFd();
        $this->requestUri = $this->request->getRequestUri();
        $this->uriConf = ConfGet::get('route.' . $this->requestUri, []);
        if (isset($this->uriConf["action"])) {
            list($controller, $action) = explode('::', $this->uriConf["action"]);
            $this->controller = $controller;
            $this->action = $action;
        }
        if (isset($this->uriConf["middleware"])) $this->middleware = $this->uriConf["middleware"];
        if (isset($this->uriConf["permissions"])) $this->permissions = $this->uriConf["permissions"];
    }

    /**
     *
     */
    public function run()
    {
        if (empty($this->requestUri) || empty($this->uriConf)) {
            Response::getInstance()->jsonEnd(["code" => -1, "msg" => "Request uri not right"]);
            return;
        }
        $middleRes = $this->middleware();
        if (!is_bool($middleRes)) {
            Response::getInstance()->jsonEnd($middleRes);
            return;
        };
        Response::getInstance()->jsonEnd($this->actionRun());
        return;
    }

    /**
     * @return array|bool
     */
    private function middleWare()
    {
        try {
            if (!isset($this->uriConf["middleware"])) return false;
            $middleName = $this->uriConf["middleware"];
            $middleFileDir = DIR . "/app/Middleware/" . $middleName . ".php";
            if (!is_file($middleFileDir)) return false;
            $middleClass = "\App\Middleware\\" . $middleName;
            new $middleClass($this);
        } catch (ApiException $e) {
            return ["code" => $e->getCode(), "msg" => $e->getMessage(), "data" => $e->getData()];
        }
        return true;
    }

    /**
     * @return array
     */
    private function actionRun()
    {
        try {
            $fileDir = DIR . "/app/Controller/" . $this->controller . ".php";
            $ctrlClass = "\App\Controller\\" . $this->controller;
            if (!is_file($fileDir)) return ["code" => -1, "msg" => "Controller file not exist!"];
            $ctr = new $ctrlClass($this->fd, $this->request, $this->userInfo);
            $action = $this->action;
            if (!method_exists($ctr, $action)) return ["code" => -1, "msg" => "Action not exist!"];
            return $ctr->$action();
        } catch (ApiException $e) {
            return ["code" => $e->getCode(), "msg" => $e->getMessage(), "data" => $e->getData()];
        } catch (Exception $e) {
            return ["code" => $e->getCode(), "msg" => "fail", "data" => $e->getTrace()];
        }
    }
}