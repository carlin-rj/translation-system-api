<?php

namespace App\Notifications\Templates;

class QueueFailedTemplate
{
    /** @var string 标题 */
    public string $title = '';

    /** @var string 任务名称 */
    public string $taskName = '';

    /** @var string tags */
    public string $tags = '';

    /** @var null|string 消息内容 */
    public ?string $message = null;

    public ?string  $jobId = null;

    public ?string $uuid = null;

    /** @var null|string 堆栈信息 */
    public ?string $trace = null;
}
