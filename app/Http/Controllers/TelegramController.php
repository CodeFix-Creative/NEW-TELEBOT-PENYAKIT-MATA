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
        ["My Diagnosis History"],
        ["Disease Diagnosis"],
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
            $text = "Welcome to the EYE DISEASE DETECTION Telegram Bot. Please select the menu below: ";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);
        
        // Response History Diagnosa Saya
        }else if ($action == "My Diagnosis History"){
            $text = "You select the My Diagnosis History menu \n";
            $text .= "Please tell us the telephone number you have entered :";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);

        // Response Diagnosa Penyakit
        }else if ($action == "Disease Diagnosis"){
            $text = "You select the Disease Diagnosis menu \n";
            $text .= "Please tell us your personal details first. \n";
            $text .= "Full Name#Your Age#Gender#Telephone Number\n\n";
            $text .= "Example\n";
            $text .= "Tifani Angga#23#L#081231XXXXXXX\n\n";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);

        // Check Pertanyan YA
        }else if ($action == "Yes"){

            $text = "Please select the symptoms of the disease you feel : \n";

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
        }else if ($action == "No"){

          $listIdGejala = [];
          $idPenyakit = [];
          $penyakitGejala = [];

          // Cari History Berdasarkan Chat Id
          $diagnosa = Diagnosa::where('chat_id' , $userId)->orderBy('created_at' , 'DESC')->first();

          // $totalGejala = count(json_decode($diagnosa->record_gejala));
          $diagnosaGejala = [];
          $diagnosaPenyakit = [];

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

                  if (!empty($diagnosaPenyakit)) {
                    $idPenyakitinArray  = array_column($diagnosaPenyakit, 'id_penyakit');

                    if (in_array($data->penyakit->id, $idPenyakitinArray)) {
                        foreach ($diagnosaPenyakit as $key => $value) {
                          if($value['id_penyakit'] == $data->penyakit->id){
                            $Prob = $value['total_probabilitas'];
                            $value['total_probabilitas'] = $Prob + $totalBagi;
                            $value['persentase'] = $value['total_probabilitas'] * 100;
                            foreach ($value as $subkey => $item) {
                                if ($subkey == 'total_probabilitas') {
                                    $diagnosaPenyakit[$key][$subkey] = $Prob + $totalBagi;
                                }
                                if ($subkey == 'persentase') {
                                    $diagnosaPenyakit[$key][$subkey] = $value['total_probabilitas'] * 100;
                                }
                            }
                            // dd($diagnosaPenyakit , $totalBagi , $value['total_probabilitas'] , $value['persentase']);
                            }
                        }
                    }else{
                        $diagnosaPenyakit[] = [
                          'id_penyakit' => $data->penyakit->id,
                          'total_probabilitas' => $totalBagi,
                          'persentase' => $totalBagi * 100,
                      ];
                    }
                  }else{
                    $diagnosaPenyakit[] = [
                        'id_penyakit' => $data->penyakit->id,
                        'total_probabilitas' => $totalBagi,
                        'persentase' => $totalBagi * 100,
                    ];
                  }
              }

              

              $diagnosaPenyakitFinal = [];
              $JumGejala = count(json_decode($diagnosa->record_gejala));

              // Check Penyakit Paling Tinggi
              $probailitasTertinggi = 0;
              foreach ($diagnosaPenyakit as $data) {
                $probBefore = $data['total_probabilitas'];
                $probNow = $data['total_probabilitas'] / $JumGejala;
                if($probNow > $probailitasTertinggi){
                    $probailitasTertinggi = $probNow;
                    $diagnosaPenyakitFinal = [
                        'id_penyakit' => $data['id_penyakit'],
                        'total_probabilitas' => $probBefore,
                        'persentase' => $probNow * 100,
                    ]; 
                }
              }
          }

          $diagnosa->record_penyakit = json_encode($diagnosaPenyakitFinal);
          $diagnosa->save();

          $text = "Here are the results of your eye disease diagnosis according to the symptoms you selected \n\n";
          $text .= "YOUR SYMPTOMS: \n";

          foreach (json_decode($diagnosa->record_gejala) as $namaGejala) {
              $text .= "- " . $namaGejala . "\n";
          }

          $text .= "\n\n";
          $text .= "DIAGNOSIS OF YOUR DISEASE :\n";
          
          $penyakit = Penyakit::where('id' , $diagnosaPenyakitFinal['id_penyakit'])->first();
          $namaPenyakit = $penyakit->nama_penyakit;
          $solusi = $penyakit->solusi;
          $penyebab = $penyakit->penyebab;
          $probabilitas = $diagnosaPenyakitFinal['total_probabilitas'];
          $persentase = $diagnosaPenyakitFinal['persentase'];

          // $text .= "Penyakit yang anda derita dari gejala yang anda beritahukan adalah " . $namaPenyakit . " dengan probabilitas sebesar " . $probabilitas . " atau " . $persentase . "% \n\n";
          $text .= "The diseases you suffer from the symptoms you have described are " . $namaPenyakit . " with a percentage of " . $persentase . "% \n\n";

          $text .= "The cause is " . $penyebab . "\n\n";

          $text .= "Solutions that can be done are " . $solusi;



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

            $text = "Do you have any other symptoms?";

            $Optionkeyboard = [
              ["Yes"],
              ["No"],
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

          $text = "Your personal data has been successfully saved \n";
          $text .= "Please select the symptoms of the disease you feel : \n";

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

            $text = "Here is the last history of your diagnosis \n\n";

            $text .= "YOUR SYMPTOMS : \n";
            foreach (json_decode($diagnosa->record_gejala) as $gejala) {
                $text .= "- " . $gejala . "\n";
            }

            $text .= "\n\n";
            $text .= "DIAGNOSE YOUR DISEASE : \n";

            foreach (json_decode($diagnosa->record_penyakit) as $key => $value) {
                if ($key == 'id_penyakit') {
                  $penyakit = Penyakit::find($value);
                  $text .= "- Your illness" . " : " . $penyakit->nama_penyakit . "\n";
                }

                // if ($key == 'total_probabilitas') {
                //   $text .= "- Probabilitas" . " : " . $value . "\n";
                // }

                if ($key == 'persentase') {
                  $text .= "- Percentage of Diagnosis" . " : " . $value . "%\n";
                }
            }

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);

        // Check History Diagnosa Kalau Tidak Ada
        }else if (Diagnosa::where('nomor_telephone' , $action)->exists() == false){
            $text = "You don't have a history of disease diagnosis \n";
            $text .= "Please consult your disease diagnosis first";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($this->mainMenu),
            ]);

        
        } else {
            $text = "Sorry, your input is wrong, please input according to the format or please select the menu below: ";

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
