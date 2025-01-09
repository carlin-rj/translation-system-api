<?php

namespace App\Notifications;

use App\Helpers\App;
use App\Notifications\Messages\FeiShuTextMessage;
use App\Notifications\Templates\AppExceptionTemplate;

class AppExceptionTalk extends BaseNotification
{
    /**
     * @param  AppExceptionTemplate  $notifiable
     */
    public function toFeiShuText($notifiable): FeiShuTextMessage
    {
        $ips = request()->getClientIps();
        $contents = [];
        $contents[] = $notifiable->title;
        $contents[] = '请求ID：'.(request()->header('X-Request-Id') ?? '');
        $contents[] = '运行环境：'.App::env();
        $contents[] = '异常类型：'.$notifiable->exceptionType;
        //$contents[] = '客户ID：'.($notifiable->user->customerId ?? null);
        //$contents[] = '客户代码：'.($notifiable->user->customerCode ?? '');
        //$contents[] = '用户ID：'.($notifiable->user->userId ?? null);
        $contents[] = '请求地址：'.$notifiable->functionUri;
        $contents[] = '消息内容：'.$notifiable->message;
        $contents[] = '堆栈信息：'.$notifiable->trace;
        $contents[] = 'IP：'.($ips[count($ips) - 1] ?? 'unknown');

        $message = new FeiShuTextMessage();
        $message->message = implode("\n", $contents);

        return $message;
    }
}
