<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //   $telegram = new Api(env("TELEGRAM_BOT_TOKEN"));
        $telegram = new Api('6685862400:AAF3wbM8xJv4u0us9VKu-Pf1hmEWW-M5Mes');

        //  dd($response = $telegram->getMe());

        //  $response = $telegram->getUpdates();

         // $response = Telegram::getWebhookUpdates();

         // $response = Telegram::getMe();

         $response = $telegram->removeWebhook();

         $response = Telegram::getUpdates();

        //  $response = $telegram->setWebhook([
        //     'url' => url(route('webhook')),
        //     // 'certificate' => '/path/to/public_key_certificate.pub'
        //  ]);
         
        //  $response = Telegram::getWebhookInfo();

        $telegram->sendMessage([
          'chat_id' => 1144046082,
          'text' => 'Hello Taufik'
        ]);

         dd($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
