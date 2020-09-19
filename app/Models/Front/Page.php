<?php

namespace App\Models\Front;


use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    /**
     * @var string
     */
    protected $table = 'pages';

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
     * @param $client_id
     *
     * @return mixed
     */
    public function scopeOwnedBy($query, $client_id)
    {
        return $query->where('client_id', $client_id)->where('status', 1);
    }

}
