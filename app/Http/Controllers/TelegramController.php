<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Traits\RequestTrait;
use App\Traits\MakeComponents;
use App\Models\Part;

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
         
         $arrPart = [];

         foreach($partSelect as $key => $value) {
            $arrPart[] = $value->product_group;
         }

        if($action == "/start") {
            $text = "Selamat datang di Bot Telegram ASUS Service Center. Silahkan pilih menu di bawah ini: ";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);

        } else if ($action == "Cek Service") {
            $text = "Anda memilih menu cek service.";

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
        }else if (in_array($action, $arrPart)) {
           $partSelect2 = Part::select('product_group')->distinct()->get();
           
           foreach($partSelect2 as $key => $value) {
               //  $text .= $key + 1 . ". " . $value->product_group . "\n";
               // $btn[] = ["$value->product_group"] ;
               if($action == $value->product_group) {
                  $type = Part::where('product_group' , $value->product_group)->distinct()->get()->groupBy('type_unit');
                  // $part = Part::select('type_unit')->distinct()->where('product_group', $value->product_group)->get();

                  $text = "Silahkan pilih type unit anda: \n";

                  $numberOption = [];
                  $btn = [];

                  foreach($type as $key => $value) {
                     //  $text .= $key + 1 . ". " . $value->product_group . "\n";
                     $btn[] = ["$value->type_unit"] ;
                  }

                  $this->apiRequest('sendMessage', [
                     'chat_id' => $userId,
                     'text' => $text,
                     'reply_markup' => $this->keyboardBtn($btn),
                  ]);

                  // die();
               }
            }
        }else {
            
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
