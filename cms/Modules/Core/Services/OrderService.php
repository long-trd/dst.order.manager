<?php

namespace Cms\Modules\Core\Services;


use Carbon\Carbon;
use Cms\Modules\Core\Repositories\Contracts\AccountRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;

class OrderService implements OrderServiceContract
{
    protected $orderRepository;
    protected $accountRepository;

    public function __construct(OrderRepositoryContract $orderRepository, AccountRepositoryContract $accountRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->accountRepository = $accountRepository;
    }

    public function findAll($paginate)
    {
        // TODO: Implement findAll() method.
        return $this->orderRepository->findAll($paginate);
    }

    public function findByAccountID($id, $paginate)
    {
        // TODO: Implement findByAccountID() method.
        return $this->orderRepository->findByAccountID($id, $paginate);
    }

    public function findByQuery($request, $paginate)
    {
        // TODO: Implement findByQuery() method.
        return $this->orderRepository->findByQuery($request, $paginate);
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        $data['order_date'] = Carbon::parse($data['order_date'])->format('Y-m-d');
        $data['listing_user_id'] = auth()->user()->id;
        $data['account_id'] = $this->accountRepository->findByIpAddress($data['account_ip'])->id;
        unset($data['account_ip']);

        return $this->orderRepository->store($data);
    }

    public function findByID($id)
    {
        // TODO: Implement findByID() method.
        return $this->orderRepository->findByID($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')) $data['shipping_user_id'] = auth()->user()->id;

        $order = $this->findByID($id);
        $data['order_date'] = Carbon::parse($data['order_date'])->format('Y-m-d');

        if ($order->status == 'needhelp') {
            if ($data['status'] == 'tracking' || $data['status'] == 'shipped') {
                $data['helping_user_id'] = auth()->user()->id;
            }
        }

        return $this->orderRepository->update($id, $data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->orderRepository->delete($id);
    }
}