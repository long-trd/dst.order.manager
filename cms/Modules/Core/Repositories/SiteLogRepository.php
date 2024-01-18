<?php

namespace Cms\Modules\Core\Repositories;

use Cms\Modules\Core\Models\SiteLog;
use Cms\Modules\Core\Repositories\Contracts\SiteLogRepositoryContract;

class SiteLogRepository implements SiteLogRepositoryContract
{
    protected $model;

    public function __construct(SiteLog $model) {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get();
    }


    public function store($data)
    {
        return $this->model->create($data);
    }
}

