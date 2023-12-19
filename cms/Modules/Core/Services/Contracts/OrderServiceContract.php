<?php

namespace Cms\Modules\Core\Services\Contracts;


interface OrderServiceContract
{
    public function findAll($paginate);

    public function findByAccountID($id, $paginate);

    public function findByQuery($request, $paginate);

    public function store($data);

    public function findByID($id);

    public function update($id, $data);

    public function delete($id);

    public function downloadExcel($filter);

    public function getRankingByRoleAndTime($role, $time);

    public function getRankingShippedByTime($time);
}
