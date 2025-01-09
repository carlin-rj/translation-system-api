<?php

declare(strict_types=1);

namespace App\Helpers;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Carbon;

class Arr extends \Illuminate\Support\Arr
{
    /**
     * 递归转驼峰数组
     *
     * @author: whj
     *
     * @date  : 2023/4/14 16:24
     */
    public static function snakeToCamel(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[Str::camel($key)] = self::snakeToCamel($value);
            } else {
                $result[Str::camel($key)] = $value;
            }
        }

        return $result;
    }

    /**
     * 递归转下划线数组
     */
    public static function camelToSnake(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[Str::snake($key)] = self::camelToSnake($value);
            } else {
                $result[Str::snake($key)] = $value;
            }
        }

        return $result;
    }

    public static function toTree(string $parentIdName, string $categoryIdName, array $allNodes, int|string $parentId = 0): array
    {
        $children = [];
        foreach ($allNodes as $node) {
            if ($node[$parentIdName] === $parentId) {
                $child = $node;
                $child['children'] = self::toTree($parentIdName, $categoryIdName, $allNodes, $node[$categoryIdName]); // 递归获取子节点
                $children[] = $child;
            }
        }

        return $children;
    }

    public static function convertTreeToArray(array $tree, array $fields = [], int|string $parentId = 0, array $categoryLink = []): array
    {
        $fields = [
            'parentIdName'     => $fields['parentIdName'] ?? 'parent_id',
            'categoryIdName'   => $fields['categoryIdName'] ?? 'id',
            'childrenName'     => $fields['childrenName'] ?? 'children',
            'categoryLinkName' => $fields['categoryLinkName'] ?? 'category_link',
        ];
        $result = [];
        foreach ($tree as $node) {
            //检查是否有子节点
            $node[$fields['parentIdName']] = $parentId;
            $node[$fields['categoryLinkName']] = $categoryLink;
            ! empty($parentId) && $node[$fields['categoryLinkName']][] = $parentId;

            if (isset($node[$fields['childrenName']])) {
                $children = self::convertTreeToArray($node[$fields['childrenName']], $fields, $node[$fields['categoryIdName']], $node[$fields['categoryLinkName']]);
                $result = [...$result, ...$children];
            }

            $node[$fields['categoryLinkName']][] = $node[$fields['categoryIdName']];
            unset($node[$fields['childrenName']]); // 移除 children 字段
            $result[] = $node;
        }

        return $result;
    }

    public static function getParentPath(string $parentIdName, string $categoryIdName, int|string $childId, array $allNodes): array
    {
        foreach ($allNodes as $category) {
            if ($category[$categoryIdName] === $childId) {
                if ($category[$parentIdName] === 0 || $category[$parentIdName] === '0') {
                    // 已到达顶级分类，返回分类名
                    return [$category[$categoryIdName]];
                }

                // 递归获取父级分类路径
                $parentPath = self::getParentPath($parentIdName, $categoryIdName, $category[$parentIdName], $allNodes);
                // 拼接当前分类名和父级路径
                return [
                    ...$parentPath,
                    $category[$categoryIdName],
                ];
            }
        }
        // 如果未找到子级分类
        return [];
    }

    /**
     * 获取数组中指定的键值
     *
     * @param  bool  $toSnake 是否转换为下划线, 如果$array键为驼峰，而$keys为下划线，则可以设置为true， 返回值为下划线
     */
    public static function getIfKeyExists(array $array, array $keys, bool $toSnake = false, array $setNull = []): array
    {
        $result = [];
        foreach ($keys as $key) {
            $camelKey = $toSnake ? Str::camel($key) : $key;
            if (isset($array[$camelKey])) {
                $result[$key] = $array[$camelKey];
            } elseif (in_array($key, $setNull, true)) {
                $result[$key] = null;
            }
        }

        return $result;
    }

    /**
     * 不区分大小写搜索数组里面的Key, 并返回搜索到的值
     */
    public static function findValueByKey(string $key, array $array): ?string
    {
        $key = strtolower($key);
        foreach ($array as $k => $v) {
            if ($key === strtolower($k)) {
                return $v;
            }
        }

        return null;
    }

    /**
     * 生成时间段。
     *
     * @author: whj
     *
     * @date: 2023/9/15 09:52
     */
    public static function generateDateRanges(int $interval = 1, string $unit = 'month', ?Carbon $start = null, ?Carbon $end = null, string $format = 'Y-m-d H:i:s'): array
    {
        $start = $start ?? now()->subYears(3);
        $end = $end ?? now();
        $ranges = [];

        //@phpstan-ignore-next-line
        while ($start < $end) {
            $next = clone $start;

            switch ($unit) {
                case 'second':
                    $next->addSeconds($interval);
                    break;
                case 'minute':
                    $next->addMinutes($interval);
                    break;
                case 'hour':
                    $next->addHours($interval);
                    break;
                case 'day':
                    $next->addDays($interval);
                    break;
                case 'month':
                default:
                    $next->addMonths($interval);
            }

            // Adjust the next value if it exceeds the end.
            if ($next > $end) {
                break;  // Exit the loop immediately
            }

            $ranges[] = [
                'start' => $start->format($format),
                'end'   => $next->format($format),
            ];

            $start = $next;
        }

        return $ranges;
    }
}
