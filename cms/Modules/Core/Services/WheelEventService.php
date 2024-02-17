<?php

namespace Cms\Modules\Core\Services;

use Carbon\Carbon;
use Cms\Modules\Core\Repositories\Contracts\WheelEventRepositoryContract;
use Cms\Modules\Core\Services\Contracts\WheelEventServiceContract;

class WheelEventService implements WheelEventServiceContract
{
    protected $repository;

    function __construct
    (
        WheelEventRepositoryContract $repository
    )
    {
        $this->repository = $repository;
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }


    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function wheelEventActive()
    {
        return $this->repository->wheelEventActive();
    }
}

