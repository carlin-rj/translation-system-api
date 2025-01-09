<?php

namespace App\Exports;

namespace App\Exports;

use Iterator;
use Maatwebsite\Excel\Concerns\FromIterator;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportResultExport implements FromIterator, WithEvents
{
    protected array $header;

    /** @var array<int, array<Failure>> */
    protected array $errors;

    protected ?string $filePath;

    public function __construct(array $header, array $errors, ?string $filePath = null)
    {
        //按错误行号排序
        if (! isset($filePath)) {
            $errors = $this->resetNumbers($errors);
        }

        $this->header = $header;
        $this->errors = $errors;
        $this->filePath = $filePath;
    }

    /**
     * 重新排序错误行号
     *
     * @author: whj
     *
     * @date: 2023/8/15 17:37
     */
    private function resetNumbers(array $errors): array
    {
        $data = [];
        ksort($errors);
        $errors = array_values($errors);
        foreach ($errors as $k => $error) {
            $data[$k + 2] = $error;
        }

        return $data;
    }

    public function iterator(): Iterator
    {
        if (! empty($this->filePath)) {
            $spreadsheet = IOFactory::load($this->filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop over all cells
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                yield $cells;
            }
        } else {
            //合并表头和错误信息
            //添加表头
            yield array_values($this->header);
            foreach ($this->errors as $errors) {
                $item = $errors[0]->values();
                $data = [];
                foreach ($this->header as $key => $value) {
                    $data[$key] = $item[$key];
                }
                yield $data;
            }
        }

    }

    /**
     * 注册事件
     *
     * @author: whj
     *
     * @date: 2023/8/15 16:13
     */
    public function registerEvents(): array
    {
        return [
            //写入后事件
            BeforeWriting::class => function (BeforeWriting $event) {
                $sheet = $event->getDelegate()->getActiveSheet();
                if (! empty($this->errors)) {
                    foreach ($this->errors as $line => $errors) {
                        $errorList = $this->mergeCellErrors($errors);
                        foreach ($errorList as $column => $error) {
                            //锁定行列，并且给单元格添加错误批注
                            $sheet->getComment($column . $line)->setAuthor('Error')->getText()->createText($error);
                        }
                    }
                }
            },
        ];
    }

    /**
     * @param  Failure[]  $errors
     *
     * @author: whj
     *
     * @date: 2023/8/15 17:17
     */
    public function mergeCellErrors(array $errors): array
    {
        $data = [];
        foreach ($errors as $error) {
            $column = $this->getColumnByField($error->attribute(), $this->header);

            if (! isset($data[$column])) {
                $data[$column] = [];
            }

            foreach ($error->errors() as $errorMessage) {
                $data[$column][] = $errorMessage;
            }
        }

        return $data;
    }

    /**
     * 根据字段获取列的位置并且反推出列的字母
     *
     * @author: whj
     *
     * @date: 2023/8/15 16:12
     */
    private function getColumnByField(string $field, array $header): string
    {
        $index = array_search($field, array_keys($header), true);
        if ($index !== false) {
            $columnLetter = '';
            //@phpstan-ignore-next-line
            while ($index >= 0) {
                $remainder = $index % 26;
                $columnLetter = chr(ord('A') + $remainder) . $columnLetter;
                $index = (int) ($index / 26) - 1;
            }

            return $columnLetter;
        }

        return 'A';
    }
}
