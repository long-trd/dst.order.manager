<?php

namespace Cms\Modules\Core\Repositories;


use Carbon\Carbon;
use Cms\Modules\Core\Models\Order;
use Cms\Modules\Core\Models\Site;
use Cms\Modules\Core\Models\SitePauseLog;
use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderRepository implements OrderRepositoryContract
{
    protected $orderModel;
    protected $siteModel;
    protected $sitePauseLogModel;

    public function __construct
    (
        Order $orderModel,
        Site $siteModel,
        SitePauseLog $sitePauseLogModel
    )
    {
        $this->orderModel = $orderModel;
        $this->siteModel = $siteModel;
        $this->sitePauseLogModel = $sitePauseLogModel;
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
        $startDate = $endDate = $account = $site = $shipper = $status = ['orders.id', '!=', null];
        $role = $manager = $shipperRole = ['id', '!=', null];
        $randomSearch = 'orders.id';
        $isManagerQuery = false;
        $isBranchQuery = false;
        $branch = null;
        $sites = $this->siteModel->all();

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

        if (isset($request['site']) && $request['site'] != 'default') {
            $site = ['orders.site_id', $request['site']];
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
                    $endDate,
                    $site
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
                })->orWhereHas('shipper', function ($shipperQuery) use ($branch) {
                    $shipperQuery->where([$branch]);
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
                    $endDate,
                    $site
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
                })->orWhereHas('shipper', function ($shipperQuery) use ($branch) {
                    $shipperQuery->where([$branch]);
                });
            })
            ->with(['account', 'manager'])
            ->orderBy('orders.created_at', 'desc');

        $ordersIgnoreSitePause = [
            'total_amount' => 0,
            'quantity' => 0
        ];

        foreach ($sites as $item) {
            $arrDaySitePause = $this->sitePauseLogModel->where('site_id', $item->id)->get();
            if (count($arrDaySitePause) > 0) {
                foreach ($arrDaySitePause as $log) {
                    $ordersIgnore = $this->orderModel
                        ->select('orders.id as order_id', 'users.*', 'orders.*')
                        ->selectRaw('`orders`.`price` as `order_price`')
                        ->leftJoin('users', 'orders.shipping_user_id', '=', 'users.id')
                        ->leftJoin('accounts', 'orders.account_id', '=', 'accounts.id')
                        ->whereDate('order_date', '>', $log->paused_at)
                        ->when($log->lived_at, function ($query, $lived_at) {
                            return $query->whereDate('order_date', '<=', $lived_at);
                        })
                        ->where('site_id', $item->id)
                        ->where('orders.status','!=', 'shipped')
                        ->where(
                            [
                                $account,
                                $shipper,
                                $status,
                                $startDate,
                                $endDate,
                                $site
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
                            })->orWhereHas('shipper', function ($shipperQuery) use ($branch) {
                                $shipperQuery->where([$branch]);
                            });
                        })
                        ->with(['account', 'manager'])
                        ->orderBy('orders.created_at', 'desc');

                    $ordersIgnoreSitePause['total_amount'] += $ordersIgnore->get()->sum('order_price');
                    $ordersIgnoreSitePause['quantity'] += $ordersIgnore->count();
                }
            }
        }

        return [
            'total_amount_by_query' => $orders->get()->sum('order_price'),
            'total_order_by_query' => $orders->count(),
            'total_amount_ignore_site' => ($orders->get()->sum('order_price') - $ordersIgnoreSitePause['total_amount']),
            'total_order_ignore_site' => ($orders->count() - $ordersIgnoreSitePause['quantity']),
            'paginated_data' => $orders->paginate($paginate),
            'total_order_without_status' => $totalOrderWithoutStatus->count(),
            'total_amount_without_status' => $totalOrderWithoutStatus->get()->sum('order_price')
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

    public function getRankingByRoleAndTime($role, $month, $year)
    {
        $columnGroupBy = ($role == 'manager' ? 'listing_user_id' : 'shipping_user_id');

        $query = $this->orderModel
            ->with($role)
            ->select($columnGroupBy, DB::raw('SUM(price) as amount_total'))
            ->whereHas($role);

        if ($role == 'shipper') {
            $query = $query->where('status', 'shipped');
        }

        if ($year) {
            $query = $query->whereYear('order_date', $year);
        }

        if ($month != 'all') {
            $query = $query->whereYear('order_date', $year)->whereMonth('order_date', $month);
        }

        $orders = $query->groupBy($columnGroupBy)
            ->orderBy('amount_total', 'desc')
            ->paginate(10);

        return $orders;
    }

    public function getRankingShippedByTime($month, $year)
    {
        $query = $this->orderModel
            ->with('shipper')
            ->select('shipping_user_id',
                DB::raw('(SUM(CASE WHEN status = "shipped" THEN 1 ELSE 0 END) / COUNT(*))*100 as ratio')
            )
            ->whereHas('shipper');

        if ($year) {
            $query = $query->whereYear('order_date', $year);
        }

        if ($month != 'all') {
            $query = $query->whereYear('order_date', $year)->whereMonth('order_date', $month);
        }

        $orders = $query->groupBy('shipping_user_id')
            ->orderByRaw('SUM(CASE WHEN status = "shipped" THEN 1 ELSE 0 END) / COUNT(*) DESC')
            ->get();

        return $orders;
    }

    public function getTop3Shipper()
    {
        $orders = $this->orderModel
            ->with('shipper')
            ->select(
                'shipping_user_id',
                DB::raw('SUM(CASE WHEN status = "shipped" THEN price ELSE 0 END) as amount_total'),
                DB::raw('SUM(CASE WHEN status = "shipped" THEN 1 ELSE 0 END) / COUNT(*) * 100 as shipped_ratio')
            )
            ->whereYear('order_date', Carbon::now()->year)
            ->whereMonth('order_date', Carbon::now()->month)
            ->groupBy('shipping_user_id')
            ->orderBy('amount_total', 'desc')
            ->take(3)
            ->get();

        return $orders;

    }

    public function getTop3Manager()
    {
        $orders = $this->orderModel
            ->with('manager')
            ->select(
                'listing_user_id',
                DB::raw('SUM(price) as amount_total'),
                DB::raw('SUM(CASE WHEN status = "shipped" THEN 1 ELSE 0 END) / COUNT(*) * 100 as shipped_ratio')
            )
            ->whereYear('order_date', Carbon::now()->year)
            ->whereMonth('order_date', Carbon::now()->month)
            ->groupBy('listing_user_id')
            ->orderBy('amount_total', 'desc')
            ->take(3)
            ->get();

        return $orders;
    }
}
