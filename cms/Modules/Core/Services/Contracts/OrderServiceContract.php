<?php

namespace Cms\Modules\Core\Services\Contracts;


interface OrderServiceContract
{
    public function findByAccountID($id, $paginate);
}