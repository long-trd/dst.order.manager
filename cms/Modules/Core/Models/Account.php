<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'accounts';

    protected $fillable =
        [
            'email',
            'ip_address',
            'status',
            'paypal_notes',
            'deleted_at',
            'created_at',
            'updated_at'
        ];

    protected $hidden = [];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleting(function($topic) {
            $topic->comments()->delete();
            $topic->likes()->delete();
            $topic->notifications()->delete();
        });
    }
}
