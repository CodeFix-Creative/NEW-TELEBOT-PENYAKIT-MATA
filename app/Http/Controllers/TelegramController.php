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

            if ($status->status_1 == "TRANSFER") {
                $text = "**Informasi Umum/Unit** \n";
                $text .= "1. RMA NO 1        : ". $status->rma_no_1 ."\n";
                $text .= "2. SERIAL NO       : ". $status->serial_no ."\n";
                $text .= "3. RMA ISSUE DATE  : ". $status->rma_issue_date ."\n";
                $text .= "4. PRODUCT TYPE DESC : ". $status->product_type_desc ."\n";
                $text .= "5. MODEL ID        : ". $status->model_id ."\n";
                $text .= "6. WARRANTY_END    : ". $status->warranty_end ."\n";
                $text .= "7. WARRANTY_STATUS : ". $status->warranty_status ."\n";
                $text .= "8. REMARK/PROBLEM  : ". $status->remark_or_problem ."\n\n";

                $text .= "**Informasi Status Service** \n";
                $text .= "1. STATUS 1        : ". $status->status_1 ."\n";
                $text .= "2. TRANSFER SHIP SUBMIT DATE : ". $status->transfer_ship_submit_date ."\n";
                $text .= "3. RMA CENTER 2    : ". $status->rma_center_2 ."\n";
                $text .= "4. RMA NO 2        : ". $status->rma_no_2 ."\n";
                $text .= "5. STATUS 2        : ". $status->status_2 ."\n";
                $text .= "6. FINAL RMA STATUS: ". $status->final_rma_status ."\n";
            } else {
                $text = "**Informasi Umum/Unit** \n";
                $text .= "1. RMA NO 1        : ". $status->rma_no_1 ."\n";
                $text .= "2. SERIAL NO       : ". $status->serial_no ."\n";
                $text .= "3. RMA ISSUE DATE  : ". $status->rma_issue_date ."\n";
                $text .= "4. PRODUCT TYPE DESC : ". $status->product_type_desc ."\n";
                $text .= "5. MODEL ID        : ". $status->model_id ."\n";
                $text .= "6. WARRANTY_END    : ". $status->warranty_end ."\n";
                $text .= "7. WARRANTY_STATUS : ". $status->warranty_status ."\n";
                $text .= "8. REMARK/PROBLEM  : ". $status->remark_or_problem ."\n\n";

                $text .= "**Informasi Status Service** \n";
                $text .= "1. STATUS 1        : ". $status->status_1 ."\n";
                $text .= "2. KBO STATUS      : ". $status->kbo_status ."\n";
                $text .= "3. ORDER DATE      : ". $status->order_date ."\n";
                $text .= "4. ORG PART DESC   : ". $status->org_part_desc ."\n";
                $text .= "5. NEW PART NO     : ". $status->new_part_no ."\n";
                $text .= "6. NEW PART DESC   : ". $status->new_part_desc ."\n";
                $text .= "7. ALLOCATED DATE  : ". $status->allocated_date ."\n";
                $text .= "8. KBO ETA END     : ". $status->kbo_eta_end ."\n";
                $text .= "9. FINAL RMA STATUS: ". $status->final_rma_status ."\n";
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
            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $action,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);
        } else if(strpos($action, '#') == true) {
            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $action,
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
