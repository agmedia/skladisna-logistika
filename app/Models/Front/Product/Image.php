<?php

namespace App\Models\Front\Product;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_images';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

}
