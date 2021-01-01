<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Front\Category\Category;
use App\Models\Front\Product;
use Illuminate\Support\Str;

class GCP_RouteController extends Controller
{

    /**
     * Resolver for the Groups, categories and products routes.
     * Route::get('{group}/{cat?}/{subcat?}/{prod?}', 'Front\GCP_RouteController::resolve()')->name('gcp_route');
     *
     * @param               $group
     * @param Category|null $cat
     * @param Category|null $subcat
     * @param Product|null  $prod
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resolve($group, Category $cat = null, Category $subcat = null, Product $prod = null)
    {
        $group_categories = [];

        // If there are no categories and subcategories.
        // Only group.
        if ( ! $cat && ! $subcat) {
            // If group is special, self page group.
            if ($group == 'toyota-vilicari') {
                $cats = Category::getMenu();
                $kategorije = $cats['list']['TOYOTA VILIČARI'];

                return view('front.category.toyota-vilicari', compact('kategorije'));
            }
            // Collect all the groups. In DB groups are not slugified.
            $groups = Category::whereNotNull('group')->distinct('group')->groupBy('group')->get();

            foreach ($groups as $key => $group_item) {
                // If group is found...
                if (Str::slug($group_item->group) == $group) {
                    $items = Category::itemsFromGroup($group_item->group);

                    $top_products = $items['top'];
                    $products = $items['items'];

                    $group_categories = Category::where('group', $group_item->group)->where('parent_id', 0)->get();
                }
            }
        } else {
            // If there are products...
            if ($prod) {
                $prod->increment('viewed', 1);
                $related = $subcat->related($prod->id)->inRandomOrder()->limit(6)->get();

                return view('front.product.index', compact( 'related','cat', 'subcat', 'prod'));
            }
            // Or if there are only categories or subcategories.
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

}
