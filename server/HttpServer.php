<?php

namespace Server;

require DIR . '/utils/ConfGet.php';
require DIR . '/app/Libraries/HttpDistribute.php';

use App\Libraries\HttpDistribute;
use App\Libraries\Request;
use App\Libraries\Response;
use Exception;
use Utils\ConfGet;

class HttpServer
{
    private $server;

    public function __construct()
    {
        try {
            // 开启服务
            $this->server = new \Swoole\Http\Server(ConfGet::get('server.HTTP.ip'), ConfGet::get('server.HTTP.port'));
        } catch (Exception $e) {
            var_export($e);
            exit();
        }

        $this->server->set([
            'enable_static_handler' => ConfGet::get('server.HTTP.enable_static_handler'),
            'document_root' => ConfGet::get('server.HTTP.document_root'),
            'max_conn' => ConfGet::get('server.HTTP.max_conn'),
            'daemonize' => ConfGet::get('server.HTTP.daemonize'),
            'reactor_num' => ConfGet::get('server.HTTP.reactor_num'),
            'worker_num' => ConfGet::get('server.HTTP.worker_num'),
            'max_request' => ConfGet::get('server.HTTP.max_request'),
            'log_file' => ConfGet::get('server.HTTP.log_file'),
        ]);

        $this->server->on('Start', function ($serv) {
            // 设置进程名
            echo "Start\n";
            @swoole_set_process_name("reload_master");
            //@cli_set_process_title("reload_master");
        });

        $this->server->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
            if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
                return $response->end();
            }
            // 很重要，$request，$response
            Request::setInstance($request);
            Response::setInstance($response);
            (new HttpDistribute())->run();
        });

        $this->server->on('WorkerStart', function ($serv, $worker_id) {
            // 框架主动加载入口，放此处支持热更新
            require DIR . '/autoload/autoload_target.php';
        });
    }

    public function start()
    {
        $this->server->start();
    }
}