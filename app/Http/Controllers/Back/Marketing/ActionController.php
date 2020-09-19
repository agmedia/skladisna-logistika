<?php

namespace App\Http\Controllers\Back\Marketing;

use App\Models\Back\Product\Product;
use App\Models\Back\Product\ProductAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;

class ActionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new ProductAction())->newQuery();

        $actions = $query->get();

        return view('back.marketing.action.index', compact('actions'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::list();

        return view('back.marketing.action.edit', compact('products'));
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
        $action_updated = ProductAction::store($request);

        if ($action_updated) {
            return redirect()->route('actions')->with(['success' => 'Action was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the action.']);
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
        $query = (new ProductAction())->newQuery();

        $action = $query->where('id', $id)->with('product')->first();

        if ( ! $action) {
            abort(401);
        }

        $products = Product::list();

        return view('back.marketing.action.edit', compact('action', 'products'));
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
        $action_updated = ProductAction::store($request);

        if ($action_updated) {
            return redirect()->route('actions')->with(['success' => 'Action was succesfully updated!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error updating the action.']);
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
                ProductAction::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
