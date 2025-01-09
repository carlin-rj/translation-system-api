<?php

namespace App\Helpers;

class App
{
    /**
     * 是否是调试模式
     */
    public static function isDebug(): bool
    {
        return (bool) config('app.debug', false);
    }

    public static function env(): string
    {
        return config('app.env', 'production');
    }

    /**
     * 是否是线上环境
     */
    public static function isProduction(): bool
    {
        return config('app.env', 'production') === 'production';
    }

    public static function isLocal(): bool
    {
        return config('app.env', 'production') === 'local';
    }

    public static function isTest(): bool
    {
        return config('app.env', 'production') === 'test';
    }

    /**
     * Formats bytes into a human readable string if $this->useFormatting is true, otherwise return $bytes as is
     *
     * @return string Formatted string if $this->useFormatting is true, otherwise return $bytes as int
     */
    public static function formatBytes(int $bytes): string
    {
        if ($bytes > 1024 * 1024) {
            return round($bytes / 1024 / 1024, 2) . ' MB';
        }

        if ($bytes > 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    public static function getExceptionContent(\Throwable $e, int $maxLine = 10): string
    {
        $data = explode("\n", $e->__toString(), $maxLine + 1);
        count($data) > 1 && array_pop($data);

        return implode(PHP_EOL, $data);
    }
}
