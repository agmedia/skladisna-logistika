<?php

namespace App\Http\Controllers\Back\Marketing;

use App\Models\Back\Category;
use App\Models\Back\Marketing\Slider\SliderGroup;
use App\Models\Back\Product\Product;
use App\Models\Back\Settings\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Bouncer;

class SliderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new SliderGroup())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        $sliders = $query->with('sliders')->get();

        return view('back.marketing.slider.index', compact('sliders'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$products   = Product::getMenu();
        $categories = Category::getMenu();
        $pages      = Page::getMenu();*/

        return view('back.marketing.slider.edit'/*, compact('products', 'categories', 'pages')*/);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = SliderGroup::store($request);

        if (Bouncer::is(auth()->user())->an('admin')) {
            Cache::forget('home_sl');
        }

        if ($slider) {
            return redirect()->route('sliders')->with(['success' => 'Slider was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error creating the slider.']);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = (new SliderGroup())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        $slider = $query->where('id', $id)->first();

        if ( ! $slider) {
            abort(401);
        }

        /*$products   = Product::list();
        $categories = Category::getMenu();
        $pages      = Page::getMenu();*/

        return view('back.marketing.slider.edit', compact('slider'/*, 'products', 'categories', 'pages'*/));
    }


    /**
     * Show the form for editing sliders the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function editSliders($id)
    {
        $slider = SliderGroup::find($id);

        return view('back.marketing.slider.edit-sliders', compact('slider'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = SliderGroup::edit($request, $id);

        if (Bouncer::is(auth()->user())->an('admin')) {
            Cache::forget('home_sl');
        }

        if ($slider) {
            return redirect()->route('sliders')->with(['success' => 'Slider was succesfully updated!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error updating the slider.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            if (Bouncer::is(auth()->user())->an('admin')) {
                Cache::forget('home_sl');
            }

            return response()->json(
                SliderGroup::destroyAll($request['data']['id'])
            );
        }
    }
}
