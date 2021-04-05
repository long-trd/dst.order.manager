<?php

namespace Cms\Modules\Core\Repositories\Contracts;


interface AccountRepositoryContract
{
    public function getAll();

    public function paginateAccount($request, $paginate);

    public function findById($id);

    public function update($id, $data);

    public function delete($id);

    public function create($data);

    public function findByIpAddress($ip);

    public function findByManager($id);
}