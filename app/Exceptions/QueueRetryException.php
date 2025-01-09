<?php

namespace App\Exceptions;

use App\Tools\Http\HttpCode;

class QueueRetryException extends BaseException
{
    private int $delay;

    public function __construct(int $delay = 0, string $message = 'queue retry', $httpCode = HttpCode::HTTP_OK)
    {
        parent::__construct($message, httpCode:$httpCode);

        $this->delay = $delay;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
