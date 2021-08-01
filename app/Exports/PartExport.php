<?php

namespace App\Exports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PartExport implements WithHeadings, ShouldAutoSize, WithStyles
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
            'TYPE UNIT',
            'PRODUCT GROUP',
            'PART NAME',
            'PART NUMBER',
            'PART DESCRIPTION',
            'PRICE',
            'STOCK PART',
            'PICTURE',
        ];
    }
   
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
    }
}
