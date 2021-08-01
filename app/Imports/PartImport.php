<?php

namespace App\Imports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

// class PartImport implements ToModel, WithHeadingRow
class PartImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   //  public function model(array $row)
   //  {
   //      return new Part([
   //          'part_number' => $row['part_number'],
   //          'product_group' => $row['product_group'],
   //          'part_name' => $row['part_name'],
   //          'type_unit' => $row['type_unit'],
   //          'part_description' => $row['part_description'],
   //          'price' => $row['price'],
   //          'picture' => $row['picture'],
   //          'stock_part' => $row['stock_part'],
   //      ]);
   //  }

    public function collection(Collection $rows)
    {
      //  dd($rows);
        foreach ($rows as $key => $row) 
        {
           if ($key >= 1) {
              Part::create([
               'type_unit' => $row[0],
               'product_group' => $row[1],
               'part_name' => $row[2],
               'part_number' => $row[3],
               'part_description' => $row[4],
               'price' => $row[5],
               'stock_part' => $row[6],
               'picture' => $row[7],
            ]);
           }
            
        }
    }
}
