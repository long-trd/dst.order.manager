<?php

namespace Cms\Modules\Core\Repositories\Contracts;

interface UserRepositoryContract
{
    public function getModel();

    public function store($data);

    public function getAll();

    public function getAllWithPaginate($paginate);

    public function findById($id);

    public function update($id, $data);

    public function findRole($id);

    public function delete($id);
}
