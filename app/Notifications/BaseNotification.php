<?php

namespace App\Notifications;

use App\Notifications\Bean\FeiShuConfig;
use App\Notifications\Channel\FeiShuTextChannel;
use App\Notifications\Messages\FeiShuTextMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification
{
	/** @var \App\Notifications\Bean\FeiShuConfig|null 飞书配置 */
	protected ?FeiShuConfig $feiShuConfig = null;


	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(?FeiShuConfig $feiShuConfig = null)
	{
		$this->feiShuConfig = $feiShuConfig;
	}

	/**
	 * @return \App\Notifications\Bean\FeiShuConfig|null
	 */
	public function getFeiShuConfig(): ?FeiShuConfig
	{
		return $this->feiShuConfig;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		$channels = [];
		isset($this->feiShuConfig->enable) && $this->feiShuConfig->enable && $channels[] = FeiShuTextChannel::class;
		return $channels;
	}

	//@phpstan-ignore-next-line
	public function toFeiShuText($notifiable): FeiShuTextMessage
	{
		return $notifiable;
	}

}
