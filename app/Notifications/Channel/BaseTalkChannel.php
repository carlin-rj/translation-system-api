<?php


namespace App\Notifications\Channel;

use App\Notifications\BaseNotification;

abstract class BaseTalkChannel
{
	/**
	 * @param $notifiable
	 * @param \App\Notifications\BaseNotification $notification
	 * @return void
	 */
	abstract public function send($notifiable, BaseNotification $notification): void;
}
