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
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $query = (new Product())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        if ($request->has('query')) {
            $query->where('name','like','%'.$request->input('query').'%');
        }

        $products = $query->with('actions')->get();

        return response()->json($products);
    }


    public function getSectionBlock(Request $request)
    {
        return View::make('back.marketing.landing.partials.section_3_1')
            ->with('tag', $request->get('tag'))
            ->with('title', $request->get('title'))
            ->with('section', null)
            ->render();
    }
}
