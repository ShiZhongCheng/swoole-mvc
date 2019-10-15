<?php

return [
    "HTTP" => [
        'ip' => '0.0.0.0',
        'port' => '9501',
        'enable_static_handler' => true,
        'document_root' => '/Users/shizhongcheng/website/swoole-mvc/static',
        'max_conn' => 1000,
        'daemonize' => false,
        'reactor_num' => 2,
        'worker_num' => 4,
        'max_request' => 2000,
        'log_file' => '/Users/shizhongcheng/website/swoole-mvc/log/swoole-mvc.log',
        'session_token' => 'token',
    ],
];