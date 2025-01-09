<?php

declare(strict_types=1);

namespace App\Enums;

enum CacheKey: string
{
    case COMMON_DICT = 'common:dict';

    public function ttl(): int
    {
        return match ($this) {
            self::COMMON_DICT => 60 * 60 * 24 * 30,
        };
    }

    public function format(mixed ...$args): string
    {
        return sprintf($this->value, ...$args);
    }
}
