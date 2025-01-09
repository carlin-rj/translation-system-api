<?php

namespace App\Notifications;

use App\Helpers\App;
use App\Notifications\Messages\FeiShuTextMessage;
use App\Notifications\Templates\QueueFailedTemplate;

class QueueFailedTalk extends BaseNotification
{
    /**
     * @param QueueFailedTemplate $notifiable
     */
    public function toFeiShuText($notifiable): FeiShuTextMessage
    {
        $contents = [];
        $contents[] = $notifiable->title;
        $contents[] = '队列名称：' . $notifiable->taskName;
        $contents[] = 'uuid：' . $notifiable->uuid;
        $contents[] = 'job-id：' . $notifiable->jobId;
        $contents[] = '队列标签：' . $notifiable->tags;
        $contents[] = '运行环境：' . App::env();
        $contents[] = '消息内容：' . $notifiable->message;
        $contents[] = '堆栈信息：' . $notifiable->trace;
        $message = new FeiShuTextMessage();
        $message->message = implode("\n", $contents);
        return $message;
    }
}
