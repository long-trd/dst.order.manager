<?php

namespace Cms\Modules\Core\Services\Contracts;


interface AccountServiceContract
{
    public function getAll();

    public function paginateAccount($paginate);

    public function findByID($id);

    public function update($id, $data);

    public function delete($id);

    public function create($data);
}