<?php

namespace App\Tools\Http\Response;

use App\Tools\Http\HttpCode;
use Illuminate\Http\JsonResponse;

interface ResponseInterface
{

    /**
     * 设置调试信息
     * @param $debug
     * @return $this
     */
    public function setDebug($debug): self;

	/**
	 * 返回成功
	 *
	 * @param string|null $msg
	 * @param mixed|null $data
	 * @return JsonResponse
	 */
    public function success(?string $msg = null, mixed $data = null): JsonResponse;

	/**
	 * 返回普通数据
	 *
	 * @param null $data
	 * @param string|null $msg
	 * @param string $state
	 * @param int $httpCode
	 * @return JsonResponse
	 */
    public function data(
        $data = null,
        ?string $msg = null,
        string $state = "",
        int $httpCode = HttpCode::HTTP_OK
    ): JsonResponse;

    /**
     * 返回错误
     *
     * @param string|null $msg
     * @param string $state
     * @param int $httpCode
     * @param mixed $data
     * @return JsonResponse
     */
    public function error(string $msg = null, string $state = "", int $httpCode = HttpCode::HTTP_INTERNAL_SERVER_ERROR, mixed $data = null): JsonResponse;
}
