<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use App\Tools\Http\HttpCode;

class NotFoundException extends BaseException
{
    public function __construct($message = null, $code = ApiCodeEnum::HTTP_NOTFOUND)
    {
        $message =  $message ?? ApiCodeEnum::getDescription($code);
        parent::__construct($message, $code, null,HttpCode::HTTP_NOT_FOUND);
    }
}
