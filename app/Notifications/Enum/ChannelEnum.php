<?php


namespace App\Notifications\Enum;


use App\Enums\BaseEnum;
use App\Notifications\Channel\FeiShuTextChannel;

class ChannelEnum extends BaseEnum
{
	public const DD = "DingDing";
	public const FS = "FeiShu";

	public static function classMap(): array
	{
		return [
			self::FS => FeiShuTextChannel::class
		];
	}
}
