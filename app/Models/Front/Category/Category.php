<?php

namespace App\Models\Front\Category;

use App\Models\CategoryMenu;
use App\Models\Front\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Front\Product\CategoryProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Category extends Model
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, CategoryProduct::class, 'category_id', 'id', 'id', 'product_id')->where('status', 1)->orderBy('sort_order');
    }


    /**
     * @return mixed
     */
    public function subcategories()
    {
        return $this->where('parent_id', $this->id)->orderBy('sort_order', 'asc')->get();
    }


    /**
     * @param      $query
     * @param null $product_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function scopeRelated($query, $product_id = null)
    {
        $products = $this->products()->where('product_id', '!=', $product_id);

        return $products->with('action');
    }


    /**
     * @param      $query
     * @param null $client_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function scopeItems($query, $client_id = null)
    {
        $products = $this->products();

       /* if ($client_id) {
            $products->where('client_id', $client_id);
        }*/

        return $products->with('action');
    }


    /**
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeTopItems($query)
    {
        $products = $this->products();

        return $products->orderBy('viewed', 'desc')->limit(3)->with('action')->get();
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeGroupItems($query)
    {
        $categories = $this->where('group', $this->group)->get();

        foreach ($categories as $category) {
            $products = $category->products();
        }

        return $products->with('action')->paginate(config('settings.pagination.items'));
    }


    /**
     * @param $group
     *
     * @return array
     */
    public static function itemsFromGroup($group)
    {
        $products = new Collection();
        $categories = self::where('group', $group)->where('parent_id', 0)->get();

        foreach ($categories as $category) {
            $products->push($category->products()->pluck('id'));
        }

        $items = Product::whereIn('id', $products->flatten())->orderBy('sort_order')->with('action')->paginate(config('settings.pagination.items'));
        $top = Product::whereIn('id', $products->flatten()->random(3))->with('action', 'client')->get();

        return [
            'items' => $items,
            'top' => $top
        ];
    }


    /**
     * Get the categories for the
     * navigation menu.
     *
     * @return mixed
     */
    public static function getList()
    {
        return (new CategoryMenu())->list();
    }


    /**
     * Get the categories menu.
     * List for the select component.
     *
     * @param bool $admin
     *
     * @return mixed
     */
    public static function getMenu()
    {
        return (new CategoryMenu())->menu();
    }

}
