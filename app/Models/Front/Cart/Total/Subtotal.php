<?php

namespace App\Models\Front\Cart\Total;

use Illuminate\Support\Facades\Log;

/**
 * Class Subtotal
 * @package App\Models\Front\Cart\Total
 */
class Subtotal implements TotalInterface
{

    /**
     * @var
     */
    private $total;

    /**
     * @var array
     */
    private $cart;

    /**
     * @var string
     */
    private $coupon;


    /**
     * TotalInterface constructor.
     *
     * @param array       $cart
     * @param string|null $coupon
     */
    public function __construct(array $cart, $coupon)
    {
        $this->cart   = $cart;
        $this->coupon = $coupon;
    }


    /**
     * @param $total
     *
     * @return array
     */
    public function resolveTotal($total): array
    {
        // Implement situation if Tax is already in product price.

        $this->total = $total;

        $value = 0;

        Log::info($this->cart);
        Log::info($this->coupon);

        return [
            'code'       => $this->total->code,
            'title'      => $this->total->name,
            'value'      => $value,
            'sort_order' => $this->total->sort_order,
        ];
    }

}