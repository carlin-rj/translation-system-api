<?php

namespace App\Dto;

use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Contracts\TransformableData as TransformableDataContract;


class BaseDto extends Dto implements TransformableDataContract
{
	use TransformableData;

}
