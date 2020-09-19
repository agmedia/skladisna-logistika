<?php

namespace App\Http\Controllers\Back\Settings;

use App\Models\Category;
use App\Models\Product\Product;
use App\Models\Settings\Page;
use App\Models\Settings\Slider;
use App\Models\Settings\SliderGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = SliderGroup::with('sliders')->get();
        
        return view('back.settings.slider.index', compact('sliders'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products   = Product::getMenu();
        $categories = Category::getMenu();
        $pages      = Page::getMenu();
        
        return view('back.settings.slider.edit', compact('products', 'categories', 'pages'));
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
        $slider = SliderGroup::find($id);
        
        //dd($slider);
        
        $products   = Product::getMenu();
        $categories = Category::getMenu();
        $pages      = Page::getMenu();
        
        return view('back.settings.slider.edit', compact('slider', 'products', 'categories', 'pages'));
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
        
        return view('back.settings.slider.edit-sliders', compact('slider'));
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
            return response()->json(
                SliderGroup::destroyAll($request['data']['id'])
            );
        }
    }
}
