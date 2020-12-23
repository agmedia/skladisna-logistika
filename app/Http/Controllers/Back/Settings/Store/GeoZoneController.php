<?php

namespace App\Http\Controllers\Back\Settings\Store;

use App\Models\Back\Settings\Store\GeoZone;
use App\Models\Helpers\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class GeoZoneController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new GeoZone())->newQuery();

        $zones = $query->paginate(config('settings.pagination.items'));
        $countries = Country::list();

        return view('back.settings.store.geo-zone', compact('zones', 'countries'));
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
                return response()->json(['message' => 'Upišite naziv geo zone.']);
            }

            if (intval($request['data']['gzid'])) {
                $gz = GeoZone::find($request['data']['gzid']);
            } else {
                $gz = new GeoZone();
            }

            $gz->name = $request['data']['name'];
            $gz->description = isset($request['data']['description']) ? $request['data']['description'] : '';
            $gz->state = $request['data']['state'];
            $gz->zone = $request['data']['zone'];
            $gz->status = $request['data']['status'] ? 1 : 0;
            $gz->save();

            return response()->json(['success' => 'Geo zona je uspješno snimljena.']);
        }

        return response()->json(['message' => 'Server error!']);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStateZones(Request $request)
    {
        if (isset($request['country'])) {
            $zones = Country::zones($request['country']);

            return response()->json($zones);
        }

        return response()->json(['message' => 'Odaberite državu.']);
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
                GeoZone::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
