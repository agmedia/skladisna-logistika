<?php


namespace App\Models\Helpers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Country
{

    public static function list(): Collection
    {
        $countries = Storage::disk('assets')->get('country.json');

        return collect(json_decode($countries));
    }


    public static function zones($id = null): Collection
    {
        $zones = Storage::disk('assets')->get('zone.json');

        if ($id) {
            return collect(json_decode($zones))->where('country_id', $id);
        }

        return collect(json_decode($zones));
    }
}
