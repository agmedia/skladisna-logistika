<?php

namespace App\Models\Cart;


use Illuminate\Database\Eloquent\Model;

class CartDatabaseStorageModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'cart';

    /**
     * @var array
     */
    protected $fillable = ['id', 'cart_data'];


    /**
     * @param $value
     */
    public function setCartDataAttribute($value)
    {
        $this->attributes['cart_data'] = serialize($value);
    }


    /**
     * @param $value
     *
     * @return mixed
     */
    public function getCartDataAttribute($value)
    {
        return unserialize($value);
    }

}
