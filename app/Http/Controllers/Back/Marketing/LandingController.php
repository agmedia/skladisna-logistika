<?php

namespace App\Http\Controllers\Back\Marketing;

use App\Models\Back\Category;
use App\Models\Back\Marketing\Blog\Blog;
use App\Models\Back\Marketing\Landing\Landing;
use App\Models\Back\Marketing\Landing\LandingProduct;
use App\Models\Back\Marketing\Landing\LandingSection;
use App\Models\Back\Product\Product;
use App\Models\Back\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Bouncer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Landing())->newQuery();

        if ($request->has('from')) {
            $query->whereDate('created_at', '>=', Carbon::createFromFormat('d.m.Y.', $request->input('from')));
        }

        if ($request->has('to')) {
            $query->where('created_at', '<=', Carbon::createFromFormat('d.m.Y.', $request->input('to')));
        }

        $landings = $query->orderBy('created_at', 'desc')->get();

        return view('back.marketing.landing.index', compact('landings'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::list();

        return view('back.marketing.landing.edit', compact('products'));
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
        //dd($request);
        $landing   = new Landing();
        $stored = $landing->validateRequest($request)->storePage();

        if ($stored) {
            if ($request->has('main_image') && $request->input('main_image')) {
                $landing->resolveMainImage($stored->id);
            }

            $landing->resolveSections($stored->id, $request->section);
            $landing->resolveProducts($stored->id, $request->products);

            if ($request->hasFile('file')) {
                $landing->saveDocument($stored, $request->file('file'));
            }

            return redirect()->back()->with(['success' => 'Landing je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem landing stranice.']);
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
        $query = (new Landing())->newQuery();

        $landing = $query->where('id', $id)->first();

        if ( ! $landing) {
            abort(401);
        }

        $sections = $landing->sections->groupBy('section');
        $products = Product::list();

        //dd($sections[3]);

        return view('back.marketing.landing.edit', compact('landing', 'sections', 'products'));
    }


    /**
     * Show the form for copying the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function copy($id)
    {
        $query = (new Landing())->newQuery();

        $old_landing = $query->where('id', $id)->first();
        $landing = $old_landing->replicate();
        $landing->title = $old_landing->title . ' - COPY';
        $landing->client = $old_landing->client . ' - COPY';
        $landing->created_at = Carbon::now();
        $landing->updated_at = Carbon::now();
        $landing->save();

        foreach ($old_landing->sections as $old_section) {
            $section = $old_section->replicate();
            $section->landing_id = $landing->id;
            $section->created_at = Carbon::now();
            $section->updated_at = Carbon::now();
            $section->save();
        }

        return redirect()->route('landing.edit', ['id' => $landing->id]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Blog                     $blog
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Landing $landing)
    {
        $updated = $landing->validateRequest($request)->updatePage($landing->id);

        if ($updated) {
            if ($request->has('main_image') && $request->input('main_image')) {
                $landing->resolveMainImage($landing->id);
            }

            $landing->updateSections($landing->id, $request->section);
            $landing->resolveProducts($landing->id, $request->products);

            if ($request->hasFile('file')) {
                $landing->saveDocument($landing, $request->file('file'));
            }

            return redirect()->back()->with(['success' => 'Landing je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem landing stranice.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            LandingSection::where('landing_id', $request['data']['id'])->delete();
            LandingProduct::where('landing_id', $request['data']['id'])->delete();

            return response()->json(
                Landing::where('id', $request['data']['id'])->delete()
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyDoc(Request $request)
    {
        if (isset($request['data']['id'])) {
            return response()->json(
                Landing::where('id', $request['data']['id'])->update([
                    'download_url' => ''
                ])
            );
        }
    }
}
