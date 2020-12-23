<?php

namespace App\Http\Controllers\Back\Settings\Store;

use App\Models\Back\Orders\OrderStatus;
use App\Models\Back\Settings\Store\Payment\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkForNewFiles();

        $query = (new Payment())->newQuery();

        $payments       = $query->orderBy('sort_order')->paginate(config('settings.pagination.items'));
        $order_statuses = OrderStatus::orderBy('sort_order')->get();

        return view('back.settings.store.payment.index', compact('payments', 'order_statuses'));
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
                return response()->json(['message' => 'Upišite naslov statusa narudžbe.']);
            }

            if (intval($request['data']['pid'])) {
                $pay = Payment::find($request['data']['pid']);
            } else {
                $pay = new Payment();
            }

            $pay->name        = $request['data']['name'];
            $pay->description = isset($request['data']['description']) ? $request['data']['description'] : '';
            $pay->data        = $request['data']['data'];
            $pay->status      = $request['data']['status'] ? 1 : 0;
            $pay->sort_order  = $request['data']['sort_order'];
            $pay->save();

            return response()->json(['success' => 'Način plaćanja je uspješno snimljen.']);
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
                Payment::where('id', $request['data']['id'])->delete()
            );
        }
    }


    /**
     * Check for new files in ..payment/modals directory.
     * Install payment if new files exist.
     */
    private function checkForNewFiles(): void
    {
        $files    = new \DirectoryIterator('./../resources/views/back/settings/store/payment/modals');
        $payments = Payment::all();

        foreach ($files as $file) {
            if (strpos($file, 'blade.php') !== false) {
                $filename = str_replace('.blade.php', '', $file);
                $exist    = $payments->where('code', $filename)->first();

                if ( ! $exist) {
                    $p              = new Payment();
                    $p->name        = $filename;
                    $p->code        = $filename;
                    $p->description = '';
                    $p->data        = '';
                    $p->image       = '';
                    $p->sort_order  = $payments->count();
                    $p->status      = 0;
                    $p->save();
                }

            }
        }
    }
}
