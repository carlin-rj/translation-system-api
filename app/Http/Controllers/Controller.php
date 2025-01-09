<?php

namespace App\Http\Controllers;

use OpenApi\Attributes\Info;
use OpenApi\Attributes\OpenApi;
use OpenApi\Attributes\Server;

#[OpenApi(
    info: new Info(version: '1.0', title: '翻译管理系统'),
    servers: [
        new Server(url: 'https://dev.test.com', description: '开发环境'),
        new Server(url: 'https://test.test.com', description: '测试环境'),
        new Server(url: 'https://api.test.com', description: '生产环境'),
    ]
)]
abstract class Controller
{
    //
}
