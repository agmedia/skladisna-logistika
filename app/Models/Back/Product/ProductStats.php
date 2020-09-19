<?php

namespace App\Models\Back\Product;

use App\Models\Back\Chart;
use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Log;

class ProductStats extends Model
{

    /**
     * @param Request $request
     *
     * @return array
     */
    public static function getChartData(Request $request)
    {
        $user         = auth()->user();
        $chart        = new Chart($request);
        $query_params = $chart->setQueryParams();
        $orders_query = (new Order())->newQuery();
        $query        = (new OrderProduct())->newQuery();

        if (Bouncer::is($user)->an('editor')) {
            $query->whereIn('product_id', (new Product())->clients()->pluck('id'));
        }

        $orders = $orders_query->whereBetween('created_at', [$query_params['from'], $query_params['to']])->pluck('id');

        $query->whereIn('order_id', $orders);

        $products = $query->orderBy('created_at')
            ->get()
            ->groupBy(function ($val) {
                return $val->name;
            });

        return $chart->returnQueryData([], $products);
    }


    /**
     * @return array
     */
    public static function count()
    {
        return [
            'qty'   => (new Product())->clients()->count(),
            'href'  => route('products'),
            'label' => 'Proizvodi',
            'icon'  => 'si si-diamond'
        ];
    }


    /**
     * @return array
     */
    public static function actionsCount()
    {
        $query = (new ProductAction())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->whereIn('product_id', (new Product())->clients()->pluck('id'));
        }

        return [
            'qty'   => $query->count(),
            'href'  => route('actions'),
            'label' => 'Trenutno Akcija',
            'icon'  => 'si si-badge'
        ];
    }
}
