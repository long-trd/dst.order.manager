<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cms\Modules\Core\Models\Role;
use Cms\Modules\Core\Requests\CreateOderRequest;
use Cms\Modules\Core\Requests\CreateUserRequest;
use Cms\Modules\Core\Requests\UpdateUserRequest;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $paginate = 50;
        $users = $this->userService->getAllWithPaginate($paginate);

        return view('Core::user.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();

        return view('Core::user.create', ['roles' => $roles]);
    }

    public function store(CreateUserRequest $request)
    {
        $request = $request->except('_token');

        if ($this->userService->store($request)) {
            return redirect()->route('admin.user.index');
        }

        abort(404);
    }

    public function edit($id)
    {
        $user = $this->userService->findById($id);
        $roles = Role::all();

        if (!$user) abort(404);

        return view('Core::user.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update($id, UpdateUserRequest $request)
    {
        $request = $request->except(['_token', '_method']);

        if ($this->userService->update($id, $request)) {
            return redirect()->route('admin.user.edit', ['id' => $id])->with('success', 'successful');
        }

        abort(404);
    }

    public function delete($id)
    {
        if ($this->userService->delete($id)) {
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
