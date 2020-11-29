<?php

namespace App\Http\Controllers\Back\Orders;

use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\OrderStatus;
use App\Models\Back\Users\Client;
use App\Models\Helpers\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Bouncer;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Order())->newQuery();

        if ($request->has('payment')) {
            $query->where('payment_method', $request->input('payment'));
        }

        if ($request->has('from')) {
            $query->whereDate('created_at', '>=', Carbon::createFromFormat('d.m.Y.', $request->input('from')));
        }

        if ($request->has('to')) {
            $query->where('created_at', '<=', Carbon::createFromFormat('d.m.Y.', $request->input('to')));
        }

        $orders = $query->with('status')->orderBy('id', 'desc')->paginate(20);
        $payments = Payment::getList();

        return view('back.orders.order.index', compact('orders', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = OrderStatus::orderBy('sort_order', 'asc')->get();

        return view('back.orders.order.edit', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order_stored = $order->validateRequest($request)->store();

        if ($order_stored) {
            return redirect()->back()->with(['success' => 'Narudžba je uspješno snimljena.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem narudžbe.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = (new Order())->newQuery();

        $order = $query->where('id', $id)->first();

        if ( ! $order) {
            abort(401);
        }

        $statuses = OrderStatus::orderBy('sort_order', 'asc')->get();

        return view('back.orders.order.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order_updated = $order->validateRequest($request)->store($order->id);

        if ($order_updated) {
            return redirect()->back()->with(['success' => 'Narudžba je uspješno snimljena.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem narudžbe.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['id'])) {
            return response()->json(
                Order::trashComplete($request['id'])
            );
        }
    }
}
