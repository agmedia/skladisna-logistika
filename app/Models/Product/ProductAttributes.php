<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    
    //
    
    /**
     * @var string $table
     */
    protected $table = 'product_attributes';
    
    /**
     * @var array $guarded
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    /**
     * Creates new Product attributes.
     *
     * @param $request
     * @param $product_id
     *
     * @return array
     */
    public static function storeData($request, $product_id)
    {
        return self::create([
            'product_id'       => $product_id,
            'serial'           => $request->serial,
            'year'             => $request->year,
            'hours'            => $request->hours,
            'charger'          => $request->charger,
            'weight_capacity'  => $request->weight_capacity,
            'lift_height'      => $request->lift_height,
            'commision_height' => $request->commision_height,
            'battery'          => $request->battery,
            'speed'            => $request->speed,
            'application'      => $request->application,
            'width'            => $request->width,
            'options'          => $request->options,
            'center_mass'      => $request->center_mass,
            'radius'           => $request->radius,
            'wheels'           => $request->wheels,
            'engine'           => $request->engine,
            'tow_capacity'     => $request->tow_capacity,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);
    }
    
    
    /**
     * Update Product attributes.
     *
     * @param $request
     * @param $product_id
     *
     * @return array
     */
    public static function updateData($request, $product_id)
    {
        return self::where('product_id', $product_id)->update([
            'serial'           => $request->serial,
            'year'             => $request->year,
            'hours'            => $request->hours,
            'charger'          => $request->charger,
            'weight_capacity'  => $request->weight_capacity,
            'lift_height'      => $request->lift_height,
            'commision_height' => $request->commision_height,
            'battery'          => $request->battery,
            'speed'            => $request->speed,
            'application'      => $request->application,
            'width'            => $request->width,
            'options'          => $request->options,
            'center_mass'      => $request->center_mass,
            'radius'           => $request->radius,
            'wheels'           => $request->wheels,
            'engine'           => $request->engine,
            'tow_capacity'     => $request->tow_capacity,
            'updated_at'       => Carbon::now()
        ]);
    }
}
