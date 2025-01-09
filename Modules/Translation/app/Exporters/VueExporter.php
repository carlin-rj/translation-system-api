<?php

namespace Modules\Translation\Exporters;

class VueExporter extends BaseTranslationExporter
{
    protected function handlerExport(string $tempPath): void
    {
        $translations = [];
        $languages = $this->getLanguages();

        // 收集翻译数据
        foreach ($languages as $language) {
            $translations[$language] = [];
            $items = $this->fetchByLanguage($language);

            foreach ($items as $translation) {
                if (str_contains($translation->key, '.')) {
                    // 处理嵌套键值
                    $this->arraySet(
                        $translations[$language],
                        $translation->key,
                        $translation->target_text
                    );
                } else {
                    // 处理普通键值
                    $translations[$language][$translation->key] = $translation->target_text;
                }
            }
        }

        // 生成语言文件
        foreach ($translations as $language => $trans) {
            // 创建语言目录
            $this->ensureDirectoryExists("{$tempPath}/locales");

            // 生成 JS 文件
            $jsContent = $this->generateJsContent($language, $trans);
            $this->putFileContent(
                "{$tempPath}/locales/{$language}.js",
                $jsContent
            );
        }

        // 生成 index.js 文件
        $indexContent = $this->generateIndexFile($languages);
        $this->putFileContent("{$tempPath}/locales/index.js", $indexContent);
    }

    /**
     * 生成语言文件的 JS 内容
     */
    private function generateJsContent(string $language, array $translations): string
    {
        $json = json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return <<<JS
export default {$json}

JS;
    }

    /**
     * 生成 index.js 文件内容
     */
    private function generateIndexFile(array $languages): string
    {
        $imports = [];
        $exports = [];

        foreach ($languages as $lang) {
            $imports[] = "import {$lang} from './{$lang}.js'";
            $exports[] = "  {$lang}";
        }

        return <<<JS
import { createI18n } from 'vue-i18n'

{$this->implodeLines($imports)}

export const i18n = createI18n({
  legacy: false,
  locale: 'zh', // 设置默认语言
  fallbackLocale: 'en', // 设置回退语言
  messages: {
{$this->implodeLines($exports)}
  }
})

export default i18n

JS;
    }

    /**
     * 辅助方法：将数组转换为多行字符串
     */
    private function implodeLines(array $lines): string
    {
        return implode("\n", $lines);
    }
}
