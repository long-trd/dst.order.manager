<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountServiceContract $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $paginate = 10;

        $accounts = $this->accountService->paginateAccount($paginate);

        return view('Core::account.index', ['accounts' => $accounts]);
    }

    public function create()
    {
        return view('Core::account.create');
    }

    public function store(Request $request)
    {
        $data = auth()->user()->hasRole('admin') ? $request->only(['ip_address', 'email', 'status', 'paypal_notes']) : $request->only(['ip_address', 'email', 'status']);

        if ($this->accountService->create($data)) {
            return redirect()->route('admin.account.index');
        }

        abort(404);
    }

    public function edit($id)
    {
        $account = $this->accountService->findByID($id);

        return view('Core::account.edit', ['account' => $account]);
    }

    public function update($id, Request $request)
    {
        $data = auth()->user()->hasRole('admin') ? $request->only(['ip_address', 'email', 'status', 'paypal_notes']) : $request->only(['ip_address', 'email', 'status']);

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