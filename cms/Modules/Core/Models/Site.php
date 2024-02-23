<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $table = 'sites';

    protected $fillable =
        [
            'name',
            'user_id',
            'status',
            'created_at',
            'updated_at'
        ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function site_log()
    {
        return $this->hasMany(SiteLog::class, 'site_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'site_id');
    }

    public function site_pause_log()
    {
        return $this->hasMany(SitePauseLog::class, 'site_id','id');
    }
}
