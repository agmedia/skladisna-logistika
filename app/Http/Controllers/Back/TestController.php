<?php

namespace App\Http\Controllers\Back;


use App\Http\Controllers\Controller;
use Bouncer;
use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://serviceapp.skladisna-logistika.hr/external/',
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'form_params' => array(
                'param1' => $order_id,
                'param2' => 'wpDNE',
                'country_code' => 'HR'
            ),
            'cookies' => array()
        ]);
        $result = $client->request('POST', 'getOrderDataForWeb');

        dd('Rezultat za narudžbu ' . $order_id, json_decode($result->getBody()->getContents(), true));

        return view('back.test', compact('result'));
    }

}
