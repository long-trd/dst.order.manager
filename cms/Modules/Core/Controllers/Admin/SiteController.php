<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cms\Modules\Core\Models\SitePauseLog;
use Cms\Modules\Core\Requests\CreateSiteRequest;
use Cms\Modules\Core\Services\Contracts\SiteLogServiceContract;
use Cms\Modules\Core\Services\Contracts\SiteServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    protected $service;
    protected $userService;
    protected $siteLogService;

    public function __construct
    (
        SiteServiceContract    $service,
        SiteLogServiceContract $siteLogService,
        UserServiceContract    $userService
    )
    {
        $this->service = $service;
        $this->siteLogService = $siteLogService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $paginate = 20;
        $request = $request->toArray();
        $sites = $this->service->findByQuery($request, $paginate);
        $users = $this->userService->findAllShipper();

        return view('Core::site.index', ['sites' => $sites, 'users' => $users, 'request' => $request]);
    }

    public function create()
    {
        $users = $this->userService->findAllShipper();

        return view('Core::site.create', ['users' => $users]);
    }

    public function store(CreateSiteRequest $request)
    {
        DB::beginTransaction();
        try {
            $data['name'] = $request->name;
            $data['user_id'] = $request->user_id;
            $data['status'] = $request->status;

            $site = $this->service->store($data);
            $log = $this->siteLogService->store($site, 'created');

            DB::commit();

            return redirect()->route('admin.site.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return abort(500);
        }
    }

    public function edit($id)
    {
        $site = $this->service->find($id);
        $users = $this->userService->findAllShipper();

        return view('Core::site.edit', ['site' => $site, 'users' => $users]);
    }

    public function update($id, CreateSiteRequest $request)
    {
        $oldSite = $this->service->find($id);

        $data['name'] = $request->name;
        $data['user_id'] = $request->user_id;
        $data['status'] = $request->status;

        $lastSitePauseLog = SitePauseLog::where('site_id', $id)->latest()->first();

        if ($lastSitePauseLog) {
            if ($oldSite->status != 'pause' && $data['status'] == 'pause' && $lastSitePauseLog->paused_at != Carbon::now()->toDateString()) {
                SitePauseLog::create(['site_id' => $id, 'paused_at' => Carbon::now()->toDateString()]);
            }
        } else {
            if ($oldSite->status != 'pause' && $data['status'] == 'pause') {
                SitePauseLog::create(['site_id' => $id, 'paused_at' => Carbon::now()->toDateString()]);
            }
        }

        if ($lastSitePauseLog) {
            if ($oldSite->status == 'pause' && $data['status'] == 'live') {
                $lastSitePauseLog->update(['lived_at' => Carbon::now()->toDateString()]);
            }
        }

        $this->service->update($id, $data);

        $newSite = $this->service->find($id);

        $log = $this->siteLogService->store($newSite, 'updated');

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
