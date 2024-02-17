<?php

namespace Cms\Modules\Core\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'notes', 'branch'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class,'role_user');
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'user_account', 'user_id');
    }

    public function prize()
    {
        return $this->belongsToMany(Prize::class, 'prize_user', 'user_id', 'prize_id');
    }

    public function getPrizeNumberAttribute()
    {
        return $this->prize()->whereRelation('wheelEvent', function ($q) {
            $q->where('active_date', date('Y-m-d'));
        })->count();
    }
}
