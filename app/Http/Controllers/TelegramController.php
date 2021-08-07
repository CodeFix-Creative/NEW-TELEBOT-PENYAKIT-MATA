<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Exports\BookingExport;
use App\Models\Part;
use App\Models\Service;
use App\Models\CustomerService;
use App\Models\BookingTime;
use App\Models\Booking;
use App\Traits\RequestTrait;
use App\Traits\MakeComponents;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

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

        } else if($action == "/001ExcelPrintAdmin") {
            $currentDate = date('Y-m-d');
        
            $fileName = 'Report-Booking-'. $currentDate .'.xlsx';
            
            Excel::store(new BookingExport($currentDate), $fileName);
            
            $file = env('APP_URL') . Storage::url($fileName);
            $mimeType = Storage::mimeType($fileName);
            
            $parameters = [
                'chat_id' => $userId,
                'document' => curl_file_create($file, $mimeType, $fileName),
            ];

            $this->sendDocument($parameters);

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
            $checkBooking = Booking::where('chat_id', $userId)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->where('status', 'Waiting')->first();

            if($checkBooking) {
                if($checkBooking->nama_lengkap == NULL || $checkBooking->no_telp == NULL) {
                    $text = "Anda telah melakukan booking service untuk esok hari, booking id : ".$checkBooking->booking_id." , ";
                    $text .= "Namun Anda belum menginputkan Nama Lengkap dan No Telp Anda. \n";
                    $text .= "Silahkan reply chat ini dengan Nama Lengkap dan No Telp Anda dengan format sebagai berikut: \n";
                    $text .= "booking id#Nama Lengkap#No Telp\n\n";
                    $text .= "Contoh: \n";
                    $text .= "2019xxxxxx#Budi Setiawan#081xxxxxxxxx\n";

                    $this->apiRequest('sendMessage', [
                        'chat_id' => $userId,
                        'text' => $text,
                    ]);
                } else {
                    $bookingDetail = Booking::where('chat_id', $userId)
                        ->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->where('status', 'Waiting')
                        ->first();

                    $text = "Anda telah melakukan booking service untuk esok hari. \n";
                    $text .= "Berikut jadwal service Anda: \n\n";
                    $text .= "Booking ID: ". $bookingDetail->booking_id ."\n";
                    $text .= "Nama Lengkap: ". $bookingDetail->nama_lengkap ."\n";
                    $text .= "Nomor Telephone: ". $bookingDetail->no_telp ."\n";
                    $text .= "Customer Service: ". $bookingDetail->customer_service->user->nama ."\n";
                    $text .= "Hari/Tanggal: " . Carbon::parse($bookingDetail->booking_date)->isoFormat('dddd, DD MMMM Y') . "\n";
                    $text .= "Waktu: " . $bookingDetail->booking_time->booking_time . "\n\n";
                    $text .= "Harap datang ke ASUS Service Center pada hari dan waktu yang telah ditentukan, terima kasih.\n";

                    $this->apiRequest('sendMessage', [
                        'chat_id' => $userId,
                        'text' => $text,
                    ]);
                }

            } else {
                $text = "Anda memilih menu booking service. \n";
                $text .= "Silahkan pilih waktu yang tersedia. \n";
                $text .= "Jika tidak muncul, berarti booking service sudah full. Silahkan datang langsung ke Asus Service Center terdekat. \n";

                $customerService = CustomerService::all();
                $bookingTimeAvailableArr = [];
                $btn = [];

                // Load semua data customer service
                foreach ($customerService as $cs) {
                    $bookingTimeUnavailable = [];
                    // Cek data booking service per customer service
                    $booking = $cs->booking->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->whereNotIn('status', ['Cancel']);;
                    // Jika data booking untuk hari esok ada
                    if($booking->count() > 0) {
                        // Maka loop data booking
                        foreach($booking as $b) {
                            // Ambil id_booking_time untuk dimasukkan ke dalam booking time yang tidak tersedia
                            $bookingTimeUnavailable[] = $b->id_booking_time;
                        }
                    }

                    // Ambil booking time yang tersedia 
                    $bookingTimeAvailable = BookingTime::whereNotIn('id', $bookingTimeUnavailable)->pluck('booking_time');
                    // Loop booking time yang tersedia
                    foreach($bookingTimeAvailable as $bta) {
                        // Cek apakah booking time sudah ada dalam array booking time yang tersedia
                        if( ! in_array($bta, $bookingTimeAvailableArr)) {
                            // Masukkan booking time yang tersedia ke dalam array
                            $bookingTimeAvailableArr[] = $bta;
                        }
                    }
                }
                
                // Urutkan booking time yang tersedia berdasarkan waktu
                sort($bookingTimeAvailableArr);
                
                // Loop array booking time agar sesuai dengan format button telegram
                foreach($bookingTimeAvailableArr as $b) {
                    $btn[] = [$b];
                }

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                    'reply_markup' => $this->keyboardBtn($btn),
                ]);
            }

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
            // Cek jadwal booking terlebih dahulu
            $checkBooking = Booking::where('chat_id', $userId)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->where('status', 'Waiting')->first();

            // $checkBooking = Booking::where('chat_id', $userId)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->first();

            if($checkBooking) {
                if($checkBooking->nama_lengkap == NULL || $checkBooking->no_telp == NULL) {
                    $text = "Anda sebelumnya telah melakukan booking service untuk esok hari untuk jadwal " . $checkBooking->booking_time->booking_time . ", booking id :  " . $checkBooking->booking_id . " , ";
                    $text .= "namun Anda belum menginputkan Nama Lengkap dan No Telp Anda. \n";
                    $text .= "Silahkan reply chat ini dengan Nama Lengkap dan No Telp Anda dengan format sebagai berikut: \n";
                    $text .= "booking id#Nama Lengkap#No Telp\n\n";
                    $text .= "Contoh: \n";
                    $text .= "2019xxx#Budi Setiawan#081xxxxxxxxx\n";

                    $this->apiRequest('sendMessage', [
                        'chat_id' => $userId,
                        'text' => $text,
                    ]);
                } else {
                    $bookingDetail = Booking::where('chat_id', $userId)
                        ->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->where('status', 'Waiting')
                        ->first();

                    $text = "Anda telah melakukan booking service untuk esok hari. \n";
                    $text .= "Berikut jadwal service Anda: \n\n";
                    $text .= "Booking ID: ". $bookingDetail->booking_id ."\n";
                    $text .= "Nama Lengkap: ". $bookingDetail->nama_lengkap ."\n";
                    $text .= "Nomor Telephone: ". $bookingDetail->no_telp ."\n";
                    $text .= "Customer Service: ". $bookingDetail->customer_service->user->nama ."\n";
                    $text .= "Hari/Tanggal: " . Carbon::parse($bookingDetail->booking_date)->isoFormat('dddd, DD MMMM Y') . "\n";
                    $text .= "Waktu: " . $bookingDetail->booking_time->booking_time . "\n\n";
                    $text .= "Harap datang ke ASUS Service Center pada hari dan waktu yang telah ditentukan, terima kasih.\n";

                    $this->apiRequest('sendMessage', [
                        'chat_id' => $userId,
                        'text' => $text,
                    ]);
                }

            } else {
                // Ambil data booking time
                $bookingTime = BookingTime::where('booking_time', $action)->first();
                // Pilih id customer service yang tidak tersedia pada booking time
                $customerServiceUnavailable = Booking::where('id_booking_time', $bookingTime->id)
                    ->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))
                    ->whereNotIn('status', ['Cancel'])
                    ->pluck('id_customer_service');
                // Pilih id customer service yang tersedia
                $customerServiceAvailable = CustomerService::inRandomOrder()->whereNotIn('id', $customerServiceUnavailable);
                // Jika ada yang tersedia, maka 
                if($customerServiceAvailable->get()->count() > 0) {
                    // Hitung data booking pada hari esok
                    $bookingCount = Booking::where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->count();
                    // Ambil data customer service yang pertama
                    $customerService = $customerServiceAvailable->first();
                    // Save booking time dan customer service ke dalam tabel
                    $booking = Booking::create([
                        'booking_id' => Carbon::tomorrow()->format('ymd') . sprintf('%04d', ++$bookingCount),
                        'nama_lengkap' => NULL,
                        'no_telp' => NULL,
                        'chat_id' => $userId,
                        'id_customer_service' => $customerService->id,
                        'id_booking_time' => $bookingTime->id,
                        'booking_date' => Carbon::tomorrow()->format('Y-m-d'),
                        'status' => 'Waiting',
                    ]);

                    $text = "Jadwal berhasil dibooking. Booking id anda". $booking->booking_id ."\n";
                    $text = "Silahkan reply chat ini dengan Nama Lengkap dan No Telp Anda dengan format sebagai berikut: \n";
                    $text .= "booking id#Nama Lengkap#No Telp\n\n";
                    $text .= "Contoh: \n";
                    $text .= "2019xxx#Budi Setiawan#081xxxxxxxxx\n";

                    $this->apiRequest('sendMessage', [
                        'chat_id' => $userId,
                        'text' => $text,
                    ]);
                } else {
                    $text = "Jadwal tidak tersedia atau sudah dibooking, silahkan pilih jadwal lainnya. \n";

                    $this->apiRequest('sendMessage', [
                        'chat_id' => $userId,
                        'text' => $text,
                        'reply_markup' => $this->keyboardBtn($this->mainMenu),
                    ]);
                }
            }
            
        } else if(strpos($action, '#') == true) {
            $customerData = explode("#", $action);

            // update booking detail based on customer's reply by chat id
            $bookingDetail = Booking::where('chat_id', $userId)
                ->where('booking_id', $customerData[0])
                ->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))
                ->first();
                
            $bookingDetail->update([
                'nama_lengkap' => $customerData[1],
                'no_telp' => $customerData[2],
            ]);

            $text = "Data Anda telah tersimpan. Jadwal service Anda pada: \n\n";
            $text .= "Hari/Tanggal: " . Carbon::parse($bookingDetail->booking_date)->isoFormat('dddd, DD MMMM Y') . "\n";
            $text .= "Waktu: " . $bookingDetail->booking_time->booking_time . "\n\n";
            $text .= "Booking ID: ". $bookingDetail->booking_id ."\n";
            $text .= "Nama Lengkap: ". $bookingDetail->nama_lengkap ."\n";
            $text .= "Nomor Telephone: ". $bookingDetail->no_telp ."\n";
            $text .= "Customer Service: ". $bookingDetail->customer_service->user->nama ."\n\n";
            $text .= "Harap datang ke ASUS Service Center pada hari dan waktu yang telah ditentukan, terima kasih.\n";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);
        } else {
            $text = "maaf, input yang anda masukkan salah, silahkan input sesuai format atau silahkan pilih menu dibawah ini: ";

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
