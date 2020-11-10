<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\OrderReceived;
use App\Mail\OrderSent;
use App\Models\Back\Orders\Order;
use App\Models\Front\AgCart;
use App\Models\Front\Category\Category;
use App\Models\Front\Client;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $response = $order->validateMakeRequest($request)->make();

        $pdf = PDF::loadView('pdfs.offer', ['order' => $response])->output();

        if ($response) {
            Mail::to(config('mail.admin'))->send(new OrderReceived($response));
            Mail::to($request->input('email'))->send(new OrderSent($response, $pdf));

            if (auth()->user()) {
                $cart = new AgCart(auth()->user()->id);
                $cart->flush();
            }

            return redirect()->route('narudzba.ok');
        }

        return redirect()->route('narudzba.error');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('front.checkout.success');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error()
    {
        return view('front.checkout.error');
    }
}
