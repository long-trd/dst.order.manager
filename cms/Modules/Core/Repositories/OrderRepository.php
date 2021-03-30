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

    public function findAll($paginate)
    {
        // TODO: Implement findAll() method.
        return $this->orderModel
            ->with('account')
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }

    public function findByAccountID($id, $paginate)
    {
        // TODO: Implement findByAccountID() method.
        return $this->orderModel
            ->where('account_id', $id)
            ->with('account')
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }

    public function findByQuery($request, $paginate)
    {
        // TODO: Implement findByQuery() method.
        $account = $shipper = $status = $orderDate = ['orders.id', '!=', null];

        if (isset($request['account'])) {
            $account = ['orders.account_id', $request['account']];
        }

        if (isset($request['shipper'])) {
            $shipper = ['users.name', 'like' , '%' . $request['shipper'] . '%'];
        }

        if (isset($request['status'])) {
            $status = ['orders.status', $request['status']];
        }

        if (isset($request['order_date'])) {
            $orderDate = ['orders.order_date', 'like', '%'. $request['order_date'] .'%'];
        }

        return $this->orderModel
            ->select('orders.id as order_id', 'users.*', 'orders.*')
            ->join('users', 'orders.shipping_user_id', '=', 'users.id')
            ->where(
                [
                    $account,
                    $shipper,
                    $status,
                    $orderDate
                ]
            )
            ->orderBy('orders.created_at', 'desc')
            ->paginate($paginate);
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        return $this->orderModel->create($data);
    }

    public function findByID($id)
    {
        // TODO: Implement findByID() method.
        return $this->orderModel
            ->with(['helper', 'shipper'])
            ->findOrFail($id);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        return $this->orderModel->find($id)->update($data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->orderModel->find($id)->delete();
    }
}