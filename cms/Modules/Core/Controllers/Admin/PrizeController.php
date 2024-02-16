<?php

namespace Cms\Modules\Core\Controllers\Admin;

use Cms\Modules\Core\Requests\PrizeRequest;
use Cms\Modules\Core\Services\Contracts\PrizeServiceContract;
use Cms\Modules\Core\Services\Contracts\WheelEventServiceContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrizeController extends Controller
{
    protected $prizeService;
    protected $wheelEventService;

    public function __construct(PrizeServiceContract $prizeService, WheelEventServiceContract $wheelEventService)
    {
        $this->prizeService = $prizeService;
        $this->wheelEventService = $wheelEventService;
    }

    public function index()
    {
        $prizes = $this->prizeService->paginate();

        return view('Core::prize.index', compact('prizes'));
    }

    public function create()
    {
        $wheelEvents = $this->wheelEventService->getAll();

        return view('Core::prize.create', compact('wheelEvents'));
    }

    public function store(PrizeRequest $request)
    {
        $prize = $this->prizeService->store($request);

        if (!$prize)
            return redirect()->route('admin.prize.create')->with(['warning' => __('Something wrong!') ]);

        return redirect()->route('admin.prize.index')->with('success', __('Created prize success!'));

    }

    public function edit($id)
    {
        $prize = $this->prizeService->find($id);
        $wheelEvents = $this->wheelEventService->getAll();

        return view('Core::prize.edit', compact('prize', 'wheelEvents'));
    }

    public function update(PrizeRequest $request, $id)
    {
        $this->prizeService->update($id, $request);

        return redirect()->route('admin.prize.edit', $id)
            ->with('success', __('Edit prize\'s success!'));
    }

    public function delete($id)
    {
        if ($this->prizeService->delete($id)) {
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
