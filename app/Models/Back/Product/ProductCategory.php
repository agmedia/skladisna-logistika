<?php

namespace App\Models\Back\Product;

use App\Models\Back\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'product_category';

    /**
     * @var array $guarded
     */
    protected $guarded = [];

    //protected $primaryKey = 'product_id';


    /**
     * Update Product categories.
     *
     * @param $categories
     * @param $product_id
     *
     * @return array
     */
    public static function storeData($categories, $product_id)
    {
        self::where('product_id', $product_id)->delete();

        foreach ($categories as $category) {
            $cat = Category::find($category);

            $created[] = self::insert([
                'product_id'       => $product_id,
                'category_id'      => $cat->parent_id
            ]);

            $created[] = self::insert([
                'product_id'       => $product_id,
                'category_id'      => $cat->id
            ]);
        }

        return $created;
    }
}
