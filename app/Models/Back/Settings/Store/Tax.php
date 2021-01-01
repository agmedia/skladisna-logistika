<?php

namespace App\Models\Back\Settings\Store;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

    /**
     * @var string
     */
    protected $table = 'taxes';

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


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    public function scopeSort($query, $asc = true)
    {
        $order = $asc ? 'asc' : 'desc';

        return $query->orderBy('sort_order', $order);
    }
}
