<?php

namespace Cms\Modules\Core\Services;

use Carbon\Carbon;
use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
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
        $dataUser = false;
        $user = false;
        $roleCheck = true;
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($data as $key => $value) {
            if ($key != 'role') {
                $dataUser[$key] = $value;
            }
        }

        if ($dataUser) {
            $user = $this->user->store($dataUser);
        }

        foreach ($data['role'] as $roleID) {
            if (!$this->user->findRole($roleID)) $roleCheck = false;
        }

        if ($roleCheck && $user) $user->roles()->attach($data['role']);

        return true;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->user->getAll();
    }

    public function getAllWithPaginate($paginate)
    {
        return $this->user->getAllWithPaginate($paginate);
    }

    public function findById($id)
    {
        return $this->user->findById($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.

        $dataUser = false;

        foreach ($data as $key => $value) {
            if ($key != 'role' && $key != 'password_confirmation' && $key != 'password') {
                $dataUser[$key] = $value;
            }

            if ($key == 'password' && $value != null) {
                $dataUser[$key] = Hash::make($value);
            }
        }

        if ($dataUser) {
            $this->user->update($id, $dataUser);
        }

        $user = $this->findById($id);
        $roleCheck = true;

        foreach ($data['role'] as $roleID) {
            if (!$this->user->findRole($roleID)) $roleCheck = false;
        }

        if ($roleCheck) $user->roles()->sync($data['role']);

        return true;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->user->delete($id);
    }

    public function findAllShipper()
    {
        // TODO: Implement findAllShipper() method.
        return $this->user->findAllShipper();
    }

    public function updateNote($id, $note)
    {
        // TODO: Implement updateNote() method.
        return $this->user->update($id, $note);
    }
}
