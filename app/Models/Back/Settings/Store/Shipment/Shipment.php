<?php

namespace App\Models\Back\Settings\Store\Shipment;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{

    /**
     * @var string
     */
    protected $table = 'shipments';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param $value
     *
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return unserialize($value);
    }


    /**
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }
}