<?php

namespace App\Providers;

use App\Exceptions\QueueFailException;
use App\Helpers\App;
use App\Notifications\Bean\FeiShuConfig;
use App\Notifications\Enum\LevelEnum;
use App\Notifications\QueueFailedTalk;
use App\Notifications\Templates\QueueFailedTemplate;
use App\Tools\Http\Response\ApiResponse;
use App\Tools\Http\Response\ResponseInterface;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ResponseInterface::class, function () {
            return new ApiResponse();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 打印sql语句
        if (app()->environment(['local', 'testing'])) {
            Event::listen(QueryExecuted::class, static function ($event) {
                if (str_contains($event->sql, 'telescope')) {
                    return;
                }
                $sql = $event->sql;
                $bindings = $event->bindings;

                // 替换 SQL 中的 ? 占位符为绑定参数的值
                $pdo = $event->connection->getPdo();
                $sql = vsprintf(str_replace('?', '%s', $sql), array_map([$pdo, 'quote'], $bindings));
                //@phpstan-ignore-next-line
                dump("SQL: {$sql}");

            });
        }

        //队列事件监听
        $this->queueListen();
    }

    private function queueListen(): void
    {
        // 队列失败事件
        Queue::failing(static function (JobFailed $event) {
            // 已知队列错误不发送通知
            if ($event->exception instanceof QueueFailException) {
                return;
            }

            $template = new QueueFailedTemplate();
            $template->title = '【队列失败通知】';
            $template->jobId = $event->job->getJobId();
            $template->uuid = $event->job->uuid();
            $template->taskName = $event->job->getQueue();
            $template->tags = implode(',', $event->job->payload()['tags'] ?? []);
            $template->message = $event->exception->getMessage();
            $template->trace = App::getExceptionContent($event->exception, 50);
            /** @var FeiShuConfig|null $feishuConfig */
            $feishuConfig = FeiShuConfig::from(Config::array('feishu.' . LevelEnum::URGENT));
            Notification::send($template, new QueueFailedTalk($feishuConfig));
        });

        /****************确保job中可以获取到相关数据******************/
        //将数据添加到队列参数中
        //Queue::createPayloadUsing(static function ($connection, $queue, $payload) {
        //    $data = [
        //        'X-Request-Id' => request()->header('X-Request-Id'),
        //    ];
        //
        //    return $data;
        //});
        ////将消费时将x-request-id添加到request对象中
        //Queue::before(static function (JobProcessing $event) {
        //    $uid = $event->job->payload()['X-Request-Id'] ?? null;
        //    if ($uid) {
        //        // 将 UID 设置为 X-Request-Id 请求头
        //        request()->headers->set('X-Request-Id', $uid);
        //    }
        //});
    }
}
