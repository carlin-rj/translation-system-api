<?php

namespace App\Helpers;

/**
 * Class Str
 *
 * @mixin \Illuminate\Support\Str
 */
class Str extends \Illuminate\Support\Str
{
    public static function isOssUrl(string $url): bool
    {
        return str_contains($url, config('filesystems.disks.oss.url')) || str_contains($url, config('filesystems.disks.oss.bucket')) || str_contains($url, 'https://yuancang-file-hkoss-accelerate.aliyuncs.com');
    }

    /**
     * 是否为空字符串
     */
    public static function isEmpty(?string $str, bool $placeSpace = false): bool
    {
        return $str === null || $str === '' || ($placeSpace && trim($str) === '');
    }

    /**
     * 根据命名空间的类获取类名
     */
    public static function getClassName(string $classNamespaceName): string
    {
        return substr($classNamespaceName, strrpos($classNamespaceName, '\\') + 1);
    }

    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     *
     * @param  string  $value
     */
    public static function camel($value, bool $lcFirst = true): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));

        return $lcFirst ? lcfirst($str) : ucfirst($str);
    }

    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     *
     * @param  string  $value
     * @param  string  $delimiter
     */
    public static function snake($value, $delimiter = '_'): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1' . $delimiter . '$2', $value));
    }

    /**
     * 检测是否是中英混合字符
     *
     * @author: whj
     *
     * @date: 2023/5/12 14:10
     */
    public static function isChineseEnglishMix(string $str): bool
    {
        $chinese_pattern = '/[\\x{4e00}-\\x{9fa5}]/u';
        $english_pattern = '/[a-zA-Z]/';
        $has_chinese = preg_match($chinese_pattern, $str);
        $has_english = preg_match($english_pattern, $str);

        return $has_chinese && $has_english;
    }

    /**
     * 验证字符是否是中文、英文、数字、标点符号、空格
     *
     * @author: whj
     *
     * @date: 2023/5/16 14:12
     */
    public static function isValidText(string $str): bool
    {
        return preg_match('/^[a-zA-Z0-9\x{4e00}-\x{9fa5}\p{Han}\p{Latin}\p{Nd}\p{P}\p{Zs}\p{M}\p{S}]+$/u', $str);
    }

    /**
     * 获取中文字符长度
     *
     * @author: whj
     *
     * @date: 2023/5/16 17:21
     */
    public static function getChineseLen(string $str): int
    {
        preg_match_all('/[\x{4e00}-\x{9fa5}]/u', $str, $zhChars);

        return count($zhChars[0] ?? []);
    }

    public static function tabSpace(int $num = 1): string
    {
        return str_repeat(' ', $num * 4);
    }
}
