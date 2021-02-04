<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RentController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.page.renting');
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        Log::info($request);

        $request->validate([
            'email'   => 'required',
            'mobile'  => 'required',
            'oib'     => 'required',
            'consent' => 'required',
        ]);

        //return redirect()->back();

        $stored = Rent::store($request);

        if ($stored) {
            return redirect()->back()->with(['success' => 'Hvala vam na poslanom upitu! Brzo ćemo vas kontaktirati povratno.']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Nešto se dogodilo... Molimo vas da pokušate ponovo ili kontaktirate administratora.']);
    }

}
