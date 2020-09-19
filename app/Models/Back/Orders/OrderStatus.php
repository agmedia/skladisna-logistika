<?php

namespace App\Models\Back\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    /**
     * @var string
     */
    protected $table = 'order_status';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
