<?php


namespace App\Notifications\Messages;

use App\Notifications\Enum\LevelEnum;

class TalkMessage
{
	/** @var string 通知等级 */
	public string $level = LevelEnum::URGENT;

	public string $title = "";

	/** @var string 消息内容 */
	public string $message = "";

	public function __construct(string $level, string $message)
	{
		$this->level   = $level;
		$this->message = $message;
	}

}
