<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Front\Landing;
use App\Models\Front\Product;


class LandingController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Landing $landing)
    {
        $landing->increment('viewed', 1);
        $sections = $landing->sections->groupBy('section');
        $products = Product::whereIn('id', collect($landing->products->pluck('product_id'))->flatten()->all())->get();

        if ($products->count() > 5) {
            $products = $products->split(2);
        } else {
            $products = collect(array($products));
        }

        return view('front.page.landing', compact('landing', 'sections', 'products'));
    }

}
