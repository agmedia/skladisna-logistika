<?php

namespace App\Models\Front\Cart\Total;

interface TotalInterface
{

    /**
     * TotalInterface constructor.
     *
     * @param array       $cart
     * @param string|null $coupon
     */
    public function __construct(array $cart, $coupon);


    /**
     * @param $total
     *
     * @return array
     */
    public function resolveTotal($total): array;
}