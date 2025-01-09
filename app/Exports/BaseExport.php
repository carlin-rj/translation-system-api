<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

abstract class BaseExport extends DefaultValueBinder implements ShouldAutoSize, WithHeadings, WithMapping, WithStrictNullComparison
{
}
