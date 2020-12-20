<?php

namespace App\Models\Back\Settings\Store\Payment;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * @var string
     */
    protected $table = 'payments';

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