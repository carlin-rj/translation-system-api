<?php

namespace App\Exceptions;

use App\Tools\Http\HttpCode;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueFailException extends BaseException
{
    public function __construct(mixed $message, mixed $source = null, $httpCode = HttpCode::HTTP_OK)
    {
        parent::__construct($message, httpCode:$httpCode);

        //将队列直接标记失败不再重试
        if ($source instanceof ShouldQueue) {
            $source->fail($this);
        }
    }
}
