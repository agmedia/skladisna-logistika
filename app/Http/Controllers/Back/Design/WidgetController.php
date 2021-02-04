<?php

namespace App\Http\Controllers\Back\Design;

use App\Models\Back\Catalog\Manufacturer;
use App\Models\Back\Category;
use App\Models\Back\Design\Widget;
use App\Models\Back\Marketing\Blog\Blog;
use App\Models\Back\Product\Product;
use App\Models\Back\Settings\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WidgetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Widget())->newQuery();

        if ($request->has('group')) {
            $query->where('group', $request->input('group'));
        }

        $widgets = $query->orderBy('sort_order')->paginate(config('settings.pagination.items'));

        $groups = Widget::groups()->get();

        return view('back.design.widgets.index', compact('widgets', 'groups'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Widget::groups()->get();
        $sizes  = (new Widget())->sizes();

        return view('back.design.widgets.edit', compact('groups', 'sizes'));
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
        $widget = new Widget();
        $stored = $widget->validateRequest($request)->setUrl()->store();

        if ($stored) {
            if ($request->has('image') && $request->input('image')) {
                $stored->resolveImage($request);
            }

            return redirect()->route('widgets')->with(['success' => 'Widget je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem widgeta.']);
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
        $query = (new Widget())->newQuery();

        $widget = $query->where('id', $id)->first();
        $sizes  = $widget->sizes();

        if ( ! $widget) {
            abort(401);
        }

        $groups = Widget::groups()->get();

        return view('back.design.widgets.edit', compact('widget', 'groups', 'sizes'));
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
        $widget = new Widget();
        $updated = $widget->validateRequest($request)->setUrl()->edit($id);

        if ($updated) {
            if (Widget::hasImage($request)) {
                $updated->resolveImage($request);
            }

            return redirect()->back()->with(['success' => 'Widget je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem widgeta.']);
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
            return response()->json(
                Widget::where('id', $request['data']['id'])->delete()
            );
        }
    }


    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/
    // API ROUTES

    public function getLinks(Request $request)
    {
        if ($request->has('type')) {
            if ($request->input('type') == 'category') {
                return response()->json(Category::getList());
            }
            if ($request->input('type') == 'manufacturer') {
                return response()->json(Manufacturer::list());
            }
            if ($request->input('type') == 'product') {
                return response()->json(Product::getMenu());
            }
            if ($request->input('type') == 'page') {
                return response()->json(Blog::published()->pluck('title', 'id'));
            }
        }

        return response()->json([
            'id' => 0,
            'text' => 'Molimo odaberite tip linka..'
        ]);
    }
}
