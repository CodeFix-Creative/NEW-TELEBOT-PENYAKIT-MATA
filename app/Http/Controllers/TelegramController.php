<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Traits\RequestTrait;
use App\Traits\MakeComponents;
use App\Models\Part;
use App\Models\Service;
use App\Models\CustomerService;
use App\Models\BookingTime;
use App\Models\Booking;
use Carbon\Carbon;

class TelegramController extends Controller
{
    use RequestTrait, MakeComponents;

    private $mainMenu = [
        ["Cek Service"],
        ["Cek Spare Part"],
        ["Booking Service"],
    ];

    public function index()
    {
        $result = json_decode(file_get_contents('php://input'));
        $action = $result->message->text;
        $userId = $result->message->from->id;

        // Part
        $partSelect = Part::select('product_group')->distinct()->get();
        $unitSelect = Part::select('type_unit')->distinct()->get();

        //Booking
        $booking = Booking::all();

        //Booking Time
        $bookingTime = BookingTime::all();

        //Customer Service
        $customerService = CustomerService::all();
        
        $arrPart = [];
        $arrUnit = [];
        $arrBooking = [];
        $arrBookingTime = [];

        foreach($partSelect as $key => $value) {
            $arrPart[] = $value->product_group;
        }

        foreach($unitSelect as $key => $value) {
            $arrUnit[] = $value->type_unit;
        }

        foreach($bookingTime as $key => $value) {
            $arrBookingTime[] = $value->booking_time;
        }

        if($action == "/start") {
            $text = "Selamat datang di Bot Telegram ASUS Service Center . Silahkan pilih menu di bawah ini: ";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);

        } else if ($action == "Cek Service") {
            $text = "Anda memilih menu check service \n";
            $text .= "Silahkan inputkan nomor RMA anda :";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);
        } else if (Service::where('rma_no_1' , $action)->exists() == true) {
            
            $status = Service::where('rma_no_1' , $action)->first();

            // Penjelasan status 1
            if ($status->status_1 == 'FINALTEST') {
               $status->status_1 = 'Unit dalam penguji/pengetesan terakhir';
            } else if ($status->status_1 == 'REPAIR') {
               $status->status_1 = 'Unit dalam pengejaan – Diagnosa/Pemasangan part';
            }else if ($status->status_1 == 'SHIP') {
               $status->status_1 = 'Unit telah selesai proses perbaikan';
            }else if ($status->status_1 == 'TRANSFER') {
               $status->status_1 = 'Unit dikirim untuk proses perbaikan';
            }else if ($status->status_1 == 'WAIT') {
               $status->status_1 = 'Unit sedang menunggu part/konfirmasi';
            }else if ($status->status_1 == 'WAITEX') {
               $status->status_1 = 'Unit sedang menunggu unit baru/pengganti';
            }else{
               $status->status_1;
            }

            // Penjelasan status 2
            if ($status->status_2 == 'CLOSED') {
               $status->status_2 = 'Unit transfer sudah selesai perbaikan dan sudah dikirim';
            } else if ($status->status_2 == 'REPAIR') {
               $status->status_2 = 'Unit transfer dalam pengejaan – Diagnosa/Pemasangan part';
            }else if ($status->status_2 == 'SHIP') {
               $status->status_2 = 'Unit transfer sudah selesai perbaikan';
            }else{
               $status->status_2;
            }

            // Penjelasan KBO STATUS
            if ($status->kbo_status == 'ALLOCATED') {
               $status->kbo_status = 'Status part baru teralokasi ke unit';
            } else if ($status->kbo_status == 'BOOKED') {
               $status->kbo_status = 'Status part pesanan sudah diteknisi';
            }else if ($status->kbo_status == 'READY') {
               $status->kbo_status = 'Unit transfer sudah selesai perbaikan';
            }else if ($status->kbo_status == 'CLOSED') {
               $status->kbo_status = 'Status part rusak sudah dipasang dan diganti oleh teknisi';
            }else if ($status->kbo_status == 'ORDERED') {
               $status->kbo_status = 'Status part sedang dalam pemesanan';
            }else if ($status->kbo_status == 'DROP') {
               $status->kbo_status = 'Status part tidak jadi dipesan/digunakan';
            }else{
               $status->kbo_status;
            }

            // Penjelasan FINAL RMA STATUS
            if ($status->final_rma_status == 'Allocated') {
               $status->final_rma_status = 'Status unit dalam pemasangan part/Status unit sedang pengetesan';
            } else if ($status->final_rma_status == 'NO KBO') {
               $status->final_rma_status = 'Status unit masih proses Diagnosa kerusakan';
            }else if ($status->final_rma_status == 'non-allocate') {
               $status->final_rma_status = 'Status unit masih menunggu part baru/pengganti';
            }else if ($status->final_rma_status == 'SHIP') {
               $status->final_rma_status = 'Status unit telah selesai proses perbaikan';
            }else if ($status->final_rma_status == 'Transfer - Allocated') {
               $status->final_rma_status = 'Status unit transfer sudah sampai diservice center tujuan';
            }else if ($status->final_rma_status == 'Transfer - In Transit from 1st site to 2nd site') {
               $status->final_rma_status = 'Status unit transfer dalam proses pengiriman service center tujuan';
            }else if ($status->final_rma_status == 'Transfer - In Transit from 2nd site to 1st site') {
               $status->final_rma_status = 'Status unit transfer dalam proses pengiriman balik ke service center asal';
            }else if ($status->final_rma_status == 'Under CB/SWAP Process') {
               $status->final_rma_status = 'Status unit dalam proses pergantian unit';
            }else if ($status->final_rma_status == 'Wait for customer') {
               $status->final_rma_status = 'Status unit menunggu konfirmasi dari pengguna';
            }else if ($status->final_rma_status == 'Waiting For Carrying Out') {
               $status->final_rma_status = 'Status unit menunggu untuk diambil pengguna';
            }else{
               $status->final_rma_status;
            }

            if ($status->status_1 == "TRANSFER") {
                $text = "**Informasi Umum/Unit** \n";
                $text .= "1. NOMOR SERVICE 1       : ". $status->rma_no_1 ."\n";
                $text .= "2. SERIAL NUMBER UNIT       : ". $status->serial_no ."\n";
                $text .= "3. TANGGAL UNIT MASUK SERVICE  : ". $status->rma_issue_date ."\n";
                $text .= "4. TIPE PRODUK UNIT : ". $status->product_type_desc ."\n";
                $text .= "5. MODEL UNIT        : ". $status->model_id ."\n";
                $text .= "6. TANGGAL MASA BERLAKU GARANSI   : ". $status->warranty_end ."\n";
                $text .= "7. STATUS GARANSI : ". $status->warranty_status ."\n";
                $text .= "8. INFORMASI KERUSAKAN UNIT  : ". $status->remark_or_problem ."\n\n";

                $text .= "**Informasi Status Service** \n";
                $text .= "1. STATUS PENGERJAAN UNIT 1        : ". $status->status_1 ."\n";
                $text .= "2. TANGGAL UNIT DI TRANSFER : ". $status->transfer_ship_submit_date ."\n";
                $text .= "3. PROFILE SERVICE CENTER YANG DI TRANSFER    : ". $status->rma_center_2 ."\n";
                $text .= "4. NOMOR SERVICE 2        : ". $status->rma_no_2 ."\n";
                $text .= "5. STATUS PENGERJAAN UNIT 2        : ". $status->status_2 ."\n";
                $text .= "6. DETAIL STATUS PENGERJAAN UNIT - NON TRANSFER: ". $status->final_rma_status ."\n";
            } else {
                $text = "**Informasi Umum/Unit** \n";
                $text .= "1. NOMOR SERVICE 1        : ". $status->rma_no_1 ."\n";
                $text .= "2. SERIAL NUMBER UNIT       : ". $status->serial_no ."\n";
                $text .= "3. TANGGAL UNIT MASUK SERVICE  : ". $status->rma_issue_date ."\n";
                $text .= "4. TIPE PRODUK UNIT : ". $status->product_type_desc ."\n";
                $text .= "5. MODEL UNIT         : ". $status->model_id ."\n";
                $text .= "6. TANGGAL MASA BERLAKU GARANSI    : ". $status->warranty_end ."\n";
                $text .= "7. STATUS GARANSI : ". $status->warranty_status ."\n";
                $text .= "8. INFORMASI KERUSAKAN UNIT  : ". $status->remark_or_problem ."\n\n";

                $text .= "**Informasi Status Service** \n";
                $text .= "1. STATUS PENGERJAAN UNIT 1        : ". $status->status_1 ."\n";
                $text .= "2. STATUS PEMESANAN PART      : ". $status->kbo_status ."\n";
                $text .= "3. TANGGAL PEMESANAN PART      : ". $status->order_date ."\n";
                $text .= "4. PART ORIGINAL YANG RUSAK   : ". $status->org_part_desc ."\n";
                $text .= "5. NOMOR IDENTITAS PART BARU     : ". $status->new_part_no ."\n";
                $text .= "6. PART BARU YANG SEDANG DI PESAN   : ". $status->new_part_desc ."\n";
                $text .= "7. TANGGAL PART TIBA  : ". $status->allocated_date ."\n";
                $text .= "8. TANGGAL ESTIMASI PART TIBA     : ". $status->kbo_eta_end ."\n";
                $text .= "9. DETAIL STATUS PENGERJAAN UNIT - NON TRANSFER: ". $status->final_rma_status ."\n";
            }

            // $text = "Mantap Benar! \n";
            // $text .= "Silahkan inputkan nomor RMA anda :";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);

        } else if ($action == "Cek Spare Part") {
            $part = Part::select('product_group')->distinct()->get();
            $text = "Silahkan pilih product group: \n";
            $btn = [];

            foreach($part as $key => $value) {
                //  $text .= $key + 1 . ". " . $value->product_group . "\n";
                $btn[] = ["$value->product_group"];
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($btn),
            ]);

        } else if ($action == "Booking Service") {
            $text = "Anda memilih menu booking service. \n";
            $text .= "Silahkan pilih waktu yang tersedia. \n";
            $text .= "Jika tidak muncul, berarti booking service sudah full. Silahkan datang langsung ke Asus Service Center terdekat. \n";

            $customerService = CustomerService::all();
            $btn = [];

            // checking
            foreach ($customerService as $customerService) {
                if (Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->exists() == true ) {
                    $bookingTime = BookingTime::all();
                    // $booking = Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->get();

                    foreach ($bookingTime as $bookingTime) {
                        if (Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->where('id_booking_time',$bookingTime->id)->exists() == false) {
                            if (!in_array($bookingTime->booking_time, $btn)) {
                                $btn[] = ["$bookingTime->booking_time"];
                            }
                        }
                    }
                } else {
                    $bookingTime = BookingTime::all();

                    foreach ($bookingTime as $bookingTime) {
                        if (!in_array($bookingTime->booking_time, $btn)) {
                            $btn[] = ["$bookingTime->booking_time"];
                        }
                    }
                }
            }

            $btn = array_unique($btn, SORT_REGULAR);

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($btn),
            ]);
        } else if (in_array($action, $arrPart)) {
            $part = Part::select('type_unit')->distinct()->where('product_group', $action)->get();

            $text = "Silahkan pilih tipe unit Anda: \n";
            $btn = [];

            foreach($part as $key => $value) {
                //  $text .= $key + 1 . ". " . $value->product_group . "\n";
                $btn[] = ["$value->type_unit"];
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($btn),
            ]);

        } else if (in_array($action, $arrUnit)) {
            $part = Part::where('type_unit', $action)->get();

            $text = "Daftar part berdasarkan filter Anda: \n\n";

            foreach($part as $key => $value) {
                $text .= $key + 1 . ". Part No: " . $value->part_number . "\n";
                $text .= "Nama Part: " . $value->part_name . "\n";
                $text .= "Deskripsi: " . $value->part_description . "\n";
                $text .= "Harga: " . number_format($value->price, 0, '', '.') . "\n";
                $text .= "Stok: " . $value->stock_part . "\n";
                if($value->picture != NULL) { 
                $text .= "Foto: " . $value->picture . "\n\n";
                } else {
                $text .= "\n";
                }
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);

        } else if (in_array($action, $arrBookingTime)) {
            $time = BookingTime::where('booking_time', $action)->first();
            $booking = Booking::where('id_booking_time', $time->id)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->first();
            $bookedCustomerService = Booking::where('id_booking_time', 1)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->pluck('id_customer_service');
            $availableCustomerService = CustomerService::whereNotIn('id', $bookedCustomerService)->inRandomOrder()->first();
            
            if($booking) {
                $text = "Jadwal tidak tersedia atau sudah dibooking, silahkan pilih jadwal lainnya. \n";

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                    'reply_markup' => $this->keyboardBtn($this->mainMenu),
                ]);
            } else if(!$availableCustomerService) {
                $text = "Customer Service saat ini tidak tersedia untuk dibooking pada esok hari. Silahkan coba lagi keesokan harinya.";

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                    'reply_markup' => $this->keyboardBtn($this->mainMenu),
                ]);
            } else {
                // save booking time into the table
                $saveBooking = Booking::create([
                    'nama_lengkap' => NULL,
                    'no_telp' => NULL,
                    'chat_id' => $userId,
                    'id_customer_service' => $availableCustomerService->id,
                    'id_booking_time' => $time->id,
                    'booking_date' => Carbon::tomorrow()->format('Y-m-d'),
                    'status' => 'Waiting',
                ]);

                $text = "Jadwal berhasil dibooking. Silahkan reply chat ini dengan Nama Lengkap dan No Telp Anda dengan format sebagai berikut: \n";
                $text .= "Nama Lengkap#No Telp\n\n";
                $text .= "Contoh: \n";
                $text .= "Budi Setiawan#081xxxxxxxxx\n";

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                ]);
            }
            
        } else if(strpos($action, '#') == true) {
            $customerData = explode("#", $action);

            // update booking detail based on customer's reply by chat id
            $bookingDetail = Booking::where('booking_time', $action)
                ->where('chat_id', $userId)
                ->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))
                ->first();
                
            $bookingDetail->update([
                'nama_lengkap' => $customerData[0],
                'no_telp' => $customerData[1],
            ]);

            $text = "Data Anda telah tersimpan. Jadwal service Anda pada: \n";
            $text .= "Hari/Tanggal: ". Carbon::parse($bookingDetail->booking_date)->isoFormat('dddd, DD MMMM Y') ."\n";
            $text .= "Waktu: " . $bookingDetail->booking_time->booking_time . "\n";
            $text .= "Harap datang ke ASUS Service Center pada hari dan waktu yang telah ditentukan, terima kasih.\n";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);
        } else {
            $text = "Maaf, menu yang Anda pilih tidak tersedia. Silahkan pilih menu di bawah ini: ";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);
        }
        
    }

    public function webhook()
    {
        return $this->apiRequest('setWebhook', [
            'url' => url(route('webhook')),
        ]) ? ['success'] : ['something wrong'];
    }
}
