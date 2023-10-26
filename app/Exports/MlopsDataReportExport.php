<?php

namespace App\Exports;


use App\Models\MlopsInspAi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MlopsDataReportExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        return MlopsInspAi::query();
    }

    public function headings(): array
    {
        return ['ID', 'JobId', 'DataSetId', 'ServiceVersionId',
            'PartRefNo', 'Path', 'AiResult', 'AiCode', 'ManualResult',
            'ManualCode', 'Remarks', 'Status', 'CreatedAt', 'UpdatedAt'];
    }
}
