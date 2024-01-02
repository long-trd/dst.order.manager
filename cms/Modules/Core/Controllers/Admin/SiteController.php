<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cms\Modules\Core\Requests\CreateSiteRequest;
use Cms\Modules\Core\Services\Contracts\SiteServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $service;
    protected $userService;

    public function __construct
    (
        SiteServiceContract $service,
        UserServiceContract $userService
    )
    {
        $this->service = $service;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $paginate = 20;
        $request = $request->toArray();
        $sites = $this->service->findByQuery($request, $paginate);
        $users = $this->userService->getAll();

        return view('Core::site.index', ['sites' => $sites, 'users' => $users, 'request' => $request]);
    }

    public function create()
    {
        $users = $this->userService->getAll();

        return view('Core::site.create', ['users' => $users]);
    }

    public function store(CreateSiteRequest $request)
    {
        $data['name'] = $request->name;
        $data['user_id'] = $request->user_id;
        $data['status'] = $request->status;

        $site = $this->service->store($data);

        return redirect()->route('admin.site.index');
    }

    public function edit($id)
    {
        $site = $this->service->find($id);
        $users = $this->userService->getAll();

        return view('Core::site.edit', ['site' => $site, 'users' => $users]);
    }

    public function update($id, CreateSiteRequest $request)
    {
        $data['name'] = $request->name;
        $data['user_id'] = $request->user_id;
        $data['status'] = $request->status;

        $site = $this->service->update($id, $data);

        return redirect()->route('admin.site.index');
    }

    public function delete($id)
    {
        if ($this->service->delete($id)) {
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
