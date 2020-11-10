<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Front\AgCart;
use App\Models\Front\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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


    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct($id)
    {
        $product = Product::where('id', $id)->with('action')->first();
        $cat = isset($product->category()->slug) ? $product->category()->slug : '';
        $subcat = isset($product->subcategory()->slug) ? $product->subcategory()->slug : '';

        return response()->json([
            'id'              => $product->id,
            'name'            => $product->name,
            'price'           => $product->action ? $this->getActionPrice($product->price, $product->action) : $product->price,
            'quantity'        => 1,
            'associatedModel' => $product,
            'attributes' => [
                'url' => 'toyota-vilicari/' . $cat . '/' . $subcat . '/',
                'client' => $product->client
            ]
        ]);
    }


    /**
     * @param $price
     * @param $action
     *
     * @return string
     */
    private function getActionPrice($price, $action)
    {
        if (isset($action->price) && ! empty($action->price)) {
            return number_format($action->price, 2);
        }

        return number_format(($price - ($price * ($action->discount / 100))), 2);
    }
}
