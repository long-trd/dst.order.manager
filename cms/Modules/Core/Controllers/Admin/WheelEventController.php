<?php

namespace Cms\Modules\Core\Controllers\Admin;

use App\Http\Controllers\Controller;
use Cms\Modules\Core\Requests\WheelEventRequest;
use Cms\Modules\Core\Services\Contracts\WheelEventServiceContract;

class WheelEventController extends Controller
{
    protected $wheelEventService;

    public function __construct(WheelEventServiceContract $wheelEventService)
    {
        $this->wheelEventService = $wheelEventService;
    }

    public function index()
    {
        $wheelEvents = $this->wheelEventService->paginate();

        return view('Core::wheel.index', compact('wheelEvents'));
    }

    public function create()
    {
        return view('Core::wheel.create');
    }

    public function store(WheelEventRequest $request)
    {
        $data = $request->all();
        $wheelEvent = $this->wheelEventService->store($data);

        if (!$wheelEvent)
            return redirect()->route('admin.wheel.create')->with(['warning' => __('Something wrong!')]);

        return redirect()->route('admin.wheel.index')->with('success', __('Created event success!'));

    }

    public function edit($id)
    {
        $wheelEvent = $this->wheelEventService->find($id);

        return view('Core::wheel.edit', compact('wheelEvent'));
    }

    public function update(WheelEventRequest $request, $id)
    {
        $data = $request->all();
        $this->wheelEventService->update($id, $data);

        return redirect()->route('admin.wheel.edit', $id)
            ->with('success', __('Edit event success!'));
    }

    public function delete($id)
    {
        $wheelEvent = $this->wheelEventService->find($id);

        if ($wheelEvent) {
            $wheelEvent->delete();

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
