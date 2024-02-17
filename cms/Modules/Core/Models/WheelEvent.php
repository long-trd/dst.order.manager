<?php

namespace Cms\Modules\Core\Models;


use Illuminate\Database\Eloquent\Model;

class WheelEvent extends Model
{
    protected $table = 'wheel_events';
    protected $fillable = [
        'name',
        'active_date'
    ];

    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }
}
