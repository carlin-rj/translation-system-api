<?php

namespace Modules\Common\Services;

use App\Helpers\Str;
use Carlin\LaravelDict\Dict;

class DictService
{
    public function all(): array
    {
        return array_values(Dict::getDict());
    }

    public function getByGroup(string $key): array
    {
        $data = [];
        $list = $this->all();
        foreach ($list as $item) {
            //检查group字段是否包含webApi
            if (isset($item['group']) && Str::contains($item['group'], $key)) {
                $data[] = $item;
            }
        }
        return $data;
    }
}
