<?php

namespace Cms\Modules\Core\Repositories;


use Cms\Modules\Core\Models\Order;
use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;

class OrderRepository implements OrderRepositoryContract
{
    protected $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function findByAccountID($id, $paginate)
    {
        // TODO: Implement findByAccountID() method.
        return $this->orderModel
            ->where('account_id', $id)
            ->with('account')
            ->paginate($paginate);
    }
}