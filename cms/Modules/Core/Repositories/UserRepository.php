<?php

namespace Cms\Modules\Core\Repositories;

use Cms\Modules\Core\Models\User;
use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function store($data)
    {
        return $this->model->create($data);
    }
}
