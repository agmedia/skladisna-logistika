<?php

namespace App\Http\Controllers\Back\Settings\Store;

use App\Models\Back\Orders\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new OrderStatus())->newQuery();

        $order_statuses = $query->orderBy('sort_order')->paginate(config('settings.pagination.items'));

        return view('back.settings.store.order_status', compact('order_statuses'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request['data'])) {
            if (empty($request['data']['name'])) {
                return response()->json(['message' => 'Upišite ime statusa.']);
            }

            if (intval($request['data']['osid'])) {
                $os = OrderStatus::find($request['data']['osid']);
            } else {
                $os = new OrderStatus();
            }

            $os->name = $request['data']['name'];
            $os->sort_order = $request['data']['sort_order'];
            $os->save();

            return response()->json(['success' => 'Status narudžbe je uspješno snimljen.']);
        }

        return response()->json(['message' => 'Server error!']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            return response()->json(
                OrderStatus::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
