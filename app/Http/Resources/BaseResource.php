<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\CursorPaginator as CursorPaginatorContract;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\LazyCollection;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\DataPipeline;
use Spatie\LaravelData\DataPipes\DataPipe;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\LaravelData\Resource;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataClass;

class BaseResource extends Resource
{
    public static function pipeline(): DataPipeline
    {
        return parent::pipeline()->firstThrough(static::basePipe());
    }

    public static function basePipe(): DataPipe
    {
        //匿名类
        return new class() implements DataPipe {
            public function handle(mixed $payload, DataClass $class, array $properties, CreationContext $creationContext): array
            {
				if (empty($payload)) {
					return $properties;
				}

                return ($class->name)::beforeFill($properties, $payload);
            }
        };
    }

    public static function beforeFill(array $properties, mixed $payload): array
    {
        return $properties;
    }


    public static function collection(mixed $items, ?string $into = null): array|DataCollection|PaginatedDataCollection|CursorPaginatedDataCollection|Enumerable|AbstractPaginator|PaginatorContract|AbstractCursorPaginator|CursorPaginatorContract|LazyCollection|Collection
    {
        return static::collect($items, $into);
    }
}
