<?php

namespace Modules\Translation\Exporters;

use DOMDocument;

class AndroidExporter extends BaseTranslationExporter
{
    /**
     * Android 语言代码映射
     * 将标准语言代码转换为 Android 使用的语言代码
     */
    private array $languageMapping = [
        'en' => '',           // 默认语言使用 values 目录
        //'zh' => 'zh-rCN',    // 简体中文
        //'zh-TW' => 'zh-rTW', // 繁体中文
        //'ja' => 'ja',        // 日语
        // 可以根据需要添加更多语言映射
    ];

    protected function handlerExport(string $tempPath): void
    {
        $languages = $this->getLanguages();

        foreach ($languages as $language) {
            // 获取 Android 的语言代码
            $androidLang = $this->getAndroidLanguageCode($language);

            // 创建语言资源目录
            $resourceDir = $androidLang
                ? "{$tempPath}/res/values-{$androidLang}"
                : "{$tempPath}/res/values";

            $this->ensureDirectoryExists($resourceDir);

            // 创建 XML 文档
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;

            // 创建根元素
            $resources = $dom->createElement('resources');
            $dom->appendChild($resources);

            // 获取该语言的所有翻译
            $translations = $this->fetchByLanguage($language);

            foreach ($translations as $translation) {
                $stringElement = $dom->createElement('string');

                // 处理 key
                $key = $this->sanitizeKey($translation->key);
                $stringElement->setAttribute('name', $key);

                // 处理翻译文本
                $text = $this->escapeAndroidString($translation->target_text);
                $stringElement->appendChild($dom->createTextNode($text));

                $resources->appendChild($stringElement);
            }

            // 保存 strings.xml 文件
            $this->putFileContent(
                "{$resourceDir}/strings.xml",
                $dom->saveXML()
            );
        }
    }

    /**
     * 获取 Android 的语言代码
     */
    private function getAndroidLanguageCode(string $language): string
    {
        return $this->languageMapping[$language] ?? $language;
    }

    /**
     * 清理 key，确保符合 Android 资源命名规范
     */
    private function sanitizeKey(string $key): string
    {
        // 将点号转换为下划线
        $key = str_replace('.', '_', $key);

        // 移除非法字符，只保留字母、数字和下划线
        $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);

        // 确保不以数字开头
        if (preg_match('/^[0-9]/', $key)) {
            $key = 'str_' . $key;
        }

        return strtolower($key);
    }

    /**
     * 转义 Android 字符串中的特殊字符
     */
    private function escapeAndroidString(string $text): string
    {
        $replacements = [
            '&' => '&amp;',
            '"' => '\\"',
            '\'' => '\\\'',
            '@' => '\\@',
            '?' => '\\?',
            '<' => '&lt;',
            '>' => '&gt;',
            '%s' => '%s',    // 保持格式化占位符不变
            '%d' => '%d',    // 保持格式化占位符不变
            '\n' => '\\n',   // 换行符
            '\r' => '\\r',   // 回车符
            '\t' => '\\t',   // 制表符
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $text
        );
    }
}
