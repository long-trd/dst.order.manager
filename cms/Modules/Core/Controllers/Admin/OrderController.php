<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;

class OrderController extends Controller
{
    protected $orderService;
    protected $accountService;

    public function __construct(OrderServiceContract $orderService, AccountServiceContract $accountService)
    {
        $this->orderService = $orderService;
        $this->accountService = $accountService;
    }

    public function index($id)
    {
        $paginate = 10;
        $orders = $this->orderService->findByAccountID($id, $paginate);
        $account = $this->accountService->findByID($id);

        return view('Core::order.index', ['orders' => $orders, 'account' => $account]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update($id, Request $request)
    {

    }

    public function delete($id)
    {

    }
}