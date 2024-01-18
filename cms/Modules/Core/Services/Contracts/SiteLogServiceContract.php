<?php

namespace Cms\Modules\Core\Services\Contracts;


interface SiteLogServiceContract
{
    public function getAll();

    public function store($site, $type);
}
