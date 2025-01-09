<?php
namespace App\Exceptions;


class UncaughtException extends BaseException
{
	public function __construct(\Throwable $e)
	{
		parent::__construct($e);

		//在此记录日志信息
		//记录致命异常日志, 不能放在Report方法里, PHP语法解析错误不会进入Report方法中
		//记录完整请求日志，内存溢出等错误不会被记录到webapi.log里
		//Logger::uncaught()->error(App::getExceptionContent($e), [
		//    'user'     => UserHandler::getUserFromContainer(),
		//    'request'  => [
		//        'url'      => \Request::url(),
		//        'path'     => \Request::path(),
		//        'method'   => \Request::method(),
		//        'header'   => \Request::header(),
		//        'ip'       => zt_get_ip(),
		//        'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
		//        'params'   => \Request::input(),
		//    ],
		//    'response' => [
		//        'status_code' => $this->getHttpCode(),
		//        'result'      => $this->getMessage(),
		//    ],
		//]);

		//飞书异常通知
	}

	public function report()
	{
		//飞书异常通知
		//$this->notify();
	}

	/**
	 * 自定义客户端显示错误请重写这个方法
	 * @return string|null
	 * @author: whj
	 * @date: 2023/3/31 9:27
	 */
	public function getMsgToUser(): ?string
	{
		return "系统内部错误";
	}

	public function __toString(): string
	{
		return $this->sourceException->__toString();
	}
}
