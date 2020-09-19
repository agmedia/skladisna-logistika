<?php

namespace App\Models\Back\Orders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderTotal extends Model
{

    /**
     * @var string
     */
    protected $table = 'order_total';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param $totals
     * @param $order_id
     *
     * @return bool
     */
    public static function store($totals, $order_id)
    {
        self::where('order_id', $order_id)->delete();

        $has_action = self::hasAction($totals);

        foreach ($totals as $total) {
            $sort_order = self::resolveSortOrder($total, $has_action);

            self::insertGetId([
                'order_id'   => $order_id,
                'code'       => $total->code,
                'title'      => $total->name,
                'value'      => $total->value,
                'sort_order' => $sort_order,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            if ($total->code == 'total') {
                Order::where('id', $order_id)->update([
                    'total' => $total->value
                ]);
            }
        }

        return true;
    }


    /**
     * @param $totals
     * @param $order_id
     *
     * @return bool
     */
    public static function make($products, $order_id, $shipping)
    {
        $total = 0;
        $ship = 0;

        foreach ($products as $product) {
            $total += $product->quantity * $product->price;
        }

        if ($shipping->sum < $shipping->min) {
            $ship = intval($shipping->shipping_price);
        }

        foreach (self::getTotals() as $code => $dbtotal) {
            self::insertGetId([
                'order_id'   => $order_id,
                'code'       => $code,
                'title'      => $dbtotal['title'],
                'value'      => $code == 'shipping' ? $ship : ($code == 'subtotal' ? $total : $total + $ship),
                'sort_order' => $dbtotal['sort'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        Order::where('id', $order_id)->update([
            'total' => $total + $ship
        ]);

        return true;
    }


    /**
     * @param $total
     * @param $action
     *
     * @return int
     */
    public static function resolveSortOrder($total, $action)
    {
        if ($total->code == 'subtotal') {
            return 0;
        }
        if ($action and $total->code == 'action') {
            return 1;
        }
        if ($total->code == 'shipping') {
            return $action ? 2 : 1;
        }
        if ($total->code == 'total') {
            return $action ? 3 : 2;
        }
    }


    /**
     * @param $totals
     *
     * @return bool
     */
    public static function hasAction($totals)
    {
        foreach ($totals as $total) {
            if ($total->code == 'action') {
                return true;
            }
        }

        return false;
    }


    public static function getTotals()
    {
        return [
            'subtotal' => [
                'title' => 'Ukupno',
                'sort' => 0
            ],
            'shipping' => [
                'title' => 'Poštarina',
                'sort' => 1
            ],
            'total' => [
                'title' => 'Sveukupno',
                'sort' => 2
            ]
        ];
    }
}
