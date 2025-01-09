<?php
namespace App\Enums;

use BenSampo\Enum\Enum;
use Carlin\LaravelDict\Dict;

class BaseEnum extends Enum {
    public static function getDescription(mixed $value): string
    {
        return Dict::getDescription(static::class, $value) ?? parent::getDescription($value);
    }

    public static function descriptions(): array
    {
        return Dict::getEnums(static::class);
    }
}
