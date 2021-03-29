<?php

namespace Cms\Modules\Core\Services;


use Cms\Modules\Core\Repositories\Contracts\AccountRepositoryContract;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;

class AccountService implements AccountServiceContract
{
    protected $accountRepository;

    public function __construct(AccountRepositoryContract $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->accountRepository->getAll();
    }

    public function paginateAccount($paginate)
    {
        // TODO: Implement paginateAccount() method.
        return $this->accountRepository->paginateAccount($paginate);
    }

    public function findByID($id)
    {
        // TODO: Implement findByID() method.
        return $this->accountRepository->findById($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        return $this->accountRepository->update($id, $data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->accountRepository->delete($id);
    }

    public function create($data)
    {
        // TODO: Implement create() method.
        return $this->accountRepository->create($data);
    }
}