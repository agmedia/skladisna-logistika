<?php

namespace App\Models\Front;


use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AgCart extends Model
{

    private $cart_id;

    /**
     * @var
     */
    private $cart;


    /**
     * AgCart constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->cart_id = $id;
        $this->cart = Cart::session($id);
    }


    /**
     * @return array
     */
    public function get()
    {
        return [
            'items'      => $this->cart->getContent(),
            'count'      => $this->cart->getTotalQuantity(),
            'subtotal'   => $this->cart->getSubTotal(),
            'conditions' => $this->cart->getConditions(),
            'total'      => $this->cart->getTotal(),
        ];
    }


    /**
     * @param      $request
     * @param null $id
     *
     * @return array
     */
    public function add($request, $id = null)
    {
        Log::debug('AgCart::add');
        Log::debug($request);
        Log::debug($id);

        if ($id) {
            foreach ($this->cart->getContent() as $item) {
                if ($item->id == $request['item']['id']) {
                    return $this->updateCartItem($item->id, $request);
                }
            }
        }

        return $this->addToCart($request);
    }


    /**
     * @param $id
     *
     * @return array
     */
    public function remove($id)
    {
        $this->cart->remove($id);

        return $this->get();
    }


    /**
     *
     * @return array
     */
    public function flush()
    {
        return $this->cart->clear();
    }


    /**
     * @param $request
     *
     * @return array
     */
    private function addToCart($request): array
    {
        $this->cart->add($this->structureCart($request));

        return $this->get();
    }


    /**
     * @param $id
     * @param $request
     *
     * @return array
     */
    private function updateCartItem($id, $request): array
    {
        $this->cart->update($id, [
            'quantity' => [
                'relative' => false,
                'value'    => $request['item']['quantity']
            ],
        ]);

        return $this->get();
    }


    /**
     * @param $request
     *
     * @return array
     */
    private function structureCart($request)
    {
        $product = Product::where('id', $request['item']['id'])->first();
        $cat = isset($product->category()->slug) ? $product->category()->slug : '';
        $subcat = isset($product->subcategory()->slug) ? $product->subcategory()->slug : '';

        return [
            'id'              => $product->id,
            'name'            => $product->name,
            'price'           => $product->action ? $this->getActionPrice($product->price, $product->action) : $product->price,
            'quantity'        => $request['item']['quantity'],
            'associatedModel' => $product,
            'attributes' => [
                'url' => 'toyota-vilicari/' . $cat . '/' . $subcat . '/',
                'client' => $product->client
            ]
        ];
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
            return number_format($action->price, 2, '.', '');
        }

        return number_format(($price - ($price * ($action->discount / 100))), 2, '.', '');
    }

}
