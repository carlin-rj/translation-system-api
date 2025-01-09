<?php

namespace App\Facades;

use App\Tools\Http\Response\ResponseInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Tools\Http\ApiResponse setDebug(mixed $debug)
 * @method static \Illuminate\Http\JsonResponse success(string|null $msg = null, mixed|null $data = null)
 * @method static \Illuminate\Http\JsonResponse successForResource(mixed $data, string|null $msg = null)
 * @method static \Illuminate\Http\JsonResponse successForResourcePage(mixed $data, string|null $msg = null)
 * @method static \Illuminate\Http\JsonResponse successForResourcePageAndGroupBy(mixed $data, string $groupBy, string|null $msg = null)
 * @method static \Illuminate\Http\JsonResponse data(mixed $data = null, string|null $msg = null, string $state = '000001', int $httpCode = 200)
 * @method static \Illuminate\Http\JsonResponse error(string|null $msg = null, string $state = '000400', int $httpCode = 500, null $data = null)
 *
 * @see \App\Tools\Http\ApiResponse
 */
class ApiResponse extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return ResponseInterface::class;
    }
}
