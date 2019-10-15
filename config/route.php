<?php

return [
    "/test/test" => [
        "action" => "TestController::test",
        "middleware" => "",
        "permissions" => [],
    ],
    "/test/test2" => [
        "action" => "TestController::test2",
        "middleware" => "NeedLogin",
        "permissions" => [],
    ],
    "/test/test3" => [
        "action" => "TestController::test3",
        "middleware" => "",
        "permissions" => [],
    ]
];