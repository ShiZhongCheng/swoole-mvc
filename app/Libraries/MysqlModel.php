<?php


namespace App\Libraries;

use Utils\ConfGet;

class MysqlModel
{
    protected $mysqlHandle;
    protected $config;
    protected $type = "read";

    /**
     * MysqlModel constructor.
     * @param string $type
     */
    public function __construct($type = "read")
    {
        $this->config = $this->getConfig();
        $handle = PdoPool::getInstance()->pop();
        if (!$handle) {
            connect:
            $this->mysqlHandle = new \mysqli($this->config["host"] . ":" . $this->config["port"], $this->config["username"], $this->config["password"]);
            if (isset($this->config["charset"]) && !empty($this->config["charset"])) {
                $this->mysqlHandle->set_charset($this->config["charset"]);
            }
        } else {
            $this->mysqlHandle = $handle;
            // 检测连接是否有效
            if ($handle->connect_error) {
                goto connect;
            }
        }
    }

    public function __destruct()
    {
        PdoPool::getInstance()->push($this->mysqlHandle);
    }

    /**
     * @return mixed|string
     */
    public function getConfig()
    {
        $mysqlConfig = ConfGet::get("mysql." . $this->type);
        $hosts = $mysqlConfig["host"];
        $hosts = explode(',', $hosts);
        $count = count($hosts);
        if ($count == 1) {
            $mysqlConfig["host"] = $hosts[0];
        }
        $mysqlConfig["host"] = $hosts[rand(0, $count)];
        return $mysqlConfig;
    }
}