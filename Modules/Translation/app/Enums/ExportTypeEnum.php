<?php

declare(strict_types=1);

namespace Modules\Translation\Enums;

use App\Enums\BaseEnum;
use Carlin\LaravelDict\Attributes\EnumClass;
use Carlin\LaravelDict\Attributes\EnumProperty;

#[EnumClass('ExportTypeEnum', '导出类型')]
class ExportTypeEnum extends BaseEnum
{
    #[EnumProperty('Laravel')]
    public const LARAVEL = 'laravel';

    #[EnumProperty('Vue-i18n')]
    public const VUE_I18N = 'vue-i18n';

     #[EnumProperty('Android')]
     public const ANDROID = 'android';

    #[EnumProperty('IOS')]
    public const IOS = 'ios';

}
