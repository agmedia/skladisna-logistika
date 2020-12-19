<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Models\Back\Catalog\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;

class ManufacturerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new Manufacturer())->newQuery();

        $manufacturers = $query->get();

        return view('back.catalog.manufacturer.index', compact('manufacturers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.catalog.manufacturer.edit');
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
        $manufacturer = new Manufacturer();
        $stored = $manufacturer->validateRequest($request)->store();

        if ($stored) {
            if ($request->has('image') && $request->input('image')) {
                $stored->resolveImage($request);
            }

            return redirect()->back()->with(['success' => 'Proizvođač je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem proizvođača.']);
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
        $query = (new Manufacturer())->newQuery();

        $manufacturer = $query->where('id', $id)->first();

        if ( ! $manufacturer) {
            abort(401);
        }

        return view('back.catalog.manufacturer.edit', compact('manufacturer'));
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
        $manufacturer = new Manufacturer();
        $updated = $manufacturer->validateRequest($request)->edit($id);

        if ($updated) {
            if ($request->has('image') && $request->input('image')) {
                $updated->resolveImage($request);
            }

            return redirect()->back()->with(['success' => 'Proizvođač je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem proizvođača.']);
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
                Manufacturer::where('id', $request['data']['id'])->delete()
            );
        }
    }
}
