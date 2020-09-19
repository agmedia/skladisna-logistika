<?php

namespace App\Models\Cart;


use Darryldecode\Cart\CartCollection;
use Illuminate\Support\Facades\Log;

class CartDBStorage
{

    /**
     * @param $key
     *
     * @return mixed
     */
    public function has($key)
    {
        return CartDatabaseStorageModel::find($key);
    }


    /**
     * @param $key
     *
     * @return array|CartCollection
     */
    public function get($key)
    {
        Log::info('CartDBStorage->get($key)');
        Log::info($key);
        Log::info($this->has($key));


        if ($this->has($key)) {
            return CartDatabaseStorageModel::find($key)->cart_data;
        }

        return [];
    }


    /**
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        Log::info('CartDBStorage->put($key, $value)');
        Log::info($key);
        Log::info($value);


        if ($row = CartDatabaseStorageModel::find($key)) {
            $row->cart_data = $value;
        }

        CartDatabaseStorageModel::create([
            'id'        => $key,
            'cart_data' => $value
        ]);
    }

}
