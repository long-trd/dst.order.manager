<?php

namespace Cms\Modules\Core\Repositories;

use Cms\Modules\Core\Models\Prize;
use Cms\Modules\Core\Repositories\Contracts\PrizeRepositoryContract;

class PrizeRepository implements PrizeRepositoryContract
{
    protected $model;

    public function __construct(Prize $model) {
        $this->model = $model;
    }

    public function paginate()
    {
        return $this->model->with('wheelEvent')->paginate(10);
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

    public function getPrizeByWheelEventId($wheelEventId)
    {
        return $this->model->where('wheel_event_id', $wheelEventId)->get();
    }

    public function countPrizeByUser($userId, $wheelEventId)
    {
        return $this->model
            ->where('wheel_event_id', $wheelEventId)
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->count();
    }
}

