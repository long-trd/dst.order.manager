<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cms\Modules\Core\Requests\CreateNotificationRequest;
use Cms\Modules\Core\Requests\UpdateUserRequest;
use Cms\Modules\Core\Services\Contracts\NotificationServiceContract;

class NotificationController extends Controller
{
    protected $service;

    public function __construct(NotificationServiceContract $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $paginate = 20;
        $notifications = $this->service->paginate($paginate);

        return view('Core::notification.index', ['notifications' => $notifications]);
    }

    public function create()
    {
        return view('Core::notification.create');
    }

    public function store(CreateNotificationRequest $request)
    {
        $data['content'] = $request->input('content');
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');

        $notification = $this->service->store($data);

        return redirect()->route('admin.notification.index');
    }

    public function edit($id)
    {
        $notification = $this->service->find($id);

        return view('Core::notification.edit', ['notification' => $notification]);
    }

    public function update($id, CreateNotificationRequest $request)
    {
        $data['content'] = $request->input('content');
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        $notification = $this->service->update($id, $data);

        return redirect()->route('admin.notification.index');
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
