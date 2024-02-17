<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteLog extends Model
{
    protected $table = 'site_logs';

    protected $fillable =
        [
            'site_id',
            'editor_id',
            'message',
            'created_at',
            'updated_at'
        ];

    protected $hidden = [];
}
