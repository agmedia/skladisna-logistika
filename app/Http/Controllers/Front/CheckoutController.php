<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\OrderReceived;
use App\Mail\OrderSent;
use App\Models\Back\Orders\Order;
use App\Models\Front\AgCart;
use App\Models\Front\Category\Category;
use App\Models\Front\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function proccessOrder(Request $request)
    {
        $order = new Order();
        $clients = $order->validateMakeRequest($request)->resolveClients();
        $shipping = $order->resolveClientShipping();

        $order->pay();

        foreach ($clients as $client_id => $items) {
            $response[$client_id] = $order->make($client_id, $items, $shipping[$client_id]);

            /*$client = Client::find($client_id);
            Mail::to($client->email)->send(new OrderReceived($response[$client_id]));*/
        }

        /*$customer = auth()->user() ? auth()->user() : $request->input('email');
        Mail::to($customer->email)->send(new OrderSent($response));*/

        if (auth()->user()) {
            $cart = new AgCart(auth()->user()->id);
            $cart->flush();
        }

        return redirect()->route('narudzba.ok');
    }


    public function success()
    {
        return view('front.checkout.success');
    }


    public function error()
    {
        return view('front.checkout.error');
    }
}
