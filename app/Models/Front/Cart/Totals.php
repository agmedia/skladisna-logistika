<?php

namespace App\Models\Front\Cart;

require_once('Total/providers.php');

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class Total
 * @package App\Models\Front\Cart
 */
class Totals extends Model
{

    /**
     * @var string
     */
    protected $table = 'totals';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var
     */
    public $cart;

    /**
     * @var
     */
    protected $coupon;

    /**
     * @var
     */
    protected $totals;


    /**
     * Total constructor.
     *
     * @param string $code
     * @param        $cart
     */
    public function setParams($cart)
    {
        $this->cart = $cart;
        $this->coupon = $this->setCoupon();
    }


    /**
     * @param $value
     *
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return unserialize($value);
    }


    /**
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }


    /**
     * @return array
     */
    public function fetch()
    {
        $response = [];

        foreach ($this->totals as $total) {
            // Load class from providers array based on total code.
            $class = providers($total->code);
            // Instantiate new class with cart and coupon.
            $instance = new $class($this->cart, $this->coupon);

            $response[$total->code] = $instance->resolveTotal($total);
        }

        return $response;
    }


    /**
     * @return bool
     */
    public function hasActive(): bool
    {
        $this->totals = $this->where('status', 1)->orderBy('sort_order')->get();

        return $this->totals->count() ? true : false;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|null
     */
    private function setCoupon()
    {
        return session()->has('sl_cart_coupon') ? session('sl_cart_coupon') : null;
    }
}