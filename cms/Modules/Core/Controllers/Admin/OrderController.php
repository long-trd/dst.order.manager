<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cms\Modules\Core\Export\OrderExport;
use Cms\Modules\Core\Requests\CreateOderRequest;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\SiteServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    protected $orderService;
    protected $accountService;
    protected $userService;
    protected $siteService;

    public function __construct
    (
        OrderServiceContract $orderService,
        AccountServiceContract $accountService,
        UserServiceContract $userService,
        SiteServiceContract $siteService
    )
    {
        $this->orderService = $orderService;
        $this->accountService = $accountService;
        $this->userService = $userService;
        $this->siteService = $siteService;
    }

    public function index(Request $request)
    {
        $paginate = 50;
        $totalPrice = 0;

        $orders = $this->orderService->findByQuery($request->all(), $paginate);

        Session::put('order-search', $request->all());

        $accounts = $this->accountService->getAll();
        $sites = $this->siteService->getAll();
        $shippers = $this->userService->findAllShipper();

        return view('Core::order.index', [
            'orders' => $orders['paginated_data'],
            'totalAmountByQuery' => $orders['total_amount_by_query'],
            'totalOrderByQuery' => $orders['total_order_by_query'],
            'totalAmountIgnoreSite' => $orders['total_amount_ignore_site'],
            'totalOrderIgnoreSite' => $orders['total_order_ignore_site'],
            'totalAmountWithoutStatus' => $orders['total_amount_without_status'],
            'totalOrderWithoutStatus' => $orders['total_order_without_status'],
            'accounts' => $accounts,
            'sites' => $sites,
            'shippers' => $shippers,
            'request' => $request->all()
        ]);
    }

    public function create()
    {
        $shippers = $this->userService->findAllShipper();

        $accounts = $this->accountService->findByManager(auth()->user()->id);

        $sites = $this->siteService->getActiveSite();

        if (!$shippers) return redirect()->route('admin.order.index')->withErrors(['shipper' => "Don't have any shipper"]);

        return view('Core::order.create', ['shippers' => $shippers, 'accounts' => $accounts, 'sites' => $sites]);
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
        $shippers = $this->userService->findAllShipper();

        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('leader-manager') || auth()->user()->hasRole('leader-shipper') || auth()->id() == $order->shipping_user_id) {
            return view('Core::order.edit', ['order' => $order, 'shippers' => $shippers]);
        }

        return abort(403);
    }

    public function update($id, CreateOderRequest $request)
    {
        $order = $this->orderService->findByID($id);

        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('leader-manager') || auth()->user()->hasRole('leader-shipper') || auth()->id() == $order->shipping_user_id) {
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
                        'branch' => isset($search['branch']) ? $search['branch'] : '',
                        'manager' => isset($search['manager']) ? $search['manager'] : '',
                        'start_date' => isset($search['start_date']) ? $search['start_date'] : '',
                        'end_date' => isset($search['end_date']) ? $search['end_date'] : '',
                        'site' => isset($search['site']) ? $search['site'] : '',
                        'network' => isset($search['network']) ? $search['network'] : ''
                    ])->with('success', 'successful');
                }

                return redirect()->route('admin.order.index')->with('success', 'successful');
            }
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
        $order = $this->orderService->findByID($id);
        $currentTime = Carbon::now();
        $createdAt = Carbon::parse($order->created_at);

        if ($currentTime->greaterThan($createdAt->addMinutes(30)) && !auth()->user()->hasRole('admin')) {
            return response()->json([
                'error' => true,
                'status' => 400,
                'message' => 'failed',
                'data' => ''
            ], 400);
        }

        if ($this->orderService->delete($id)) {
            return response()->json([
                'error' => false,
                'status' => 201,
                'message' => 'success',
                'data' => ''
            ], 201);
        }
    }

    public function excel(Request $request)
    {
        return Excel::download(new OrderExport($this->orderService, $request->all()), 'data.xlsx');
    }
}
