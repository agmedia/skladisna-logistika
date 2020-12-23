<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{

    /**
     * @var string
     */
    protected $table = 'manufacturers';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeCarousel($query)
    {
        return $query->where('carousel', 1);
    }

}
