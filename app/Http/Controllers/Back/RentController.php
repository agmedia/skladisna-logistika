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
        //dd($request);
        $product         = new Product();
        $product_updated = $product->validateRequest($request)->store($id);

        if ($product_updated) {
            if ($request->has('blocks')) {
                ProductBlock::store($request, $product_updated['id']);
            }

            $product_updated->storeImages($request);

            if ($request->hasFile('file')) {
                $filepath = Photo::imageUpload($request->file('file'), $product_updated, 'pdf', 'pdf');

                Product::updateFilePath($product_updated, $filepath);
            }

            return redirect()->back()->with(['success' => 'Proizvod je uspješno snimljen.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem proizvoda.']);
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
