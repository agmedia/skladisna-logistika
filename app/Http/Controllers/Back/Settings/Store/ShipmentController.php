<?php

namespace App\Http\Controllers\Back\Settings\Store;

use App\Models\Back\Settings\Store\Shipment\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ShipmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkForNewFiles();

        $query = (new Shipment())->newQuery();

        $shipments = $query->orderBy('sort_order')->paginate(config('settings.pagination.items'));

        return view('back.settings.store.shipment.index', compact('shipments'));
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
                return response()->json(['message' => 'Upišite naslov načina isporuke.']);
            }

            Log::warning($request);

            if (intval($request['data']['sid'])) {
                $pay = Shipment::find($request['data']['sid']);
            } else {
                $pay = new Shipment();
            }

            $pay->name        = $request['data']['name'];
            $pay->description = isset($request['data']['description']) ? $request['data']['description'] : '';
            $pay->data        = $request['data']['data'];
            $pay->status      = $request['data']['status'] ? 1 : 0;
            $pay->sort_order  = $request['data']['sort_order'];
            $pay->save();

            return response()->json(['success' => 'Način isporuke je uspješno snimljen.']);
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
                Shipment::where('id', $request['data']['id'])->delete()
            );
        }
    }


    /**
     * Check for new files in ..payment/modals directory.
     * Install payment if new files exist.
     */
    private function checkForNewFiles(): void
    {
        $files    = new \DirectoryIterator('./../resources/views/back/settings/store/shipment/modals');
        $payments = Shipment::all();

        foreach ($files as $file) {
            if (strpos($file, 'blade.php') !== false) {
                $filename = str_replace('.blade.php', '', $file);
                $exist    = $payments->where('code', $filename)->first();

                if ( ! $exist) {
                    $p              = new Shipment();
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
