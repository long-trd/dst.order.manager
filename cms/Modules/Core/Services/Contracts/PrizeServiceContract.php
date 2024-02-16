<?php

namespace Cms\Modules\Core\Services\Contracts;


interface PrizeServiceContract
{
    public function paginate();

    public function getAll();

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function getPrizeByWheelEventId($wheelEventId);

    public function countPrizeByUser($userId, $wheelEventId);
}
