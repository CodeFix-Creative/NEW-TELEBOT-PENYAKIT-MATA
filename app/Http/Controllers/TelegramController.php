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
        ['text' => "Cek Service", 'callback_data' => '1'],
        ['text' => "Cek Spare Part", 'callback_data' => '2'],
        ['text' => "Booking Service", 'callback_data' => '3'],
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
            $part = Part::select('product_group')->distinct()->get();

            $text = "Silahkan pilih product group: (1-" . count($part) . "): \n";

            $numberOption = [];

            foreach($part as $key => $value) {
                $text .= $key + 1 . ". " . $value->product_group . "\n";
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
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
