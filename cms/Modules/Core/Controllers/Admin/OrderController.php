<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Requests\CreateOderRequest;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    protected $accountService;
    protected $userService;

    public function __construct(OrderServiceContract $orderService, AccountServiceContract $accountService, UserServiceContract $userService)
    {
        $this->orderService = $orderService;
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $paginate = 50;
        $totalPrice = 0;

        $orders = $this->orderService->findByQuery($request->all(), $paginate);

        foreach ($orders as $order) {
            $totalPrice += intval($order->price) * intval($order->quantity);
        }

        $accounts = $this->accountService->getAll();

        return view('Core::order.index', ['orders' => $orders, 'totalPrice' => $totalPrice, 'accounts' => $accounts, 'request' => $request->all()]);
    }

    public function create()
    {
        $shippers = $this->userService->findAllShipper();

        $accounts = $this->accountService->findByManager(auth()->user()->id);

        if (!$shippers) return redirect()->route('admin.order.index')->withErrors(['shipper' => "Don't have any shipper"]);

        return view('Core::order.create', ['shippers' => $shippers, 'accounts' => $accounts]);
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
            return redirect()->route('admin.order.index')->with('success', 'successful');
        }

        abort(404);
    }

    public function detail($id)
    {
        return response()->json([
            'error' => false,
            'status' => 200,
            'message' => 'success',
            'data' => $this->orderService->findByID($id)
        ]);
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