<?php

namespace App\Models\Back\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductAction extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_actions';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    /**
     * @return mixed
     */
    public static function active()
    {
        return self::where('date_start', '<', Carbon::now())
            ->orWhereNull('date_start')
            ->where('date_end', '>', Carbon::now())
            ->orWhereNull('date_end')
            ->with('product');
    }


    /**
     * @param $request
     * @param $id
     *
     * @return bool
     * @throws \Exception
     */
    public static function store($request)
    {
        if (isset($request->products)) {
            foreach ($request->products as $product) {
                // Delete, if any action exist
                self::where('product_id', $product)->delete();

                // Insert new action
                $_id = self::insertGetId([
                    'product_id' => $product,
                    'price'      => $request->price,
                    'discount'   => $request->discount,
                    'date_start' => new Carbon($request->date_start),
                    'date_end'   => new Carbon($request->date_end),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            return $_id;
        }

        return false;
    }
}
