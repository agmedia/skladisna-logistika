<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Front\Category\Category;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('front.checkout.cart');
    }


    public function checkout()
    {
        $user = auth()->user() ? auth()->user() : false;
        $payments = DB::table('app_payment_options')->where('status', 1)->orderBy('sort_order')->get();

        return view('front.checkout.index', compact('user', 'payments'));
    }
}
