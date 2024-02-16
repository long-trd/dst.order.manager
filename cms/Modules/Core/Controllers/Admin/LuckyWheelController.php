<?php

namespace Cms\Modules\Core\Controllers\Admin;

use Cms\Modules\Core\Services\Contracts\PrizeServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Cms\Modules\Core\Services\Contracts\WheelEventServiceContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LuckyWheelController extends Controller
{
    public $userService;

    public $wheelEventService;

    public $prizeService;

    public function __construct(
        WheelEventServiceContract $wheelEventService,
        PrizeServiceContract $prizeService,
        UserServiceContract $userService
    )
    {
        $this->wheelEventService = $wheelEventService;
        $this->prizeService = $prizeService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $wheelEvent = $this->wheelEventService->wheelEventActive();

        if (!$wheelEvent)
            return abort(404);

        $userLogin = $this->userService->userFormat(Auth::user()->toArray(), $wheelEvent->id);

        return view('Core::wheel.event', compact('userLogin', 'wheelEvent'));
    }

    public function getGift()
    {
        $wheelEvent = $this->wheelEventService->wheelEventActive();
        $result = $this->userService->getGift($wheelEvent->id);

        return response()->json($result);
    }

    public function updatePrizeNumber(Request $request, $id)
    {
        $this->prizeService->update($id, $request);

        return response()->json(['status' => 200, 'message' => 'Update prize number success!']);
    }

    public function getPrize()
    {
        $wheelEvent = $this->wheelEventService->wheelEventActive();
        $prizes = $this->prizeService->getPrizeByWheelEventId($wheelEvent->id);

        return response()->json($prizes);
    }

    public function postGift(Request $request, $userId)
    {
        $data = $request->all();
        $response = [
            'status' => 400,
            'message' => 'Bad request!'
        ];

        if ($this->userService->postGift($userId, $data))
            $response = ['status' => 200, 'message' => 'Post gift success!'];

        return response()->json($response);
    }
}
