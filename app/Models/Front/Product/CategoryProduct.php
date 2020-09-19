<?php

namespace App\Models\Front\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_category';

    /**
     * @var array
     */
    protected $guarded = [];
}
