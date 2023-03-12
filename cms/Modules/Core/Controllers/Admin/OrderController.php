<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Export\OrderExport;
use Cms\Modules\Core\Requests\CreateOderRequest;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

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

        Session::put('order-search', $request->all());

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
            $search = Session::get('order-search');
            Session::forget('order-search');

            if ($search) {
                return redirect()->route('admin.order.index', [
                    'random-search' => isset($search['random-search']) ? $search['random-search'] : '',
                    'status' => isset($search['status']) ? $search['status'] : '',
                    'account' => isset($search['account']) ? $search['account'] : '',
                    'shipper' => isset($search['shipper']) ? $search['shipper'] : '',
                    'manager' => isset($search['manager']) ? $search['manager'] : '',
                    'start_date' => isset($search['start_date']) ? $search['start_date'] : '',
                    'end_date' => isset($search['end_date']) ? $search['end_date'] : '',
                ])->with('success', 'successful');
            }

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

    public function excel(Request $request)
    {
        return Excel::download(new OrderExport($this->orderService, $request->all()), 'data.xlsx');
    }
}