<?php

namespace App\Http\Controllers\Back;

use App\Imports\ProductsImport;
use App\Models\Back\Catalog\Manufacturer;
use App\Models\Back\Category;
use App\Models\Back\Photo;
use App\Models\Back\Product\Product;
use App\Models\Back\Product\ProductBlock;
use App\Models\Back\Product\ProductImage;
use App\Models\Back\Rent;
use App\Models\Back\Settings\Store\Tax;
use App\Models\Back\Users\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Bouncer;
use Maatwebsite\Excel\Facades\Excel;

class RentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Rent())->newQuery();

        $rents = $query->paginate(20);

        return view('back.rents.index', compact('rents'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $rent = Rent::where('id', $id)->first();

        return view('back.rents.show', compact('rent'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['id'])) {
            return response()->json(
                Product::trashComplete($request['id'])
            );
        }
    }

}
