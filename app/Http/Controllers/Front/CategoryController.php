<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Front\Category\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($group, Category $cat = null, Category $subcat = null)
    {
        $group_categories = [];

        if ( ! $cat && ! $subcat) {
            $groups = Category::whereNotNull('group')->distinct('group')->groupBy('group')->get();

            foreach ($groups as $key => $group_item) {
                if (Str::slug($group_item->group) == $group) {
                    $items = Category::itemsFromGroup($group_item->group);

                    $top_products = $items['top'];
                    $products = $items['items'];

                    $group_categories = Category::where('group', $group_item->group)->where('parent_id', 0)->get();
                }
            }
        } else {
            $top_products = $cat->topItems();

            if ($subcat) {
                $products = $subcat->items()->paginate(config('settings.pagination.items'));
            } else {
                $products = $cat->items()->paginate(config('settings.pagination.items'));
            }
        }

        if ( ! isset($products)) {
            abort(404);
        }

        return view('front.category.index', compact('group', 'cat', 'subcat', 'products', 'top_products', 'group_categories'));
    }


    public function toyota()
    {
        $cats = Category::getMenu();
        $kategorije = $cats['list']['TOYOTA VILIČARI'];

        return view('front.category.toyota-vilicari', compact('kategorije'));

    }
}
