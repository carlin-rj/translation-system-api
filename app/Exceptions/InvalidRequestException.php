<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use App\Tools\Http\HttpCode;

class InvalidRequestException extends BaseException
{
	public function __construct($message, $code = ApiCodeEnum::HTTP_BAD_REQUEST, mixed $data = null, int $httpCode = HttpCode::HTTP_OK)
	{
		parent::__construct($message, $code, $data, $httpCode);
	}
}
