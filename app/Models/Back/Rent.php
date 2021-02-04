<?php

namespace App\Models\Back;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Rent extends Model
{

    /**
     * @var string
     */
    protected $table = 'rents';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param Request $request
     *
     * @return bool
     */
    public static function store(Request $request): bool
    {
        if ($request->location == 'hc') {
            $location = 'Sjedište firme';
        } else {
            $location = 'Druga lokacija';
        }

        if ($request->type == 'ce') {
            $type = 'ČEONI ELEKTRIČNI';
        } elseif ($request->type == 'cp') {
            $type = 'ČEONI PLINSKI';
        } elseif ($request->type == 'cd') {
            $type = 'ČEONI DIESEL';
        } elseif ($request->type == 'rv') {
            $type = 'RUČNI BATERIJSKI SA KRANOM (VISOKOPODIZNI)';
        } elseif ($request->type == 'rn') {
            $type = 'RUČNI BATERIJSKI BEZ KRANA (NISKOPODIZNI)';
        } elseif ($request->type == 'rg') {
            $type = 'REGALNI';
        } else {
            $type = '';
        }

        $id = self::insertGetId([
            'email'            => $request->email,
            'mobile'           => $request->mobile,
            'oib'              => $request->oib,
            'location'         => $location,
            'location_address' => $request->location_address,
            'type'             => $type,
            'weight'           => $request->weight,
            'height'           => $request->height,
            'rent_start_date'  => $request->rent_start_date ? Carbon::make($request->rent_start_date) : '',
            'rent_end_date'    => $request->rent_end_date ? Carbon::make($request->rent_end_date ) : '',
            'on_location'      => $request->on_location,
            'has_ramp'         => $request->has_ramp,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return true;
        }

        return false;
    }
}
