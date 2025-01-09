<?php


namespace App\Notifications\Templates;

use App\POPO\UserPO;

class AppExceptionTemplate
{
	/** @var string 标题 */
	public string $title = '';

	/** @var string 功能路径 */
	public string $functionUri = '';

	/** @var string 异常类型 */
	public string $exceptionType = '';

	/** @var string 消息内容 */
	public string $message = '';

	/** @var string|null 堆栈信息 */
	public ?string $trace = null;

}
