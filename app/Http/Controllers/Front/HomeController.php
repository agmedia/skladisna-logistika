<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMessage;
use App\Models\CategoryMenu;
use App\Models\Front\Blog;
use App\Models\Front\Page;
use App\Models\Front\Product;
use App\Models\Front\Slider;
use App\Models\Recaptcha;
use App\Notifications\ContactFormNotification;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*public function index()
    {
        $sliders = Slider::home()->get();

        return view('front.home', compact('sliders'));
    }*/


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $sliders = Cache::rememberForever('home_sl', function () {
            return Slider::home()->get();
        });

        $latest_products  = Product::last()->get();
        $popular_products = Product::popular()->get();
        $top_products     = Product::topponuda(5)->get();
        $blogs            = Blog::published()->last(3)->get();

        return view('front.home', compact('sliders', 'latest_products', 'top_products', 'popular_products', 'blogs'));
    }


    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page(Page $page)
    {
        return view('front.page.page', compact('page'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('front.page.contact');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /*public function landing()
    {

        $sliders = Cache::rememberForever('home_sl', function () {
            return Slider::home()->get();
        });

        $latest_products  = Product::last()->get();
        $popular_products = Product::popular()->get();
        $top_products     = Product::topponuda(5)->get();
        $blogs            = Blog::published()->last(3)->get();

        return view('front.page.landing',
            compact('sliders', 'latest_products', 'top_products', 'popular_products', 'blogs'));

    }*/


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tal(Page $page)
    {
        if (isset($page->id)) {
            if ($page->group != 'TAL') {
                abort(404);
            }

            return view('front.page.page', compact('page'));
        }

        return view('front.page.tal');

    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function message(Request $request)
    {
        $request->validate([
            'name'      => 'required|max:100',
            'email'     => 'required|email',
            'message'   => 'required',
            'consent'   => 'required',
            'recaptcha' => 'required',
        ]);

        $recaptcha = (new Recaptcha())->check($request->toArray());

        if ( ! $recaptcha->ok()) {
            return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa slanjem poruke. Molimo pokušajte kasnije!']);
        }

        try {
            Mail::to(config('mail.admin'))->send(new ContactFormMessage($request));

            return redirect()->back()->with(['success' => 'Vaša poruka je uspješno poslana..! Netko će vas ubrzo kontaktirati.']);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa slanjem poruke. Molimo pokušajte kasnije!']);
        }

        //$admin->notify(new ContactFormNotification());
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(Request $request)
    {
        $role_id = DB::table('roles')->where('name', $request->role)->pluck('id');
        $user_id = DB::table('assigned_roles')->where('role_id', $role_id)->pluck('entity_id');

        Auth::loginUsingId($user_id);

        return redirect()->route('dashboard');
    }
}
