<?php

namespace Cms\Modules\Core\Repositories\Contracts;


interface WheelEventRepositoryContract
{
    public function paginate();

    public function getAll();

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function wheelEventActive();
}
