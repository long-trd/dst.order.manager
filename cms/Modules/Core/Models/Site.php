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
}
