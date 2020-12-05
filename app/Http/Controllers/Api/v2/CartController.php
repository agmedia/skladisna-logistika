<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
                $this->resolveSession();
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
        $response = $this->cart->get();
        
        $this->resolveDB($response);
        
        return response()->json($response);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $response = $this->cart->add($request);
    
        $this->resolveDB($response);
    
        return response()->json($response);
    }


    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $response = $this->cart->add($request, $id);
    
        $this->resolveDB($response);
    
        return response()->json($response);
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $response = $this->cart->remove($id);
    
        $this->resolveDB($response);
    
        return response()->json($response);
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
    
    
    /**
     * Resolve new cart session.
     * If user is logged, check the DB for cart session entries.
     */
    private function resolveSession()
    {
        $sl_cart_id = Str::random(8);
        $this->cart = new AgCart($sl_cart_id);
        session(['sl_cart_id' => $sl_cart_id]);
        
        if (Auth::user()) {
            $has_cart = Cart::where('user_id', Auth::user()->id)->first();
        
            if ($has_cart) {
                $cart_data = json_decode(json_encode($has_cart->cart_data));
    
                foreach ($cart_data->items as $item) {
                    $this->cart->add($this->cart->resolveItemRequest($item));
                }
                
                if ( ! empty($cart_data->coupon)) {
                    $this->cart->coupon($cart_data->coupon);
                }
                
                $has_cart->update(['session_id' => $sl_cart_id]);
            }
        }
    }
    
    
    /**
     * If user is logged store or update the DB session.
     *
     * @param $response
     */
    private function resolveDB($response)
    {
        if (Auth::user()) {
            // Queue the storage of cart data.
            dispatch(function () use ($response) {
                $has_cart = Cart::where('user_id', Auth::user()->id)->first();
    
                if ($has_cart) {
                    Cart::edit($response);
                } else {
                    Cart::store($response);
                }
            });
        }
    }
}
