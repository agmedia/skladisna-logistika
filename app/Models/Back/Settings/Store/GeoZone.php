<?php

namespace App\Models\Back\Settings\Store;

use Illuminate\Database\Eloquent\Model;

class GeoZone extends Model
{

    /**
     * @var string
     */
    protected $table = 'geo_zones';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
