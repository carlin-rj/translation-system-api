<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use App\Tools\Http\HttpCode;

class UnauthorizedException extends BaseException
{
	public function __construct($message, $code = ApiCodeEnum::HTTP_UNAUTHORIZED, mixed $data = null, int $httpCode =  HttpCode::HTTP_OK)
	{
		parent::__construct($message, $code, $data, $httpCode);
	}
}
