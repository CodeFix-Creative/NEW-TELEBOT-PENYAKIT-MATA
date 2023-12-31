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
          $diagnosa = Diagnosa::where('chat_id' , $userId)->orderBy('created_at' , 'DESC')->first();

          // $totalGejala = count(json_decode($diagnosa->record_gejala));
          $diagnosaGejala = [];

          foreach (json_decode($diagnosa->record_gejala) as $namaGejala) {
              $gejala = Gejala::where('nama_gejala' , $namaGejala)->first();
              $penyakitGejala = PenyakitGejala::where('id_gejala' , $gejala->id)->get();

              $diagnosaGejala[] = $gejala->nama_gejala;

              $jumlahAtas = 0;
              $jumlahBawah = 0;

              // Hitungan Bawah Selalu Sama
              foreach ($penyakitGejala as $data) {
                  $jumlahBawah += $data->bobot * $data->penyakit->score;
              }
              
              // Hitungan Atas
              foreach ($penyakitGejala as $data) {
                  $jumlahAtas = $data->bobot * $data->penyakit->score;
                  $totalBagi = round($jumlahAtas / $jumlahBawah , 3);

                  $diagnosaPenyakit[] = [
                      'id_penyakit' => $data->penyakit->id,
                      'total_probabilitas' => $totalBagi,
                      'persentase' => $totalBagi * 100,
                  ];
              }

              

              $diagnosaPenyakitFinal = [];

              // Check Penyakit Paling Tinggi
              $persentaseTertinggi = 0;
              foreach ($diagnosaPenyakit as $data) {

                if($data['persentase'] > $persentaseTertinggi){
                    $persentaseTertinggi = $data['persentase'];
                    $diagnosaPenyakitFinal = [
                        'id_penyakit' => $data['id_penyakit'],
                        'total_probabilitas' => $data['total_probabilitas'],
                        'persentase' => $data['persentase'] . "%",
                    ]; 
                }
              }
          }

          $diagnosa->record_penyakit = json_encode($diagnosaPenyakitFinal);
          $diagnosa->save();

          $text = "Berikut hasil diagnosa penyakit mata yang anda alami sesuai gejala yang anda inputkan \n\n";
          $text .= "GEJALA ANDA: \n";

          foreach (json_decode($diagnosa->record_gejala) as $namaGejala) {
              $text .= "- " . $namaGejala . "\n";
          }

          $text .= "\n\n";
          $text .= "DIAGNOSA PENYAKIT ANDA :\n";
          
          $penyakit = Penyakit::where('id' , $diagnosaPenyakitFinal['id_penyakit'])->first();
          $namaPenyakit = $penyakit->nama_penyakit;
          $solusi = $penyakit->solusi;
          $penyebab = $penyakit->penyebab;
          $probabilitas = $diagnosaPenyakitFinal['total_probabilitas'];
          $persentase = $diagnosaPenyakitFinal['persentase'];

          $text .= "Penyakit yang anda derita dari gejala yang anda beritahukan adalah " . $namaPenyakit . " dengan probabilitas sebesar " . $probabilitas . " atau " . $persentase . "\n\n";

          $text .= "Penyebabnya adalah " . $penyebab . "\n\n";

          $text .= "Solusi yang dapat di lakukan adalah " . $solusi;



          $this->apiRequest('sendMessage', [
              'chat_id' => $userId,
              'text' => $text,
              'reply_markup' => $this->keyboardBtn($this->mainMenu),
          ]);


        // Check Gejala
        }else if (in_array($action, $arrGejala)){
            $diagnosa = Diagnosa::where('chat_id' , $userId)->orderBy('created_at' , 'DESC')->first();

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

            // Record Diagnosa
            $diagnosa = Diagnosa::where('nomor_telephone' , $action)->where('record_penyakit', '!=' , null)->orderBy('created_at' , 'DESC')->first();

            $text = "Berikut Adalah History terakhir diagnosa penyakit anda \n\n";

            $text .= "GEJALA ANDA : \n";
            foreach (json_decode($diagnosa->record_gejala) as $gejala) {
                $text .= "- " . $gejala . "\n";
            }

            $text .= "\n\n";
            $text .= "DIAGNOSA PENYAKIT ANDA : \n";

            foreach (json_decode($diagnosa->record_penyakit) as $key => $value) {
                $text .= "- " . $key . " : " . $value . "\n";
            }

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
