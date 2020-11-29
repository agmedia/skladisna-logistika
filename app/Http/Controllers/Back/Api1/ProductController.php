<?php

namespace App\Http\Controllers\Back\Api1;

use App\Models\Back\Product\Product;
use App\Models\Back\Product\ProductBlock;
use App\Models\Back\Product\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Bouncer;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $query = (new Product())->newQuery();

        if ($request->has('query')) {
            $query->where('name','like','%'.$request->input('query').'%');
        }

        $products = $query->with('actions')->get();

        return response()->json($products);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveBlock(Request $request)
    {
        return response()->json($request);

        if ($request->input('new')) {
            $response = ProductBlock::storeNew($request['data']);
        } else {
            $response = ProductBlock::renew($request['data']);
        }

        return response()->json($response);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBlock(Request $request)
    {
        if ( ! $request->has('data')) {
            return response()->json(['error' => 400]);
        }

        $response = ProductBlock::flush($request['data']);

        return response()->json($response);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Request $request)
    {
        $image = ProductImage::where('id', $request->input('data'))->first();
        $path = str_replace('media/images/gallery/products/', '', $image->image);
        // Obriši staru sliku
        Storage::disk('products')->delete($path);

        if (ProductImage::where('id', $request->input('data'))->delete()) {
            ProductImage::where('image', $image->image)->delete();

            return response()->json(['success' => 200]);
        }

        return response()->json(['error' => 400]);
    }
}
