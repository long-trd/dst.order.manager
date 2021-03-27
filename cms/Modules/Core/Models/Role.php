<?php

namespace Cms\Modules\Core\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';

    protected $fillable = ['name','display_name','description','created_at','updated_at'];

    protected $hidden = [];
}
