<?php

namespace Modules\Translation\Exporters;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Modules\Translation\Enums\TranslationStatusEnum;
use Modules\Translation\Models\Translation;
use ZipArchive;

abstract class BaseTranslationExporter
{
	protected string $project_key;
	protected string $exportPath = 'export_translations';

	public function __construct(string $projectKey)
	{
		$this->project_key = $projectKey;
	}

	/**
	 * 查询语言数据
	 * @author: whj
	 * @date: 2025/1/6 上午9:42
	 */
	public function getLanguages(): array
	{
		return Translation::query()->select('language')
			->where('project_key', $this->project_key)
			->where('status', TranslationStatusEnum::COMPLETED)
			->groupBy('language')
			->pluck('language')
			->toArray();

	}

	/**
	 * @param string $language
	 * @return LazyCollection<int, Translation>
	 * @author: whj
	 * @date: 2025/1/6 上午10:02
	 */
	public function fetchByLanguage(string $language): LazyCollection
	{
		return Translation::query()
			->where('project_key', $this->project_key)
			->where('language', $language)
			->where('status', TranslationStatusEnum::COMPLETED)
			->lazyById();
	}

	/**
	 * 创建临时目录
	 */
	protected function createTempDirectory(): string
	{
		$tempPath = $this->exportPath . '/temp_' . $this->project_key . '_' . uniqid();
		Storage::makeDirectory($tempPath);
		return $tempPath;
	}

	/**
	 * 创建并返回ZIP文件路径
	 */
	protected function createZipArchive(string $sourcePath): string
	{
		$zipName = "translation_{$this->project_key}.zip";
		$zipPath = "{$this->exportPath}/{$zipName}";

		// 确保导出目录存在
		Storage::makeDirectory($this->exportPath);

		$zip = new ZipArchive();
		$zip->open(Storage::path($zipPath), ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// 获取源目录中的所有文件
		$files = Storage::allFiles($sourcePath);

		foreach ($files as $file) {
			$relativePath = str_replace($sourcePath . '/', '', $file);
			$zip->addFile(
				Storage::path($file),
				$relativePath
			);
		}

		$zip->close();
		return $zipPath;
	}

	/**
	 * 处理导出流程的通用逻辑
	 */
	public function export(): string
	{
		$tempPath = $this->createTempDirectory();

		try {
			// 执行具体的文件处理逻辑
			$this->handlerExport($tempPath);

			// 创建ZIP文件
			$zipPath = $this->createZipArchive($tempPath);

			return Storage::path($zipPath);
		} finally {
			// 清理临时目录
			//Storage::deleteDirectory($tempPath);
		}
	}

	/**
	 * 写入文件内容
	 */
	protected function putFileContent(string $path, string $content): void
	{
		Storage::put($path, $content);
	}

	/**
	 * 确保目录存在
	 */
	protected function ensureDirectoryExists(string $path): void
	{
		Storage::makeDirectory($path);
	}

	/**
	 * 处理文件逻辑
	 * @param string $tempPath
	 * @author: whj
	 * @date: 2025/1/6 上午11:06
	 */
	abstract protected function handlerExport(string $tempPath): void;


	/**
     * 辅助方法：设置嵌套数组值
     */
    protected function arraySet(&$array, $key, $value): void
    {
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
    }
}
