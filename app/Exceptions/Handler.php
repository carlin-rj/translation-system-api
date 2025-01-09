<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler
{
    protected array $dontReport = [
        //xx::class,
    ];

    public function __construct(public Exceptions $exceptions) {}


    public function handle(): void
    {
        // 不需要报告的异常
        $this->exceptions->dontReport($this->dontReport);

        //异常附带context
        $this->exceptions->context(fn (Throwable $e, array $context) => $this->withContext($e, $context));

        $this->exceptions->shouldRenderJsonWhen(fn(Request $request, Throwable $e) => $this->shouldReturnJson($request))
            ->render(function (Throwable $e, Request $request) {
                if (! $this->shouldReturnJson($request)) {
                    return null;
                }
				if ($e instanceof AuthenticationException || $e instanceof UnauthorizedHttpException) {
                    throw new UnauthorizedException(
                        ApiCodeEnum::getDescription(ApiCodeEnum::HTTP_UNAUTHORIZED),
						ApiCodeEnum::HTTP_UNAUTHORIZED
                    );
                }

                if ($e instanceof ValidationException) {
                    throw new ParamsException($e);
                }

                if ($e instanceof ThrottleRequestsException) {
                    throw new InvalidRequestException(
						ApiCodeEnum::getDescription(ApiCodeEnum::HTTP_TOO_MANY_REQUESTS),
						ApiCodeEnum::HTTP_TOO_MANY_REQUESTS
                    );
                }

                // //请求方式方法不允许
                if ($e instanceof MethodNotAllowedHttpException) {
                    throw new InvalidRequestException(
                        ApiCodeEnum::getDescription(ApiCodeEnum::HTTP_METHOD_NOT_ALLOWED),
                        ApiCodeEnum::HTTP_METHOD_NOT_ALLOWED
                    );
                }

                if ($e instanceof NotFoundHttpException) {
                    throw new NotFoundException();
                }

                if (! $e instanceof BaseException) {
                    throw new UncaughtException($e);
                }
            });
    }

    /**
     * 附带日志信息
     * @param Throwable $e 异常
     * @param array $context 异常附带的信息
     * @return array [type] [description]
     */
    protected function withContext(Throwable $e, array $context): array
    {
        //$request = app('request');

        try {
            //return !App::runningInConsole() || isset($_SERVER['LARAVEL_OCTANE']) ? [
            //    'userId' => Auth::check() ? Auth::id() : null,
            //    'ip' => $request->ip(),
            //    'requestId' => $request->attributes->get('request_id'),
            //    'requestUrl' => $request->fullUrl(),
            //    'requestMethod' => $request->method(),
            //] : [];
            return [];
        } catch (Throwable $e) {
            return [];
        }
    }

    protected function shouldReturnJson(Request $request): bool
    {
        if ($request->is('api/*')) {
            return true;
        }
        return $request->expectsJson();
    }
}
