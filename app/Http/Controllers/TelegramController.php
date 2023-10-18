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

        $arrGejala = [];

        // List Gejala
        $gejala = Gejala::where('status' , 'Aktif')->get();

        foreach ($gejala as $item) {
           $arrGejala[] = $item->nama_gejala;
        }

        
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

        // Check Pertanyan YA
        }else if ($action == "Ya"){

            $text = "Silahkan pilih gajala penyakit yang anda rasakan : \n";

            $gejala = Gejala::where('status' , 'Aktif')->get();

            foreach ($gejala as $gejala) {
              $gejalaKeyboard[] = [$gejala->nama_gejala];
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($gejalaKeyboard),
            ]);

        // Check Pertanyan Tidak sekaligus Result
        }else if ($action == "Tidak"){

          $listIdGejala = [];
          $idPenyakit = [];
          $penyakitGejala = [];

          // Cari History Berdasarkan Chat Id
          $diagnosa = Diagnosa::where('chat_id' , $userId)->first();

          $totalGejala = count(json_decode($diagnosa->record_gejala));

          foreach (json_decode($diagnosa->record_gejala) as $namaGejala) {
              $gejala = Gejala::where('nama_gejala' , $namaGejala)->first();

              if (!in_array($gejala->id , $listIdGejala)) {
                 $listIdGejala[] = $gejala->id;
              }
          }

          foreach ($listIdGejala as $idGejala) {
              $data = PenyakitGejala::where('id_gejala' , $idGejala)->get();

              foreach ($data as $item) {
                  if (!in_array($item->id_penyakit, $idPenyakit)) {
                      $idPenyakit[] = $item->id_penyakit;
                  }

                  $penyakitGejala[] = $item->id_penyakit;
              }
          }

          $probPenyakit = array_count_values($penyakitGejala);

          foreach ($probPenyakit as $key => $value) {
              $persentase = ($value / $totalGejala) * 100;
              $probPenyakit[$key] = round($persentase);
          }

          foreach ($probPenyakit as $key => $value) {
            $penyakit = Penyakit::where('id' , $key)->first();
            $diagnosaPenyakit[$penyakit->nama_penyakit] = $value."%";
          }

          $diagnosa->record_penyakit = json_encode($diagnosaPenyakit);
          $diagnosa->save();

          $text = "Berikut hasil diagnosa penyakit mata yang anda alami sesuai gejala yang anda inputkan \n\n";
          $text .= "GEJALA ANDA: \n";

          foreach (json_decode($diagnosa->record_gejala) as $namaGejala) {
              $text .= "- " . $namaGejala . "\n";
          }

          $text .= "\n\n";
          $text .= "DIAGNOSA PENYAKIT ANDA :\n";
          
          foreach ($diagnosaPenyakit as $key => $value) {
            $text .= "- " . $key . " : " . $value . "\n";
          }

          $text .= "\n\n";
          $text .= "Hasil diagnosa merupakan prakiraan penyakit berdasarkan diagnosa yang anda inputkan dengan menggunakan metode NAIVE BAYES\n\n";
          $text .= "Untuk hasil yang lebih akurat, anda dapat mengunjungi Klinik Mata Terdekat di sekitar anda.";



          $this->apiRequest('sendMessage', [
              'chat_id' => $userId,
              'text' => $text,
              'reply_markup' => $this->keyboardBtn($this->mainMenu),
          ]);


        // Check Gejala
        }else if (in_array($action, $arrGejala)){
            $diagnosa = Diagnosa::where('chat_id' , $userId)->first();

            if ($diagnosa->record_gejala != null) {
              $inputGejala = json_decode($diagnosa->record_gejala);
              $inputGejala[] = $action;
            }else{
              $inputGejala[] = $action;
            }

            $diagnosa->record_gejala = json_encode($inputGejala);
            $diagnosa->save();

            $text = "Apakah ada gejala lain yang anda rasakan ?";

            $Optionkeyboard = [
              ["Ya"],
              ["Tidak"],
            ];

            $this->apiRequest('sendMessage', [
              'chat_id' => $userId,
              'text' => $text,
              'reply_markup' => $this->keyboardBtn($Optionkeyboard),
          ]);
        
        // Response Setelah Memasukan Biodata
        }else if(strpos($action, '#') == true){
          $customerData = explode("#", $action);

          $diagnosa = new Diagnosa;
          $diagnosa->chat_id = $userId;
          $diagnosa->nama = $customerData[0];
          $diagnosa->umur = $customerData[1];
          $diagnosa->jenis_kelamin = $customerData[2];
          $diagnosa->nomor_telephone = $customerData[3];
          $diagnosa->save();

          $text = "Data diri anda berhasil disimpan \n";
          $text .= "Silahkan pilih gajala penyakit yang anda rasakan : \n";

          $gejala = Gejala::where('status' , 'Aktif')->get();

          foreach ($gejala as $gejala) {
            $gejalaKeyboard[] = [$gejala->nama_gejala];
          }


          $this->apiRequest('sendMessage', [
              'chat_id' => $userId,
              'text' => $text,
              'reply_markup' => $this->keyboardBtn($gejalaKeyboard),
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
