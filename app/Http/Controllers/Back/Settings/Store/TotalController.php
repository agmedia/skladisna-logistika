<?php

namespace App\Http\Controllers\Back\Settings\Store;

use App\Models\Back\Orders\OrderStatus;
use App\Models\Back\Settings\Store\Payment\Payment;
use App\Models\Back\Settings\Store\Total;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TotalController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkForNewFiles();

        $query = (new Total())->newQuery();

        $totals = $query->orderBy('sort_order')->paginate(config('settings.pagination.items'));

        return view('back.settings.store.total.index', compact('totals'));
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
                $total = Total::find($request['data']['pid']);
            } else {
                $total = new Total();
            }

            $total->name        = $request['data']['name'];
            $total->description = isset($request['data']['description']) ? $request['data']['description'] : '';
            $total->data        = isset($request['data']['data']) ? $request['data']['data'] : [];
            $total->status      = $request['data']['status'] ? 1 : 0;
            $total->sort_order  = $request['data']['sort_order'];
            $total->save();

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
                Total::where('id', $request['data']['id'])->delete()
            );
        }
    }


    /**
     * Check for new files in /modals directory.
     * Install if new files exist.
     */
    private function checkForNewFiles(): void
    {
        $files    = new \DirectoryIterator('./../resources/views/back/settings/store/total/modals');
        $payments = Total::all();

        foreach ($files as $file) {
            if (strpos($file, 'blade.php') !== false) {
                $filename = str_replace('.blade.php', '', $file);
                $exist    = $payments->where('code', $filename)->first();

                if ( ! $exist) {
                    $p              = new Total();
                    $p->name        = $filename;
                    $p->code        = $filename;
                    $p->description = '';
                    $p->data        = '';
                    $p->sort_order  = $payments->count();
                    $p->status      = 0;
                    $p->save();
                }

            }
        }
    }
}
