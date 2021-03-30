<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Requests\CreateOderRequest;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    protected $accountService;

    public function __construct(OrderServiceContract $orderService, AccountServiceContract $accountService)
    {
        $this->orderService = $orderService;
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        $paginate = 50;
        $totalPrice = 0;

        $orders = $this->orderService->findByQuery($request->all(), $paginate);

        foreach ($orders as $order) {
            $totalPrice += $order->price;
        }

        $accounts = $this->accountService->getAll();

        return view('Core::order.index', ['orders' => $orders, 'totalPrice' => $totalPrice, 'accounts' => $accounts, 'request' => $request->all()]);
    }

    public function create()
    {
        return view('Core::order.create');
    }

    public function store(CreateOderRequest $request)
    {
        $request = $request->except('_token');

        if ($this->orderService->store($request)) {
            return redirect()->route('admin.order.index');
        }

        abort(404);
    }

    public function edit($id)
    {
        $order = $this->orderService->findByID($id);

        return view('Core::order.edit', ['order' => $order]);
    }

    public function update($id, CreateOderRequest $request)
    {
        $request = $request->except('_token');

        if ($this->orderService->update($id, $request)) {
            return redirect()->route('admin.order.edit', ['id' => $id])->with('success', 'successful');
        }

        abort(404);
    }

    public function delete($id)
    {
        if ($this->orderService->delete($id)) {
            return response()->json([
                'error' => false,
                'status' => 201,
                'message' => 'success',
                'data' => ''
            ], 201);
        }

        return response()->json([
            'error' => true,
            'status' => 400,
            'message' => 'failed',
            'data' => ''
        ], 400);
    }
}