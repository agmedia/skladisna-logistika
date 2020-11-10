<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Front\Blog;
use App\Models\Front\Category\Category;

use App\Models\Front\Page;
use App\Models\Front\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{

    /**
     * @param Category $cat
     * @param Category $subcat
     * @param Blog     $blog
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Category $cat, $subcat = null, Blog $blog = null)
    {
        // Ako je samo $cat.
        if ( ! $subcat && ! $blog) {
            if ($cat->single_blog) {
                $blog = Blog::published()->article($cat)->first();

                if ($blog) {
                    return view('front.blog.index', compact('cat', 'blog'));
                }
            }

            $blogs = Blog::published()->news($cat)->latest()->paginate(12);

            return view('front.blog.all', compact('cat', 'subcat' , 'blogs'));
        }

        // Provjeri je li $subcat kategorija ili blog.
        $subcategory = Category::where('slug', $subcat)->first();

        // Ako je subcategory i blog.
        if ($subcat && $blog) {
            $subcat = $subcategory;


            return view('front.blog.index', compact('cat', 'subcat', 'blog'));
        }

        // Ako nema blog.
        if ($subcat && ! $blog) {
            // Ako subcategory nije kategorija.
            // Provjeri je li blog.
            if ( ! $subcategory) {
                $blog = Blog::published()->where('slug', $subcat)->first();

                if ($blog) {
                    return view('front.blog.index', compact('cat', 'blog'));
                }
            }

            // Ako je subcategory kategorija
            $subcat = $subcategory;
            if ($subcat->single_blog) {
                $blog = Blog::published()->article($subcat)->first();

                if ($blog) {
                    return view('front.blog.index', compact('cat', 'blog'));
                }
            }

            $blogs = Blog::published()->news($subcat)->latest()->paginate(12);

            return view('front.blog.all', compact('cat', 'subcat' , 'blogs'));
        }



        return abort(401);
    }


    /**
     * @param Category|null $cat
     * @param Category|null $subcat
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /*public function indexold(Blog $blog)
    {
        if ($blog->exists) {
            return view('front.blog.index', compact('blog'));
        }

        $blogs = Blog::where('is_published', 1)->orderBy('updated_at', 'desc')->paginate(config('settings.pagination.items'));
        $products = Product::where('status', 1)->inRandomOrder()->limit(9)->get();

        return view('front.blog.all', compact('blogs', 'products'));
    }*/

}
