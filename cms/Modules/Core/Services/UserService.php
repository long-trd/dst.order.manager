<?php

namespace Cms\Modules\Core\Services;

use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;
use Cms\Modules\Core\Services\Contacts\UserServiceContract;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceContract
{
    protected $user;

    public function __construct(UserRepositoryContract $user)
    {
        $this->user = $user;
    }

    public function store($data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->user->store($data);
    }
}
