<?php

namespace App\Tools\Http\Response;

use App\Enums\ApiCodeEnum;
use App\Tools\Http\CommonResp;
use App\Tools\Http\HttpCode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

abstract class BaseResponse implements ResponseInterface
{
    /**
     * @var mixed 调试信息
     */
    protected mixed $debug = null;

    /** @var mixed 响应数据 */
    protected mixed $data;


    /**
     * 设置debug信息
     * @param mixed $debug
     * @return $this
     * @author: whj
     * @date: 2023/3/31 15:13
     */
    public function setDebug(mixed $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * 返回成功
     *
     * @param string|null $msg
     * @param mixed|null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(?string $msg = null, mixed $data = null): JsonResponse
    {
        return $this->data($data, $msg);
    }

    /**
     * @param mixed $data
     * @param string|null $msg
     * @return \Illuminate\Http\JsonResponse
     * @author: whj
     * @date: 2023/3/31 15:11
     */
    public function successForResource(mixed $data, ?string $msg = null): JsonResponse
    {
        return $this->data($data, $msg);
    }

    /**
     * @param mixed $data
     * @param string|null $msg
     * @return \Illuminate\Http\JsonResponse
     * @author: whj
     * @date: 2023/3/31 15:11
     */
    public function successForResourcePage(mixed $data, ?string $msg = null): JsonResponse
    {
        return $this->data([
                'list'    => $data instanceof LengthAwarePaginator ? $data->items() : $data,
                'total'   => $data instanceof LengthAwarePaginator ? $data->total() : 0,
            ], $msg);
    }

    /**
     * @param mixed $data
     * @param string $groupBy
     * @param string|null $msg
     * @return \Illuminate\Http\JsonResponse
     * @author: whj
     * @date: 2023/3/31 15:12
     */
    public function successForResourcePageAndGroupBy(mixed $data, string $groupBy, ?string $msg = null): JsonResponse
    {
        return $this->data([
            'list'    => $data->groupBy($groupBy)->map(function ($item, $key) use ($groupBy) {
                return [
                    $groupBy => $key,
                    'list'   => $item
                ];
            })->values(),
            'total'   => $data->total(),
        ], $msg);
    }

    /**
     * 返回普通数据
     *
     * @param mixed $data
     * @param string|null $msg
     * @param string $state
     * @param int $httpCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(
        $data = null,
        ?string $msg = null,
        string $state = ApiCodeEnum::SUCCESS,
        int $httpCode = HttpCode::HTTP_OK
    ): JsonResponse
    {
        $resp        = new CommonResp();
		$resp->msg   = $msg ?? ApiCodeEnum::getDescription($state);
		$resp->state = $state;
        $resp->data  = $data;
        $resp->request_id  = request()->header('X-Request-Id');
        if (! app()->environment(['production'])) {
            $resp->debug = $this->debug;
        }
        return response()->json($resp, $httpCode, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * 返回错误
     *
     * @param string|null $msg
     * @param string $state
     * @param int $httpCode
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(?string $msg = null, string $state = ApiCodeEnum::HTTP_BAD_REQUEST, int $httpCode = HttpCode::HTTP_INTERNAL_SERVER_ERROR, $data = null): JsonResponse
    {
        return $this->data($data, $msg, $state, $httpCode);
    }
}
