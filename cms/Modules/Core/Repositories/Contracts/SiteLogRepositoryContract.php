<?php

namespace Cms\Modules\Core\Repositories\Contracts;


interface SiteLogRepositoryContract
{
    public function getAll();

    public function store($data);
}
