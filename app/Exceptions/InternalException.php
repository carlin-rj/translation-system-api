<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;

class InternalException extends BaseException
{
	public function __construct($message, $code = ApiCodeEnum::HTTP_INTERNAL_SERVER_ERROR)
	{
		parent::__construct($message, $code);
	}

	/**
	 * 自定义客户端显示错误请重写这个方法
	 * @return string|null
	 * @author: whj
	 * @date: 2023/3/31 9:27
	 */
	public function getMsgToUser(): ?string
	{
		return '系统内部错误';
	}
}
