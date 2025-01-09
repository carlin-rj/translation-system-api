<?php

use App\Exceptions\Handler as ExceptionHandler;
use App\Console\Handler as ConsoleHandler;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        (new ConsoleHandler())->handle($schedule);
    })
    ->withMiddleware(function (Middleware $middleware) {
        //根据配置处理请求和响应参数(驼峰转下划线/下划线转驼峰)
        $middleware->alias([
            'formatApiResponse'=>\Carlin\LaravelDataSwagger\Middleware\FormatApiResponse::class
        ]);

        //添加请求ID
        $middleware->api(\App\Http\Middleware\RequestIdMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        (new ExceptionHandler($exceptions))->handle();
    })->create();
