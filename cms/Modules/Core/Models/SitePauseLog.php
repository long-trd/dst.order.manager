<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SitePauseLog extends Model
{
    protected $table = 'site_pause_log';

    protected $fillable =
        [
            'site_id',
            'paused_at',
            'lived_at',
        ];

    protected $hidden = [];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }
}
