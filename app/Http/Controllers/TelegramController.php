<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Traits\RequestTrait;
use App\Traits\MakeComponents;

class TelegramController extends Controller
{
    use RequestTrait, MakeComponents;

    public function index()
    {
        $result = json_decode(file_get_contents('php://input'));
        $action = $result->message->text;
        $userId = $result->message->from->id;

        if($action == '/start') {
            $text = "Silahkan pilih menu di bawah ini:";
            $option = [
                ['Cek Service'],
                ['Cek Spare Part'],
                ['Booking Service'],
            ];

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($option),
            ]);
        }

        if($action == '/test') {
           $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => 'test terrrooooosss!!',
               //  'reply_markup' => $this->keyboardBtn($option),
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
