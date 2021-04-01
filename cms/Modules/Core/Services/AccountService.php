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

    public function paginateAccount($request, $paginate)
    {
        // TODO: Implement paginateAccount() method.
        return $this->accountRepository->paginateAccount($request, $paginate);
    }

    public function findByID($id)
    {
        // TODO: Implement findByID() method.
        return $this->accountRepository->findById($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        $dataAccount = false;

        foreach ($data as $key => $value) {
            if ($key != 'shipper') $dataAccount[$key] = $value;
        }

        if ($dataAccount) {
            $this->accountRepository->update($id, $data);
            $accountUpdated = $this->accountRepository->findById($id);
            $accountUpdated->users()->sync($data['shipper']);
        }

        return true;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->accountRepository->delete($id);
    }

    public function create($data)
    {
        // TODO: Implement create() method.
        $accountCreated = $this->accountRepository->create($data);
        $userAccount['user_id'] = auth()->user()->id;
        $userAccount['account_id'] = $accountCreated->id;
        $accountCreated->users()->attach($accountCreated->id, $userAccount);

        return true;
    }
}