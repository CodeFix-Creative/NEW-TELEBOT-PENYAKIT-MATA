<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingExport implements FromView , ShouldAutoSize , WithStyles
{
      /**
       * @return \Illuminate\Support\Collection
      */
      protected $currentDate;
      function __construct($currentDate) {
         $this->currentDate = $currentDate;
      }

      public function view(): View
      { 
         $booking = Booking::where('booking_date' , $this->currentDate)->get();
         return view('excel.booking', compact('izin'));
      }

      public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
    }
}
