<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Front\AgCart;
use App\Models\Front\Product;
use App\Models\Product\ProductAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{

    /**
     * @var Auth
     */
    protected $user;

    /**
     * @var
     */
    protected $cart;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (session()->has('sl_cart_id')) {
                $this->cart = new AgCart(session('sl_cart_id'));

            } else {
                $sl_cart_id = Str::random(8);
                $this->cart = new AgCart($sl_cart_id);

                session(['sl_cart_id' => $sl_cart_id]);
            }

            return $next($request);
        });
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get()
    {
        return response()->json($this->cart->get());
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        return response()->json($this->cart->add($request));
    }


    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->cart->add($request, $id));
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        return response()->json($this->cart->remove($id));
    }


    /**
     * @param $coupon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function coupon($coupon)
    {
        session(['sl_cart_coupon' => $coupon]);

        return response()->json($this->cart->coupon($coupon));
    }
}
