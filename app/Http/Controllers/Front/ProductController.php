<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMessage;
use App\Models\Front\Category\Category;
use App\Models\Front\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Category $cat = null, Category $subcat = null, Product $prod = null)
    {
        $prod->increment('viewed', 1);
        $related = $subcat->related($prod->id)->inRandomOrder()->limit(6)->get();

        return view('front.product.index', compact( 'related','cat', 'subcat', 'prod'));
    }
}
