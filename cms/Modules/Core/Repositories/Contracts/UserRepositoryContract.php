<?php

namespace Cms\Modules\Core\Repositories\Contracts;

interface UserRepositoryContract
{
    public function getModel();
    public function store($data);
}
