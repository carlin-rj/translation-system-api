<?php

namespace App\Exceptions;

use App\Enums\ApiCodeEnum;
use App\Facades\ApiResponse;
use App\Notifications\AppExceptionTalk;
use App\Notifications\Bean\FeiShuConfig;
use App\Notifications\Enum\LevelEnum;
use App\Notifications\Templates\AppExceptionTemplate;
use App\Tools\Http\DebugResp;
use App\Tools\Http\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use RuntimeException;
use Throwable;

abstract class BaseException extends RuntimeException
{
    protected ?Throwable $sourceException = null;

    protected int $httpCode;

    protected mixed $data = null;

    /** @phpstan-ignore-next-line  */
    public function __construct(mixed $message, string $apiCode = ApiCodeEnum::HTTP_INTERNAL_SERVER_ERROR, mixed $data = null, int $httpCode = HttpCode::HTTP_INTERNAL_SERVER_ERROR)
    {
        if ($message instanceof Throwable) {
            $this->sourceException = $message;
            $message = $message->getMessage();
        }

        /** @phpstan-ignore-next-line  */
        parent::__construct($message, $apiCode, $this->sourceException ?? null);
        $this->httpCode = $httpCode;
        $this->data = $data;
    }

    public function render(): JsonResponse
    {
        $debug = $this->getDebug();

        return ApiResponse::setDebug($debug)->error($this->getMsgToUser() ?: $this->getMessage(), (string) $this->getCode(), $this->httpCode, $this->data);
    }

    /**
     * 自定义客户端显示错误请重写这个方法
     *
     * @author: whj
     *
     * @date: 2023/3/31 9:27
     */
    public function getMsgToUser(): ?string
    {
        return $this->getMessage();
    }

    protected function getDebug(): DebugResp
    {
        $debug = new DebugResp();
        if ($this->sourceException) {
            $debug->message = $this->sourceException->getMessage();
            $debug->code = $this->sourceException->getCode();
            $debug->file = $this->sourceException->getFile();
            $debug->line = (string) $this->sourceException->getLine();
            $debug->trace = $this->sourceException->getTraceAsString();
        } else {
            $debug->message = $this->getMessage();
            $debug->code = (string) $this->getCode();
            $debug->file = $this->getFile();
            $debug->line = (string) $this->getLine();
            $debug->trace = $this->getTraceAsString();
        }

        return $debug;
    }

    /**
     * 飞书异常通知
     */
    protected function notify(): void
    {
        $template = new AppExceptionTemplate();
        $template->title = '【系统异常通知】';
        $template->functionUri = Request::getRequestUri();
        $template->message = $this->getDebug()->message ?? '';
        $template->exceptionType = class_basename(static::class);
        $template->trace = substr($this->getDebug()->trace, 0, 2000);

        /** @var FeiShuConfig|null $feishuConfig */
        $feishuConfig = FeiShuConfig::from(Config::array('feishu.' . LevelEnum::URGENT));
        Notification::send($template, new AppExceptionTalk($feishuConfig));
    }
}
