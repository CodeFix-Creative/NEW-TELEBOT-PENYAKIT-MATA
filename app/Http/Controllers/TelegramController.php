<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Traits\RequestTrait;
use App\Traits\MakeComponents;
use App\Models\Part;
use App\Models\Service;

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

         $partSelect = Part::select('product_group')->distinct()->get();
         $unitSelect = Part::select('type_unit')->distinct()->get();
         
         $arrPart = [];
         $arrUnit = [];

         foreach($partSelect as $key => $value) {
            $arrPart[] = $value->product_group;
         }

         foreach($unitSelect as $key => $value) {
            $arrUnit[] = $value->type_unit;
         }

        if($action == "/start") {
            $text = "Selamat datang di Bot Telegram ASUS Service Center. Silahkan pilih menu di bawah ini: ";

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
            $text = "Mantap Benar! \n";
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
            $text = "Anda memilih menu booking service.";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);
        }else if ($action == "Booking Service") {
            $text = "Anda memilih menu booking service.";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);
        } else if (in_array($action, $arrPart)) {
           // $partSelect2 = Part::select('product_group')->distinct()->get();
           
           // foreach($partSelect2 as $key => $value) {
           //     //  $text .= $key + 1 . ". " . $value->product_group . "\n";
           //     // $btn[] = ["$value->product_group"] ;
           //     if($action == $value->product_group) {
           //        // $type = Part::where('product_group' , $value->product_group)->distinct()->get();
           //        $part = Part::select('type_unit')->distinct()->where('product_group', $value->product_group)->get();

           //        $text = "Silahkan pilih type unit anda: \n";

           //        $numberOption = [];
           //        $btn = [];

           //        foreach($type as $key => $value) {
           //           //  $text .= $key + 1 . ". " . $value->product_group . "\n";
           //           $btn[] = ["$value->type_unit"] ;
           //        }

           //        $this->apiRequest('sendMessage', [
           //           'chat_id' => $userId,
           //           'text' => $text,
           //           'reply_markup' => $this->keyboardBtn($btn),
           //        ]);

           //        // die();
           //     }
           //  }
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

        } else {
            
               $text = "Maaf, menu yang Anda pilih tidak tersedia. Silahkan pilih menu di bawah ini: ";
               $option = [
                  ['Cek Service'],
                  ['Cek Spare Part'],
                  ['Booking Service'],
               ];

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
