<?php


namespace App\Libraries;


class UserInfo
{
    public $fd;
    public $userId = -1;
    public $userName = "";
    public $permissions = [];

    public function __construct($params)
    {
        if (isset($params["fd"])) $this->fd = $params["fd"];
        if (isset($params["userId"])) $this->userId = $params["userId"];
        if (isset($params["userName"])) $this->userName = $params["userName"];
        if (isset($params["permissions"])) $this->permissions = $params["permissions"];
    }
}