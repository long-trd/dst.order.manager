<?php

namespace Cms\Modules\Core\Repositories;


use Cms\Modules\Core\Models\Account;
use Cms\Modules\Core\Repositories\Contracts\AccountRepositoryContract;

class AccountRepository implements AccountRepositoryContract
{
    protected $accountModel;

    public function __construct(Account $accountModel)
    {
        $this->accountModel = $accountModel;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->accountModel->all();
    }

    public function paginateAccount($request, $paginate)
    {
        // TODO: Implement paginateAccount() method.
        if (isset($request['id'])) {
            return $this->accountModel
                ->whereHas('users', function ($query) use ($request) {
                    $query->where('users.id', $request['id']);
                })
                ->orderByRaw("FIELD(status , 'live', 'restrict', 'suspended') ASC")
                ->paginate($paginate);

        } else {
            return $this->accountModel->with('users')
                ->orderByRaw("FIELD(status , 'live', 'restrict', 'suspended') ASC")
                ->paginate($paginate);
        }

    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
        return $this->accountModel->with('users')->findOrFail($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        return $this->accountModel->find($id)->update($data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->accountModel->find($id)->delete();
    }

    public function create($data)
    {
        // TODO: Implement create() method.
        return $this->accountModel->create($data);
    }

    public function findByIpAddress($ip)
    {
        // TODO: Implement findByIpAddress() method.
        return $this->accountModel->where('ip_address', $ip)->first();
    }

    public function findByManager($id)
    {
        // TODO: Implement findByManager() method.
        return $this->accountModel
            ->whereHas('users', function ($query) use ($id) {
                $query->where('users.id', $id);
        })->get();
    }
}