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
     * @param $request
     * @param $order_id
     *
     * @return bool
     */
    public function make($request, $order_id)
    {
        $totals = collect(config('settings.totals'))->where('status', 1)->sortBy('sort_order');
        $sum = 0;

        foreach ($totals as $code => $total) {
            $value = $this->returnTotalValue($request, $code);

            if ($value) {
                $sum += $value;
            }

            if ($code == 'tax') {
                $value = $this->getTax($sum);
                $sum += $value;
            }

            if ($code == 'total') {
                $value = $sum;
            }

            $this->insertGetId([
                'order_id'   => $order_id,
                'code'       => $code,
                'title'      => $total['title'],
                'value'      => $value,
                'sort_order' => $total['sort_order'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        Order::where('id', $order_id)->update([
            'total' => $sum
        ]);

        return true;
    }


    /**
     * @param        $request
     * @param string $code
     *
     * @return false|float|int
     */
    public function returnTotalValue($request, string $code)
    {
        $data = json_decode($request->order_data);

        if ($code == 'subtotal') {
            return $this->getSubtotal($data->items);
        }

        if ($code == 'discount') {
            return $this->getDiscount($data->items);
        }

        if ($code == 'shipping') {
            return $this->getShipping($data->shipping);
        }

        return false;
    }


    /**
     * @param $products
     *
     * @return int
     */
    public function getSubtotal($products)
    {
        $subtotal = 0;

        foreach ($products as $product) {
            $subtotal += intval($product->associatedModel->price);
        }

        return $subtotal;
    }


    /**
     * @param $products
     *
     * @return float|int
     */
    public function getDiscount($products)
    {
        $discount = 0;

        foreach ($products as $product) {
            $mod = $product->associatedModel;

            if (isset($mod->action) && ! empty($mod->action)) {
                if ($mod->action->price) {
                    $discount += intval($mod->price) - intval($mod->action->price);
                } else {
                    $discount += intval($mod->price) * ($mod->action->discount / 100);
                }
            }
        }

        return -$discount;
    }


    /**
     * @param $shipping
     *
     * @return int
     */
    public function getShipping($shipping)
    {
        return ($shipping == 'shipping') ? 0 : $shipping;
    }


    /**
     * @param $products
     *
     * @return float|int
     */
    public function getTax($amount)
    {
        return $amount * (config('settings.tax') / 100);
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

}
