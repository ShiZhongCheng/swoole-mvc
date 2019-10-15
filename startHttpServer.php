<?php
/**
 * 入口文件必须引入此代码才能主动加载类文件
 */
define('DIR', __DIR__);
require DIR . '/autoload/autoload_target.php';

(new \Server\HttpServer())->start();