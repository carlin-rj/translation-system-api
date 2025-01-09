<?php

namespace App\Notifications\Templates;

class ConsoleExceptionTemplate
{
    /** @var string 标题 */
    public string $title = '';

    /** @var string 消息内容 */
    public string $message = '';

    /** @var string|null 堆栈信息 */
    public ?string $trace = null;
}
