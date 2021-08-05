<?php

namespace App\Imports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;


class ServiceImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   //  public function model(array $row)
   //  {
   //      return new Service([
   //          //
   //      ]);
   //  }

   public function collection(Collection $rows)
    {
      //  dd($rows);
        foreach ($rows as $key => $row) 
        {
           if ($key >= 1) {
              Service::create([
               'rma_no_1' => $row[0],
               'rma_issue_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d'),
               'serial_no' => $row[2],
               'model_id' => $row[3],
               'product_type_desc' => $row[4],
               'status_1' => $row[5],
               'transfer_ship_submit_date' => $row[6],
               'rma_no_1_finaltest_date' => $row[7],
               'warranty_end' => $row[8],
               'warranty_status' => $row[9],
               'rma_center_2' => $row[10],
               'rma_no_2' => $row[11],
               'status_2' => $row[12],
               'kbo_status' => $row[13],
               'order_date' => $row[14],
               'allocated_date' => $row[15],
               'kbo_eta_end' => $row[16],
               'org_part_desc' => $row[17],
               'new_part_no' => $row[18],
               'new_part_desc' => $row[19],
               'final_rma_status' => $row[20],
               'remark_or_problem' => $row[21],
            ]);
           }
            
        }
    }
}
