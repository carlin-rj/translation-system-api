<?php

namespace Modules\Translation\Exporters;

use Modules\Translation\Enums\ExportTypeEnum;

class ExportFactory
{
	public static function make(string $platform, string $projectKey): BaseTranslationExporter
	{
		return match ($platform) {
			ExportTypeEnum::LARAVEL => new LaravelExporter($projectKey),
			ExportTypeEnum::VUE_I18N => new VueExporter($projectKey),
			ExportTypeEnum::ANDROID => new AndroidExporter($projectKey),
			ExportTypeEnum::IOS => new IosExporter($projectKey),
			default => throw new \InvalidArgumentException("Unsupported platform: {$platform}"),
		};
	}
}
