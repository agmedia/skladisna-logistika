<?php

namespace App\Http\Controllers\Back;


use App\Http\Controllers\Controller;
use App\Models\Back\Orders\Order;
use App\Models\Back\Product\Product;
use App\Models\Back\Product\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Bouncer;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::getLatest();

        //Bouncer::assign('admin')->to(auth()->user());

        return view('back.dashboard', compact('orders'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tempCustomerDashboard()
    {
        return view('front.account.temp');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        $products = ProductImage::all();

        foreach ($products as $product) {
            if (strpos($product->image, 'assets/galleries') !== false) {
                $old_path = $product->image;
                $name = substr($product->image, strrpos($product->image, '/') + 1);
                $new_path = config('filesystems.disks.products.url') . $product->product_id . '/' . $name;

                if ( ! Storage::disk('local')->exists($new_path)) {
                    Storage::disk('local')->move($old_path, $new_path);
                }

                ProductImage::where('id', $product->id)->update([
                    'image' => $new_path
                ]);
            }
        }

        return redirect()->back()->with(['success' => 'Testirano!!! :)']);
    }


    public function testTwo()
    {
        return redirect()->back()->with(['success' => 'Testirano i drugi put!!! :)']);
    }

}
