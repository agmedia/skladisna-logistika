<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    
    /**
     * @var string
     */
    protected $table = 'carts';
    
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function getCartDataAttribute($value)
    {
        return unserialize($value);
    }
    
    
    /**
     * @param $value
     */
    public function setCartDataAttribute($value)
    {
        $this->attributes['cart_data'] = serialize($value);
    }
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public static function store($request)
    {
        return self::create([
            'user_id'    => Auth::user()->id,
            'session_id' => session('sl_cart_id'),
            'cart_data'  => $request
        ]);
    }
    
    
    /**
     * @param array $request
     *
     * @return bool
     */
    public static function edit($request)
    {
        return self::where('user_id', Auth::user()->id)->update([
            'cart_data'  => serialize($request),
            'updated_at' => Carbon::now()
        ]);
    }
}
