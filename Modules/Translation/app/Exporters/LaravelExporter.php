<?php

namespace Modules\Translation\Exporters;

class LaravelExporter extends BaseTranslationExporter
{
	protected function handlerExport(string $tempPath): void
	{
		$jsonTranslations = [];
		$phpTranslations = [];
		$languages = $this->getLanguages();

		// 收集翻译数据
		foreach ($languages as $language) {
			$translations = $this->fetchByLanguage($language);
			foreach ($translations as $translation) {
				if ($translation->key === $translation->source_text) {
					$jsonTranslations[$language][$translation->key] = $translation->target_text;
				} else if (str_contains($translation->key, '.')) {
					$parts = explode('.', $translation->key);
					$fileName = array_shift($parts);
					$this->arraySet($phpTranslations[$language][$fileName], implode('.', $parts), $translation->target_text);
				}
			}
		}

		// 生成 JSON 文件
		foreach ($jsonTranslations as $language => $trans) {
			$this->putFileContent(
				"{$tempPath}/{$language}.json",
				json_encode($trans, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
			);
		}

		// 生成 PHP 文件
		foreach ($phpTranslations as $language => $files) {
			foreach ($files as $fileName => $trans) {
				$languagePath = "{$tempPath}/{$language}";
				$this->ensureDirectoryExists($languagePath);

				$content = "<?php\n\nreturn " . var_export($trans, true) . ";\n";
				$this->putFileContent("{$languagePath}/{$fileName}.php", $content);
			}
		}
	}
}
