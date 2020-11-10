<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Front\AgCart;
use App\Models\Front\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;

class NewsletterController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function subscribe(Request $request, ApiClient $chimp)
    {
        $request->validate(['email' => ['required', 'email']]);
        $list_id = '9ef033c232';
        $subscriber_hash = md5(strtolower($request->input('email')));

        try {
            $check = $chimp->lists->getListMember($list_id, $subscriber_hash);
        } catch (\Exception $e) {
            $check = $e->getCode();
        }

        if ($this->checkMember($check)) {
            return response()->json(['status' => 201]);
        }

        try {
            $response = $chimp->lists->addListMember($list_id, [
                "email_address" => $request->input('email'),
                "status" => "subscribed",
            ]);

        } catch (ApiException $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($response);
    }


    /**
     * @param $response
     *
     * @return bool
     */
    private function checkMember($response)
    {
        if (is_numeric($response)) {
            return false;
        }
        if ($response->status == 'unsubscribed') {
            return true;
        }
        if ($response->status == 'subscribed') {
            return true;
        }

        return false;
    }

}
