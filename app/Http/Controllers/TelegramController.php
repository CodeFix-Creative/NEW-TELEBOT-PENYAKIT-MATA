<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Exports\BookingExport;
use App\Traits\RequestTrait;
use App\Traits\MakeComponents;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class TelegramController extends Controller
{
    use RequestTrait, MakeComponents;

    private $mainMenu = [
        ["History Diagnosa Saya"],
        ["Diagnosa Penyakit"],
    ];

    public function index()
    {
        $result = json_decode(file_get_contents('php://input'));
        $action = $result->message->text;
        $userId = $result->message->from->id;

        // Part
        
        if($action == "/start") {
            $text = "Selamat datang di Bot Telegram DETEKSI PENYAKIT MATA . Silahkan pilih menu di bawah ini: ";

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
