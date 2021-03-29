<?php

namespace Cms\Modules\Core\Repositories\Contracts;


interface OrderRepositoryContract
{
    public function findByAccountID($id, $paginate);
}