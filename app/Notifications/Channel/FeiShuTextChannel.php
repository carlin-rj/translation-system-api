<?php


namespace App\Notifications\Channel;

use App\Notifications\BaseNotification;
use App\Notifications\Sender\FeiShuTalkMessageSender;

class FeiShuTextChannel extends BaseTalkChannel
{
	/**
	 * @param \App\Notifications\Messages\FeiShuTextMessage $notifiable
	 * @param \App\Notifications\BaseNotification $notification
	 * @return void
	 * @throws \JsonException
	 */
	public function send($notifiable, BaseNotification $notification): void
	{
		if (!config("feishu.enable", false)) {
			return;
		}

		if (!isset($notification->getFeiShuConfig()->token)) {
			return;
		}

		$message = $notification->toFeiShuText($notifiable);

		$sender = new FeiShuTalkMessageSender([
			'token' => $notification->getFeiShuConfig()->token,
		]);

		$sender->send([
			'msg_type' => 'text',
			'content'  => ['text' => $message->message],
		]);
	}
}
