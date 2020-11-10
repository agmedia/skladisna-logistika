<?php

namespace App\Models\Back\Orders;

use App\Models\Back\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
    public function make($request, $order_id)
    {
        $data     = json_decode($request->order_data);
        $products = $data->items;

        foreach ($products as $product) {
            $model     = $product->associatedModel;
            $org_price = $product->price;
            $discount  = null;

            if (isset($model->action) && ! empty($model->action)) {
                $org_price = intval($model->price);
                $discount  = $model->action->discount;

                if ($model->action->price) {
                    $discount = (($model->action->price / intval($model->price)) * 100) - 100;
                }

                Log::debug('Ušao u action');
                Log::debug($discount);
            }

            $id = $this->insertGetId([
                'order_id'   => $order_id,
                'product_id' => $product->id,
                'name'       => $product->name,
                'quantity'   => $product->quantity,
                'org_price'  => $org_price,
                'discount'   => $discount,
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
