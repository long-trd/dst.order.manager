<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $table = 'prizes';

    protected $fillable = [
        'img',
        'text',
        'unit',
        'number',
        'percentage',
        'wheel_event_id'
    ];

    public function wheelEvent()
    {
        return $this->belongsTo(WheelEvent::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'prize_user', 'prize_id', 'user_id');
    }
}
