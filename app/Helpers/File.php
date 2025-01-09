<?php

namespace App\Helpers;

use App\Exceptions\InvalidRequestException;

class File extends \Illuminate\Support\Facades\File
{
    /**
     * 获取指定目录下的所有控制器的类名
     *
     * @param string $dir     扫描目录
     * @param array  $ignores 要忽略的控制器, 使用Str:is()规则, 比如App\Http\Controllers\Auth\*PasswordController
     */
    public static function getControllers(string $dir, array $ignores = []): array
    {
        return self::getClasses($dir, $ignores, 'Controller.php');
    }

    /**
     * 获取指定目录下的所有枚举的类名
     *
     * @param string $dir     扫描目录
     * @param array  $ignores 要忽略的枚举, 使用Str:is()规则, 比如:App\Enums\BaseEnum
     */
    public static function getEnums(string $dir, array $ignores = []): array
    {
        return self::getClasses($dir, $ignores, '*Enum*.php', '');
    }

    /**
     * 获取指定目录下的所有公共配置
     *
     * @param string $dir       扫描目录
     * @param string $baseClass 父类的类名
     * @param array  $ignores   要忽略的文件, 使用Str:is()规则, 比如:App\Configs\BaseAttachmentRule
     */
    public static function getConfigs(string $dir, string $baseClass, array $ignores = []): array
    {
        return self::getClasses($dir, $ignores, '', $baseClass);
    }

    /**
     * 获取指定目录下的所有实体
     *
     * @param string $dir     扫描目录
     * @param array  $ignores 要忽略的文件, 使用Str:is()规则, 比如:App\Configs\BaseAttachmentRule
     */
    public static function getEntities(string $dir, array $ignores = []): array
    {
        return self::getClasses($dir, $ignores, 'Entity.php', 'BaseEntity');
    }

    /**
     * 获取指定目录下的所有的类名
     *
     * @param string $dir          扫描目录
     * @param array  $ignores      要忽略的控制器, 使用Str:is()规则, 比如App\Http\Controllers\Auth\*PasswordController
     * @param string $suffix       指定后缀, 比如Controller, Enums
     * @param string $extendsClass 指定继承, 比如BaseEnum
     */
    public static function getClasses(string $dir, array $ignores = [], string $suffix = '', string $extendsClass = ''): array
    {
        $classes = [];
        $classFiles = \Illuminate\Support\Facades\File::allFiles($dir);
        foreach ($classFiles as $classFile) {
            $filename = $classFile->getFilename();
            // 指定后缀, 比如Controller, Enums
            if ($suffix && ! fnmatch($suffix, $filename, FNM_CASEFOLD)) {
                continue;
            }

            // 解析文件名[DemoController]和命名空间[App\Http\Controllers]并组装成完整类名
            $className = strstr($filename, '.php', true);
            $content = $classFile->getContents();

            if (! preg_match('/namespace (.*?);/', $content, $matches)) {
                continue;
            }

            // 是否继承于$extendsClass类
            if ($extendsClass && ! preg_match("/extends {$extendsClass}/", $content)) {
                continue;
            }

            $namespace = trim($matches[1]);
            $class = $namespace . '\\' . $className;
            if (Str::is($ignores, $class)) {
                continue;
            }

            $classes[] = $class;
        }

        return $classes;
    }

    /**
     * 递归删除目录
     */
    public static function recursiveDelete(string $dir): void
    {
        if (is_dir($dir)) {
            $handle = opendir($dir);
            do {
                $file = readdir($handle);
                if ($file === false) {
                    break;
                }
                if (in_array($file, ['.', '..'])) {
                    continue;
                }
                if (is_dir("{$dir}/{$file}")) {
                    self::recursiveDelete("{$dir}/{$file}");
                } else {
                    @unlink("{$dir}/{$file}");
                }
            } while ($file !== false);
            closedir($handle);
            rmdir($dir);
        }
    }

    public static function checkUrl(string $fileUrl): void
    {
        // 利用get_headers函数
        $headers = get_headers($fileUrl);
        if ($headers === false || ! str_contains($headers[0], '200')) {
            throw new InvalidRequestException(sprintf('链接:%s无法访问请检查!', $fileUrl));
        }
    }
}
