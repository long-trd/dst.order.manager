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
            'account_id',
            'shipping_user_id',
            'helping_user_id',
            'listing_user_id',
            'site_id',
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
            'deleted_at',
            'shipper_name',
            'manager_name',
            'network'
        ];

    protected $hidden = [];

    public function shipper()
    {
        return $this->belongsTo(User::class, 'shipping_user_id');
    }

    public function helper()
    {
        return $this->belongsTo(User::class, 'helping_user_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'listing_user_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
