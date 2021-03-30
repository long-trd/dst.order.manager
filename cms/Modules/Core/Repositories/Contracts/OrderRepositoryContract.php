<?php

namespace Cms\Modules\Core\Repositories\Contracts;


interface OrderRepositoryContract
{
    public function findAll($paginate);

    public function findByAccountID($id, $paginate);

    public function findByQuery($request, $paginate);

    public function store($data);

    public function findByID($id);

    public function update($id, $data);

    public function delete($id);
}