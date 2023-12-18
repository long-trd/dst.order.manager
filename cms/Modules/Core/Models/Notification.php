<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable =
        [
            'content',
            'start_date',
            'end_date',
            'created_at',
            'updated_at'
        ];

    protected $hidden = [];
}
