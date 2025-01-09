<?php

namespace App\Notifications;

use App\Helpers\App;
use App\Notifications\Messages\FeiShuTextMessage;
use App\Notifications\Templates\IgnoreExceptionTemplate;

class IgnoreExceptionTalk extends BaseNotification
{
    /**
     * @param  IgnoreExceptionTemplate  $notifiable
     */
    public function toFeiShuText($notifiable): FeiShuTextMessage
    {
        $contents = [];
        $contents[] = $notifiable->title;
        $contents[] = '运行环境：' . App::env();
        $contents[] = '消息内容：' . $notifiable->message;
        $contents[] = '堆栈信息：' . $notifiable->trace;

        $message = new FeiShuTextMessage();
        $message->message = implode("\n", $contents);

        return $message;
    }
}
