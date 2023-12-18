<?php

namespace Cms\Modules\Core\Repositories;

use Carbon\Carbon;
use Cms\Modules\Core\Models\Notification;
use Cms\Modules\Core\Repositories\Contracts\NotificationRepositoryContract;

class NotificationRepository implements NotificationRepositoryContract
{
    protected $model;

    public function __construct(Notification $model) {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function paginate($data)
    {
        return $this->model->paginate($data);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getCurrentNotification()
    {
        $notifications = $this->model
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->get();

        return $notifications;
    }
}

