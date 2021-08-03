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

        if($action == '/start') {
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
            $text = "Silahkan pilih product group: ";

            $part = Part::select('product_group')->distinct()->get()->toArray();
            $productGroup = [];

            foreach($part as $value) {
                foreach($value as $v) {
                    $productGroup[] = $v;
                }
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($productGroup),
            ]);
        } else if ($action == "Booking Service") {
            $text = "Anda memilih menu booking service.";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
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
