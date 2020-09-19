<?php

namespace App\Models\Back\Orders;

use App\Models\Back\Users\Client;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id')->with('product');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totals()
    {
        return $this->hasMany(OrderTotal::class, 'order_id')->orderBy('sort_order', 'asc');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePaid($query)
    {
        return $query->where('order_status_id', 3)->orWhere('order_status_id', 4);
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'order_status'    => 'required',
            'payment_method'  => 'required',
            'shipping_method' => 'required',
            'fname'           => 'required',
            'lname'           => 'required',
            'address'         => 'required',
            'city'            => 'required',
            'email'           => 'required',
            'items'           => 'required',
            'sums'            => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateMakeRequest(Request $request)
    {
        $request->validate([
            'order_data'   => 'required',
            'payment'      => 'required',
            'fname'        => 'required',
            'lname'        => 'required',
            'address'      => 'required',
            'zip'          => 'required',
            'city'         => 'required',
            'phone'        => 'required',
            'email'        => 'required',
            'ship_fname'   => 'required',
            'ship_lname'   => 'required',
            'ship_address' => 'required',
            'ship_zip'     => 'required',
            'ship_city'    => 'required',
            'ship_phone'   => 'required',
            'ship_email'   => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function resolveClients()
    {
        $response = [];
        $order = json_decode($this->request->order_data);
        $items = $order->items;

        foreach ($items as $item) {
            $response[$item->associatedModel->client_id][] = $item;
        }

        return collect($response);
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function resolveClientShipping()
    {
        $response = [];
        $order = json_decode($this->request->order_data);
        $items = $order->shipping;

        foreach ($items as $item) {
            $response[$item->client_id] = $item;
        }

        return collect($response);
    }


    /**
     * @return string
     */
    public function pay()
    {
        return 'Payment proccess implementation needed..!';
    }


    /**
     * @param $client_id
     * @param $items
     *
     * @return bool
     */
    public function make($client_id, $items, $shipping)
    {
        $id = $this->insertGetId([
            'client_id'        => $client_id,
            'user_id'          => auth()->user() ? auth()->user()->id : 0,
            'order_status_id'  => 1,
            'payment_fname'    => $this->request->fname,
            'payment_lname'    => $this->request->lname,
            'payment_address'  => $this->request->address,
            'payment_zip'      => $this->request->zip,
            'payment_city'     => $this->request->city,
            'payment_phone'    => $this->request->phone ? $this->request->phone : null,
            'payment_email'    => $this->request->email,
            'payment_method'   => $this->request->payment,
            'payment_code'     => null,
            'shipping_fname'   => $this->request->ship_fname,
            'shipping_lname'   => $this->request->ship_lname,
            'shipping_address' => $this->request->ship_address,
            'shipping_zip'     => $this->request->ship_zip,
            'shipping_city'    => $this->request->ship_city,
            'shipping_phone'   => $this->request->ship_phone ? $this->request->ship_phone : null,
            'shipping_email'   => $this->request->ship_email,
            'shipping_method'  => $this->request->shipping,
            'shipping_code'    => '',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            OrderProduct::make($items, $id);
            OrderTotal::make($items, $id, $shipping);

            return $this->find($id);
        }

        return false;
    }


    /**
     * @param null $id
     *
     * @return bool
     */
    public function store($id = null)
    {
        $order = $id ? $this->updateData($id) : $this->storeData();

        if ($order) {
            OrderProduct::store(json_decode($this->request->items), $order->id);
            OrderTotal::store(json_decode($this->request->sums), $order->id);

            return $order;
        }

        return false;
    }


    /**
     * @return bool
     */
    private function storeData()
    {
        $id = $this->insertGetId([
            'client_id'        => auth()->user()->clientId() ? auth()->user()->clientId() : 0,
            'order_status_id'  => $this->request->order_status,
            'payment_fname'    => $this->request->fname,
            'payment_lname'    => $this->request->lname,
            'payment_address'  => $this->request->address,
            'payment_zip'      => $this->request->zip,
            'payment_city'     => $this->request->city,
            'payment_phone'    => $this->request->phone ? $this->request->phone : null,
            'payment_email'    => $this->request->email,
            'payment_method'   => $this->request->payment_method,
            'payment_code'     => null,
            'shipping_fname'   => $this->request->fname,
            'shipping_lname'   => $this->request->lname,
            'shipping_address' => $this->request->address,
            'shipping_zip'     => $this->request->zip,
            'shipping_city'    => $this->request->city,
            'shipping_phone'   => $this->request->phone ? $this->request->phone : null,
            'shipping_email'   => $this->request->email,
            'shipping_method'  => $this->request->shipping_method,
            'shipping_code'    => '',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * @param $id
     *
     * @return bool
     */
    private function updateData($id)
    {
        $updated = $this->where('id', $id)->update([
            'order_status_id'  => $this->request->order_status,
            'payment_fname'    => $this->request->fname,
            'payment_lname'    => $this->request->lname,
            'payment_address'  => $this->request->address,
            'payment_zip'      => $this->request->zip,
            'payment_city'     => $this->request->city,
            'payment_phone'    => $this->request->phone ? $this->request->phone : null,
            'payment_email'    => $this->request->email,
            'payment_method'   => $this->request->payment_method,
            'shipping_fname'   => $this->request->fname,
            'shipping_lname'   => $this->request->lname,
            'shipping_address' => $this->request->address,
            'shipping_zip'     => $this->request->zip,
            'shipping_city'    => $this->request->city,
            'shipping_phone'   => $this->request->phone ? $this->request->phone : null,
            'shipping_email'   => $this->request->email,
            'shipping_method'  => $this->request->shipping_method,
            'updated_at'       => Carbon::now()
        ]);

        if ($updated) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * Set Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLatest($count = 15)
    {
        $query = (new Order())->newQuery();

        if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }

        return $query->with('status', 'client')->orderBy('id', 'desc')->limit($count)->get();
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public static function trashComplete($id)
    {
        OrderProduct::where('order_id', $id)->delete();
        OrderTotal::where('order_id', $id)->delete();
        Transaction::where('order_id', $id)->delete();

        return self::where('id', $id)->delete();
    }
}
