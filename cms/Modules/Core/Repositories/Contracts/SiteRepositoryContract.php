<?php

namespace Cms\Modules\Core\Repositories\Contracts;


interface SiteRepositoryContract
{
    public function getAll();

    public function paginate($data);

    public function store($data);

    public function find($id);

    public function update($id, $data);

    public function delete($id);

    public function findByQuery($request, $paginate);

    public function getActiveSite();
}
