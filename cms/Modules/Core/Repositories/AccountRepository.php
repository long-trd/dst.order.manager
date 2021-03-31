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

    public function paginateAccount($paginate)
    {
        // TODO: Implement paginateAccount() method.
        return $this->accountModel->with('users')->paginate($paginate);
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
}