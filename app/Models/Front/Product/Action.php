<?php

namespace App\Models\Front\Product;

use App\Models\Front\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_actions';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    /**
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('date_start', '<', Carbon::now())
            ->orWhereNull('date_start')
            ->where('date_end', '>', Carbon::now())
            ->orWhereNull('date_end');
    }
}
