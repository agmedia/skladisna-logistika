<?php

namespace App\Http\Controllers\Front;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Back\Orders\Order;
use App\Models\Front\AgCart;
use App\Models\Front\Message;
use App\Models\Recaptcha;
use Bouncer;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        if ( ! auth()->user()) {
            return redirect()->route('register');
        }
    }


    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customer = auth()->user();

        return view('front.account.partials.dashboard', compact('customer'));
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        $customer = auth()->user();
        $orders   = Order::where('user_id', $customer->id)->orderBy('created_at')->paginate(5);

        return view('front.account.partials.orders', compact('customer', 'orders'));
    }


    /**
     * @param Order $order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewOrder(Order $order)
    {
        $customer = auth()->user();

        return view('front.account.partials.order', compact('customer', 'order'));
    }


    /**
     * @param Order $order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repeatOrder(Order $order)
    {
        if (session()->has('sl_cart_id')) {
            $this->cart = new AgCart(session('sl_cart_id'));

            foreach ($order->products as $product) {
                $item = [
                    'item' => [
                        'id'       => $product->product_id,
                        'quantity' => $product->quantity
                    ]
                ];

                $this->cart->add($item);
            }

            return redirect()->back()->with(['success' => 'Artikli uspješno dodani u košaricu..!']);
        }

        return redirect()->back()->with(['error' => 'Whoops.!! Nešto je pošlo po krivu. Molimo vas pokušajte ponovo ili nas obavjestite o problemu.']);
    }


    /**
     * @param Order $order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printOrder(Order $order)
    {
        return PDF::loadView('pdfs.offer', ['order' => $order])->download('predracun_' . $order->id . '.pdf');
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function service()
    {
        $customer = auth()->user();

        return view('front.account.partials.service', compact('customer'));
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages()
    {
        $customer = auth()->user();
        $messages = Message::inbox()->paginate(5);

        return view('front.account.partials.messages', compact('customer', 'messages'));
    }


    /**
     * @param null $subject
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newMessage($subject = null)
    {
        $customer = auth()->user();

        return view('front.account.partials.message', compact('customer', 'subject'));
    }


    /**
     * @param Message $message
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewMessage(Message $message)
    {
        $customer = auth()->user();
        $messages = Message::conversation($message)->get();

        return view('front.account.partials.message', compact('customer', 'messages'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $recaptcha = (new Recaptcha())->check($request->toArray());

        if ( ! $recaptcha->ok()) {
            return back()->withErrors(['error' => 'Error sigurnosne provjere! Molimo vas pokušajte ponovo ili kontaktirajte administratora!']);
        }

        $message = new Message();

        if ( ! $request->has('group_id')) {
            $group = Message::groupBy('group_id')->count();
            $request->group_id = $group + 1;
        }

        $stored = $message->validateRequest($request)->store();

        Mail::to(config('mail.admin'))->send(new \App\Mail\Message($stored));

        if ($stored) {
            return redirect()->back()->with(['success' => 'Poruka je uspješno poslana.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem poruke.']);
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $customer = auth()->user();

        return view('front.account.partials.settings', compact('customer'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request)
    {
        $recaptcha = (new Recaptcha())->check($request->toArray());

        if ( ! $recaptcha->ok()) {
            return back()->withErrors(['error' => 'Error sigurnosne provjere! Molimo vas pokušajte ponovo ili kontaktirajte administratora!']);
        }

        $customer = auth()->user();
        $updated  = $customer->validateCustomerRequest($request)->updateCustomerData($customer->id);

        if ($updated) {
            return redirect()->back()->with(['success' => 'Korisnički podaci uspješno obnovljeni..!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem korisničkih podataka.']);
    }

}
