<?php

namespace Cms\Modules\Core\Repositories;

use Cms\Modules\Core\Models\Role;
use Cms\Modules\Core\Models\User;
use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    protected $model;
    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->model = $user;
        $this->role = $role;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    public function getAllWithPaginate($paginate)
    {
        // TODO: Implement getAllWithPaginate() method.
        $query = $this->model
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin');
            });

        if (auth()->user()->hasRole('leader-manager')) {
            $query = $query->whereHas('roles', function ($query) {
                $query->where('name', 'manager');
            });
        }

        if (auth()->user()->hasRole('leader-shipper')) {
            $query = $query->whereHas('roles', function ($query) {
                $query->where('name', 'shipper');
            });
        }

        $users = $query->paginate($paginate);

        return $users;
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        return $this->model->find($id)->update($data);
    }

    public function findRole($id)
    {
        return $this->role->find($id);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->model->find($id)->delete();
    }

    public function findAllShipper()
    {
        // TODO: Implement findAllShipper() method.
        return $this->model->whereHas('role', function ($query) {
            $query->where('name', 'shipper');
        })->get();
    }
}
