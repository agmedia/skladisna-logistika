<?php

namespace App\Models\Front\Category;

use App\Models\Front\Product;
use App\Models\Front\Product\CategoryProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcategory extends Model
{

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, CategoryProduct::class, 'category_id', 'id', 'id', 'product_id')->with('action')->paginate();
    }




}
