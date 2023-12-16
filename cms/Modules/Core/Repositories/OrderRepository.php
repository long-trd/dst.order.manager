<?php

namespace Cms\Modules\Core\Repositories;


use Carbon\Carbon;
use Cms\Modules\Core\Models\Order;
use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Support\Facades\Schema;

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
        $startDate = $endDate = $account = $shipper = $status = ['orders.id', '!=', null];
        $role = $manager = $shipperRole = ['id', '!=', null];
        $randomSearch = 'orders.id';
        $isManagerQuery = false;
        $isBranchQuery = false;
        $branch = null;

        if (isset($request['random-search'])) {
            $randomSearch = '(';
            $columns = Schema::getColumnListing('orders');
            unset($columns[array_search('id', $columns)]);
            unset($columns[array_search('created_at', $columns)]);
            unset($columns[array_search('updated_at', $columns)]);
            unset($columns[array_search('deleted_at', $columns)]);
            $columns = array_values($columns);

            foreach ($columns as $key => $column) {
                $randomSearch .= "orders." . $column . " like '%" . $request['random-search'] . "%' or ";
            }

            $randomSearch .= "accounts.ip_address like '%" . $request['random-search'] . "%'";

            $randomSearch .= ')';
        }

        if (isset($request['account']) && $request['account'] != 'default') {
            $account = ['orders.account_id', $request['account']];
        }

        if (isset($request['shipper'])) {
            $shipper = ['users.name', 'like', '%' . $request['shipper'] . '%'];
        }

        if (isset($request['manager'])) {
            $manager = ['users.name', 'like', '%' . $request['manager'] . '%'];
            $role = ['name', 'manager'];
            $isManagerQuery = true;
        }

        if (isset($request['branch'])) {
            $branch = ['users.branch', 'like', '%' . $request['branch'] . '%'];
            $isBranchQuery = true;
        }

        if (isset($request['status']) && $request['status'] != 'default') {
            $status = ['orders.status', $request['status']];
        }

        if (isset($request['start_date']) && isset($request['end_date'])) {
            $startDate = ['order_date', '>=', Carbon::parse($request['start_date'])->format('Y-m-d')];
            $endDate = ['order_date', '<=', Carbon::parse($request['end_date'])->format('Y-m-d')];
        } elseif (isset($request['start_date'])) {
            $startDate = ['order_date', '>=', Carbon::parse($request['start_date'])->format('Y-m-d')];
        } elseif (isset($request['end_date'])) {
            $endDate = ['order_date', '<=', Carbon::parse($request['end_date'])->format('Y-m-d')];
        }

        $orders = $this->orderModel
            ->select('orders.id as order_id', 'users.*', 'orders.*')
            ->selectRaw('`orders`.`price` as `order_price`')
            ->leftJoin('users', 'orders.shipping_user_id', '=', 'users.id')
            ->leftJoin('accounts', 'orders.account_id', '=', 'accounts.id')
            ->where(
                [
                    $account,
                    $shipper,
                    $status,
                    $startDate,
                    $endDate
                ]
            )
            ->whereRaw($randomSearch)
            ->when($isManagerQuery, function ($query) use ($manager) {
                $query->whereHas('manager', function ($managerQuery) use ($manager) {
                    $managerQuery->where([$manager]);
                });
            })
            ->when($isBranchQuery, function ($query) use ($branch) {
                $query->whereHas('manager', function ($managerQuery) use ($branch) {
                    $managerQuery->where([$branch]);
                });
            })
            ->with(['account', 'manager'])
            ->orderBy('orders.created_at', 'desc');

        $totalOrderWithoutStatus = $this->orderModel
            ->select('orders.id as order_id', 'users.*', 'orders.*')
            ->selectRaw('`orders`.`price` as `order_price`')
            ->leftJoin('users', 'orders.shipping_user_id', '=', 'users.id')
            ->leftJoin('accounts', 'orders.account_id', '=', 'accounts.id')
            ->where(
                [
                    $account,
                    $shipper,
                    $startDate,
                    $endDate
                ]
            )
            ->whereRaw($randomSearch)
            ->when($isManagerQuery, function ($query) use ($manager) {
                $query->whereHas('manager', function ($managerQuery) use ($manager) {
                    $managerQuery->where([$manager]);
                });
            })
            ->when($isBranchQuery, function ($query) use ($branch) {
                $query->whereHas('manager', function ($managerQuery) use ($branch) {
                    $managerQuery->where([$branch]);
                });
            })
            ->with(['account', 'manager'])
            ->orderBy('orders.created_at', 'desc');

        return [
            'total_amount_by_query' => $orders->get()->sum('order_price'),
            'total_order_by_query' => $orders->count(),
            'paginated_data' => $orders->paginate($paginate),
            'total_order_without_status' => $totalOrderWithoutStatus->count(),
            'total_amount_without_status' => $totalOrderWithoutStatus->get()->sum('order_price'),
        ];
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
            ->with(['helper', 'shipper', 'manager', 'account'])
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

    public function downloadExcel($filter)
    {
        $rawSelect = 'orders.name, orders.ebay_url, orders.product_url';

        if (isset($filter['option']) && count($filter['option']) > 0) {
            foreach ($filter['option'] as $option) {
                if (in_array($option, ['order_date', 'price', 'quantity']))
                    $rawSelect .= ', orders.' . $option;
                else if ($option === 'shipper')
                    $rawSelect .= ', shipper.name as shipper_name ';
                else if ($option === 'list')
                    $rawSelect .= ', manager.name as manager_name';
            }
        }

        return $this->orderModel
            ->selectRaw($rawSelect)
            ->join('users as shipper', 'shipper.id', '=', 'orders.shipping_user_id')
            ->join('users as manager', 'manager.id', '=', 'orders.listing_user_id')
            ->where([
                ['order_date', '>=', $filter['start_date'] ? Carbon::parse($filter['start_date'])->format('Y-m-d') : '1999-01-01'],
                ['order_date', '<=', $filter['end_date'] ? Carbon::parse($filter['end_date'])->format('Y-m-d') : '2099-12-31']
            ])
            ->get();
    }
}
