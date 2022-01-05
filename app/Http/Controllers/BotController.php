<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bot.index');
    }

    public function setwebhook(Request $request)
    {
        $result = $this->sendTelegramData('setWebhook', ['query' => ['url' => 'https://totxbot.ru/' . \Telegram::getAccessToken() . '/webhook']]);
        return redirect()->route('bot')->with('status', $result);
    }

    public function getwebhookinfo(Request $request)
    {
        $result = $this->sendTelegramData('getWebhookInfo');
        return redirect()->route('bot')->with('status', $result);
    }

    public function sendTelegramData($route = '', $params = [], $method = 'POST')
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.telegram.org/bot' . \Telegram::getAccessToken() . '/']);
        $result = $client->request($method, $route, $params);
        return (string)$result->getBody();
    }

    public function testTocken()
    {
        $response = Telegram::getMe();
        /*    $response=\Telegram::listenersMessage(['chat_id' => '@testTotxTest',
                   'text' => 'Hello World']);*/
        /* $result = $this->sendTelegramData('setWebhook', ['query' => ['url' => 'https://totxbot.ru/' . \Telegram::getAccessToken()]]);*/
        // $result = $this->sendTelegramData('getWebhookInfo');

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();
        return $this->sendTelegramData('getWebhookInfo');
        //dump($response);exit;
       // return redirect()->route('bot')->with('status', $response);
    }

    public function updatedActivity()
    {

        //$result = \Telegram::getUpdates();
        //$result = $this->sendTelegramData('deleteWebhook');
        // $this->sendTelegramData('setWebhook', ['query' => ['url' => 'https://totxbot.ru/' . \Telegram::getAccessToken() . '/webhook']]);
        //dump($result);exit;
       return $this->sendTelegramData('getWebhookInfo');
    }

}
