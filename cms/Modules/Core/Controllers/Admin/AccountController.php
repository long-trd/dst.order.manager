<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Requests\CreateAccountRequest;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;
    protected $userService;

    public function __construct(AccountServiceContract $accountService, UserServiceContract $userService)
    {
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $paginate = 10;

        $accounts = $this->accountService->paginateAccount($request->all(), $paginate);

        return view('Core::account.index', ['accounts' => $accounts]);
    }

    public function create()
    {
        $users = $this->userService->getAll();

        return view('Core::account.create', ['users' => $users]);
    }

    public function store(CreateAccountRequest $request)
    {
        $data = auth()->user()->hasRole('admin') ? $request->only(['ip_address', 'email', 'status', 'paypal_notes']) : $request->only(['ip_address', 'email', 'status']);

        if ($this->accountService->create($data)) {
            return redirect()->route('admin.account.index');
        }

        abort(404);
    }

    public function edit($id)
    {
        $users = $this->userService->getAll();
        $account = $this->accountService->findByID($id);

        return view('Core::account.edit', ['account' => $account, 'users' => $users]);
    }

    public function update($id, CreateAccountRequest $request)
    {
        $data = auth()->user()->hasRole('admin') ? $request->only(['shipper','ip_address', 'email', 'status', 'paypal_notes']) : $request->only(['shipper', 'ip_address', 'email', 'status']);

        if ($this->accountService->update($id, $data)) {
            return redirect()->route('admin.account.edit', ['id' => $id]);
        }

        abort(403);
    }

    public function delete($id)
    {
        if ($this->accountService->delete($id)) {
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