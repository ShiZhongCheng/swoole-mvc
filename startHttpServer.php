<?php
define('DIR', __DIR__);
require DIR . '/server/HttpServer.php';

(new \Server\HttpServer())->start();