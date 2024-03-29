<?php

return [
    "opos" => [
        "write" => [
            "hostname" => '127.0.0.1', # 可选，默认127.0.0.1
            "username" => 'root', # 可选，默认root
            'password' => '19961996', # 必选
            'database' => 'opos_db', # 必选
            'hostport' => '3306', # 可选，默认3306
            'dbms' => 'mysql', # 可选，默认mysql
            'pconnect' => true, # 可选，是否开启长连接，默认false
            'charset' => 'utf8', # 可选
            'DB_DEBUG' => true, # 可选，是否开启DEBUG模式，请在系统上线后关闭DEBUG模式
            // 'MYSQL_LOG' => '/path/to/mysql.log' # 可选，定义mysql的log文件路径，请先确保有读权限
        ],
        "read" => [
            "hostname" => '127.0.0.1', # 可选，默认127.0.0.1
            "username" => 'root', # 可选，默认root
            'password' => '19961996', # 必选
            'database' => 'opos_db', # 必选
            'hostport' => '3306', # 可选，默认3306
            'dbms' => 'mysql', # 可选，默认mysql
            'pconnect' => true, # 可选，是否开启长连接，默认false
            'charset' => 'utf8', # 可选
            'DB_DEBUG' => true, # 可选，是否开启DEBUG模式，请在系统上线后关闭DEBUG模式
            // 'MYSQL_LOG' => '/path/to/mysql.log' # 可选，定义mysql的log文件路径，请先确保有读权限
        ]
    ]
];