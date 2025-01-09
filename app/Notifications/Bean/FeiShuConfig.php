<?php

namespace App\Notifications\Bean;

use Spatie\LaravelData\Data;

class FeiShuConfig extends Data
{
	public ?bool $enable = null;

	public ?string $token = null;
}
