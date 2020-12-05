<?php

namespace App\Http\Controllers\Front;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Back\Users\Message;
use App\Models\Back\Orders\Order;
use App\User;
use Bouncer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if ( ! auth()->user()) {
            return redirect()->route('register');
        }

        $user = auth()->user();

        $query = (new Message())->newQuery();
        $messages = $query->inbox()->orderBy('created_at', 'desc')->with('sender', 'recipient')->paginate(20);

        return view('front.account.partials.dashboard', compact('user', 'messages'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $customer = auth()->user();

        return view('front.customer.edit', compact('customer'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        $customer = auth()->user();
        $updated = $customer->validateCustomerRequest($request)->updateCustomerData($customer->id);

        return redirect()->route('moj.edit')->with(['success' => 'Korisnički podaci uspješno obnovljeni..!']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        $user = auth()->user();

        return view('front.account.partials.orders', compact('user'));
    }


    /**
     * @param Order $order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewOrder(Order $order)
    {
        $customer = auth()->user();

        return view('front.customer.order', compact('customer', 'order'));
    }
    
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function service()
    {
        $user = auth()->user();
        
        return view('front.account.partials.service', compact('user'));
    }
    
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $user = auth()->user();
        
        return view('front.account.partials.settings', compact('user'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages()
    {
        $user = auth()->user();

        $query = (new Message())->newQuery();
        $messages = $query->inbox()->orderBy('created_at', 'desc')->with('sender', 'recipient')->paginate(20);

        return view('front.account.partials.messages', compact('user', 'messages'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newMessage()
    {
        $customer = auth()->user();

        return view('front.customer.message', compact('customer'));
    }


    /**
     * @param Message $message
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewMessage(Message $message)
    {
        $query = (new Message())->newQuery();

        $messages = $query->conversation($message)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();

        $customer = auth()->user();
        $recipient = Message::getRecipientUser($message);

        return view('front.customer.message', compact('customer', 'messages', 'recipient'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        if ( ! $request->has('recipient')) {
            $request->recipient = $request->input('user_id');
        }

        $message        = new Message();
        $message_stored = $message->validateRequest($request)->storeData();

        event(new MessageSent($message_stored));

        if ($message_stored) {
            return redirect()->route('moj.poruke')->with(['success' => 'Poruka je uspješno poslana.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem poruke.']);
    }


    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendRequest(Request $request)
    {
        if ( ! auth()->user()) {
            return redirect()->route('register');
        }

        $message        = new Message();
        $message_stored = $message->storeVendorRequest();

        event(new MessageSent($message_stored));

        if ($message_stored) {
            return redirect()->route('moj')->with(['success' => 'Poruka je uspješno poslana.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa slanjem poruke.']);
    }
}
