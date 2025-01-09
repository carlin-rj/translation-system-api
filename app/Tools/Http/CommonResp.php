<?php
namespace App\Tools\Http;

class CommonResp
{
    /** @var string 状态编号, */
    public string $state;

    /** @var string|null 消息 */
    public ?string $msg;

    ///** @var 错误消息集合 */
    //public array $errors = [];

    public ?DebugResp $debug;

    /** @var array|null|mixed 数据 */
    public mixed $data = null;

    public string|null $request_id = null;
}
