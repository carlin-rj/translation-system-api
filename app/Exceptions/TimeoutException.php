<?php
namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use App\Tools\Http\HttpCode;

class TimeoutException extends BaseException
{

    public function __construct($message = "", $apiCode =  ApiCodeEnum::HTTP_BAD_REQUEST, $httpCode = HttpCode::HTTP_OK)
    {
        parent::__construct($message, $apiCode, $httpCode);
    }

    public function getMsgToUser(): string
    {
        return '系统超时请重试!';
    }
}
