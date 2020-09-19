<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Front\AgCart;
use App\Models\Front\Product;
use Cart;
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
            if (Auth::user()) {
                $this->user         = Auth::user();
                $this->user->logged = true;
                $this->cart         = new AgCart($this->user->id);
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getUser()
    {
        return response()->json($this->user);
    }


    public function getProduct($id)
    {
        $product = Product::where('id', $id)->with('action', 'client')->first();

        return response()->json([
            'id'              => $product->id,
            'name'            => $product->name,
            'price'           => $product->action ? $this->getActionPrice($product->price, $product->action) : $product->price,
            'quantity'        => 1,
            'associatedModel' => $product,
            'attributes' => [
                'url' => Str::slug($product->clientAsArray()->name) . '/' . $product->category()->slug . '/' . $product->subcategory()->slug . '/',
                'client' => $product->client
            ]
        ]);
    }


    private function getActionPrice($price, $action)
    {
        return number_format(($price - ($price * ($action->discount / 100))), 2);
    }
}
