<?php

namespace App\Models\Back\Orders;

use App\Models\Back\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    /**
     * @var string
     */
    protected $table = 'order_products';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->with('actions');
    }


    /**
     * @param $products
     * @param $order_id
     *
     * @return bool
     */
    public static function store($products, $order_id)
    {
        self::where('order_id', $order_id)->delete();

        foreach ($products as $product) {
            $id = self::insertGetId([
                'order_id'   => $order_id,
                'product_id' => $product->id,
                'name'       => $product->name,
                'quantity'   => $product->quantity,
                'price'      => $product->price,
                'total'      => $product->total,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        if ( ! $id) {
            return false;
        }

        return true;
    }


    /**
     * @param $products
     * @param $order_id
     *
     * @return bool
     */
    public static function make($products, $order_id)
    {
        foreach ($products as $product) {
            $id = self::insertGetId([
                'order_id'   => $order_id,
                'product_id' => $product->id,
                'name'       => $product->name,
                'quantity'   => $product->quantity,
                'price'      => $product->price,
                'total'      => $product->quantity * $product->price,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        if ( ! $id) {
            return false;
        }

        return true;
    }
}
