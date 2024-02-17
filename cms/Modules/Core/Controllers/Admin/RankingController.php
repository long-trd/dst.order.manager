<?php

namespace Cms\Modules\Core\Controllers\Admin;

use Carbon\Carbon;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class RankingController
{
    protected $orderService;

    public function __construct(OrderServiceContract $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        //Variables
        $role = $request->role ?? 'manager';
        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;
        $shippedMonth = $request->shippedMonth ?? Carbon::now()->month;
        $shippedYear = $request->shippedYear ?? Carbon::now()->year;
        $page = $request->page ?? 1;
        //Data
        $rankingTotal = $this->orderService->getRankingByRoleAndTime($role, $month, $year);
        $rankingShipped = $this->orderService->getRankingShippedByTime($shippedMonth, $shippedYear);

        return view('Core::ranking.index', compact('rankingTotal', 'rankingShipped', 'page'));
    }
}
