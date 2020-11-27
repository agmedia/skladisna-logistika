<?php

namespace App\Http\Controllers\Back;

use App\Imports\ProductsImport;
use App\Models\Back\Category;
use App\Models\Back\Photo;
use App\Models\Back\Product\Product;
use App\Models\Back\Product\ProductBlock;
use App\Models\Back\Product\ProductImage;
use App\Models\Back\Users\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Bouncer;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Product())->newQuery();

        if ($request->has('search')) {
            $query->where('name','like','%' . $request->input('search') . '%');
        }

        if ($request->has('category') or $request->has('catid')) {
            $query->with('categories')->whereHas('categories',function ($query) use ($request) {
                $query->where('id', $request->input('catid'));
            });
        }

        if ($request->has('status')) {
            $operator = $request->input('status') == 'on' ? 1 : 0;
            $query->where('status', $operator);
        }

        $products = $query->with('actions')->paginate(20);
        $categories = Category::getList();

        return view('back.product.index', compact('products', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getListWithoutTop();
        $pdfs       = Storage::disk('media')->files('pdf');

        return view('back.product.edit', compact('categories', 'pdfs'));
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
        $product         = new Product();
        $product_created = $product->validateRequest($request)->store();

        if ($product_created) {
            if ($request->has('blocks')) {
                ProductBlock::store($request, $product_created['id']);
            }

            $product_created->storeImages($request);

            if ($request->hasFile('file')) {
                $filepath = Photo::imageUpload($request->file('file'), $product_created, 'pdf', 'pdf');

                Product::updateFilePath($product_created, $filepath);
            }

            return redirect()->back()->with(['success' => 'Product was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the product.']);
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
        $product    = Product::with('details', 'images', 'actions', 'categories')->find($id);
        $categories = Category::getListWithoutTop();
        $pdfs       = Storage::disk('media')->files('pdf');
        $arr        = [];

        if ( ! empty($product->categories)) {
            foreach ($product->categories as $category) {
                $arr[] = $category->id;
            }
        }

        $product_categories = collect($arr)->flatten()->all();

        return view('back.product.edit', compact('product', 'categories', 'product_categories', 'pdfs'));
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


    /**
     * Show the form for editing the specified image.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function imageEdit(Request $request)
    {
        // Make an Intervention/Image instance from requested image.
        $image = Image::make($request->input('path'));

        return view('back.product.partials.image-edit')->with([
            'image' => $image,
            'type'  => $request->input('type'),
            'id'    => $request->id,
        ]);
    }
}
