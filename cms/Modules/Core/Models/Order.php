<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable =
        [
            'shipping_user_id',
            'helping_user_id',
            'name',
            'ebay_url',
            'product_url',
            'status',
            'shipping_information',
            'price',
            'quantity',
            'order_date',
            'customer_notes',
            'tracking',
            'paypal_notes',
            'created_at',
            'updated_at',
            'deleted_at'
        ];

    protected $hidden = [];
}
