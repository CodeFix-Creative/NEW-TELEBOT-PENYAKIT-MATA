<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceExport implements WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
   //  public function collection()
   //  {
   //      return Part::all();
   //  }

   public function headings(): array
    {
        return [
            'RMA NO 1',
            'RMA ISSUE DATE',
            'SERIAL NO',
            'MODEL ID',
            'PRODUCT TYPE DESC',
            'STATUS 1',
            'TRANSFER SHIP SUBMIT DATE',
            'RMA NO 1 FINAL TEST DATE',
            'WARRANTY END',
            'WARRANTY STATUS',
            'RMA CENTER 2',
            'RMA NO 2',
            'STATUS 2',
            'KBO STATUS',
            'ORDER DATE',
            'ALLOCATED DATE',
            'KBO ETA END',
            'ORG PART DESC',
            'NEW PART NO',
            'NEW PART DESC',
            'FINAL RMA STATUS',
            'REMARK / PROBLEM',
        ];
    }
   
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:V1')->getFont()->setBold(true);
    }
}

