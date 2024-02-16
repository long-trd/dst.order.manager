<?php

namespace Cms\Modules\Core\Repositories;

use Cms\Modules\Core\Models\WheelEvent;
use Cms\Modules\Core\Repositories\Contracts\WheelEventRepositoryContract;

class WheelEventRepository implements WheelEventRepositoryContract
{
    protected $model;

    public function __construct(WheelEvent $model) {
        $this->model = $model;
    }

    public function paginate()
    {
        return $this->model->paginate(10);
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function wheelEventActive()
    {
        return $this->model->whereDate('active_date', date('Y-m-d'))->first();
    }
}

