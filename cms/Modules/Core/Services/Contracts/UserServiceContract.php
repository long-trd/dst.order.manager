<?php

namespace Cms\Modules\Core\Services\Contracts;

interface UserServiceContract
{
    public function store($data);

    public function getAll();
}
