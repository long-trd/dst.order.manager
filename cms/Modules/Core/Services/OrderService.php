<?php

namespace Cms\Modules\Core\Services;


use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;

class OrderService implements OrderServiceContract
{
    protected $orderRepository;

    public function __construct(OrderRepositoryContract $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function findByAccountID($id, $paginate)
    {
        // TODO: Implement findByAccountID() method.
        return $this->orderRepository->findByAccountID($id, $paginate);
    }
}