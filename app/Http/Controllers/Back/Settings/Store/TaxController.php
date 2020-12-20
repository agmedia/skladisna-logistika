<?php

namespace App\Http\Controllers\Back\Settings\Store;

use App\Models\Back\Photo;
use App\Models\Back\Settings\Page;
use App\Models\Back\Settings\Store\GeoZone;
use App\Models\Back\Settings\Store\Tax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TaxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new Tax())->newQuery();

        $taxes = $query->orderBy('sort_order')->paginate(config('settings.pagination.items'));
        $zones = GeoZone::where('status', 1)->get();

        return view('back.settings.store.tax', compact('taxes', 'zones'));
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
            if (empty($request['data']['name']) || empty($request['data']['rate'])) {
                return response()->json(['message' => 'Upišite naziv i stopu poreza.']);
            }

            if (intval($request['data']['tid'])) {
                $tax = Tax::find($request['data']['tid']);
            } else {
                $tax = new Tax();
            }

            $tax->name        = $request['data']['name'];
            $tax->rate        = $request['data']['rate'];
            $tax->description = isset($request['data']['description']) ? $request['data']['description'] : '';
            $tax->data        = $request['data']['data'];
            $tax->status      = $request['data']['status'] ? 1 : 0;
            $tax->sort_order  = $request['data']['sort_order'];
            $tax->save();

            return response()->json(['success' => 'Porez je uspješno snimljen.']);
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
                Tax::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
