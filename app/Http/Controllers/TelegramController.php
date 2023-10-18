<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\PenyakitGejala;
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

        
        // Inisiasi Reply
        if($action == "/start") {
            $text = "Selamat datang di Bot Telegram DETEKSI PENYAKIT MATA . Silahkan pilih menu di bawah ini: ";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);
        
        // Response History Diagnosa Saya
        }else if ($action == "History Diagnosa Saya"){
            $text = "Anda memilih menu History Diagnosa Saya \n";
            $text .= "Silahkan beritahu kami nomor telephone yang pernah anda masukan :";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);

        // Response Diagnosa Penyakit
        }else if ($action == "Diagnosa Penyakit"){
            $text = "Anda memilih menu Diagnosa Penyakit \n";
            $text .= "Silahkan beritahu kami data diri anda terlebih dahulu \n";
            $text .= "Nama Lengkap#Umur Anda#Jenis Kelamin#NomorTelephone\n\n";
            $text .= "Contoh\n";
            $text .= "Tifani Angga#23#L#081231XXXXXXX\n\n";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);

        // Response Setelah Memasukan Biodata
        }else if(strpos($action, '#') == true){
          $customerData = explode("#", $action);

          $diagnosa = new Diagnosa;
          $diagnosa->nama = $customerData[0];
          $diagnosa->umur = $customerData[1];
          $diagnosa->jenis_kelamin = $customerData[2];
          $diagnosa->nomor_telephone = $customerData[3];
          $diagnosa->save();

          $text = "Data diri anda berhasil disimpan \n";
          $text .= "Silahkan pilih gajala penyakit yang anda rasakan : \n";

          $gejala = Gejala::where('status' , 'Aktif')->get();

          $gejalaKeyboard[] = [$gejala->nama_gejala];

          $this->apiRequest('sendMessage', [
              'chat_id' => $userId,
              'text' => $text,
              'reply_markup' => $this->keyboardBtn($this->mainMenu),
          ]);

        // Check History Diagnosa Kalau Ada
        }else if (Diagnosa::where('nomor_telephone' , $action)->exists() == true){
            $text = "Berikut Adalah History terakhir diagnosa penyakit anda \n";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);

        // Check History Diagnosa Kalau Tidak Ada
        }else if (Diagnosa::where('nomor_telephone' , $action)->exists() == false){
            $text = "Anda belum memiliki history diagnosa penyakit \n";
            $text .= "Silahkan lakukan konsultasi diagnosa penyakit anda terlebih dahulu";

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
