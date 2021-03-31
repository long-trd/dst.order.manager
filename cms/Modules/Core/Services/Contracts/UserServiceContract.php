<?php

namespace Cms\Modules\Core\Services\Contracts;

interface UserServiceContract
{
    public function store($data);

    public function getAll();

    public function getAllWithPaginate($paginate);

    public function findById($id);

    public function update($id, $data);

    public function delete($id);
}
