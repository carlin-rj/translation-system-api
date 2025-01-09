<?php

namespace App\Imports;

use App\Exceptions\InvalidRequestException;
use App\Exports\ImportResultExport;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;

abstract class BaseImport implements ToArray, WithHeadingRow, WithChunkReading, WithValidation, SkipsEmptyRows, WithCalculatedFormulas, WithEvents
{
    use SkipsErrors, RegistersEventListeners;

    protected bool $hasValidateHeader = false;

    protected array $header = [];

    //错误信息是否在原始模板中提现
    protected bool $useOriginalTemplate = true;

    //错误信息
    protected static array $validateErrors = [];

    protected int $lineNumber = 2;

    public function __construct()
    {
        $header = array_flip($this->header);
        HeadingRowFormatter::extend('header', static function ($value) use ($header) {
            return $header[$value] ?? $value;
        });
        HeadingRowFormatter::default('header');
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function validateHeader(array $row): void
    {
        if (array_diff(array_keys($this->header), array_keys($row))) {
            throw new InvalidRequestException('导入文件标题不正确');
        }
        $this->hasValidateHeader = true;
    }

    /**
     * @throws InvalidRequestException
     */
    public function prepareForValidation(mixed $data): mixed
    {
        if (! $this->hasValidateHeader) {
            $this->validateHeader($data);
        }

        $data['_line_number'] = $this->lineNumber++;

        return $data;
    }

    public function array(array $array): void
    {
        if (empty($array)) {
            return;
        }

        method_exists($this, 'beforeEach') && $array = $this->beforeEach($array);
        foreach ($array as $item) {
            try {
                //自定义业务逻辑验证
                method_exists($this, 'customValidationRow') && $this->customValidationRow($item);
                //执行每一行
                method_exists($this, 'processRow') && $this->processRow($item);
            } catch (\Throwable $e) {
                //错误收集
                $this->addValidateErrors($item['_line_number'], $item, $e);

                if (! $this instanceof SkipsOnFailure) {
                    throw $e;
                }
            }
        }
        method_exists($this, 'afterEach') && $this->afterEach($array);
    }

    protected function addValidateErrors(int $line, array $item, \Throwable $e): void
    {
        self::$validateErrors[$line][] = new Failure($line, '', [$e->getMessage()], $item);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    //收集每一行数据验证失败
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            self::$validateErrors[$failure->values()['_line_number']][] = $failure;
        }
    }

    public static function afterImport(AfterImport $event): void
    {
        if (empty(self::$validateErrors)) {
            return;
        }

        /** @var BaseImport $import */
        $import = $event->getConcernable();
        Excel::store(new ImportResultExport($import->header, self::$validateErrors, null), 'original_with_annotations.xlsx', 'oss');
        //清空数据
        self::$validateErrors = [];
    }
}
