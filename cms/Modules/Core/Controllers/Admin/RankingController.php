<?php

namespace Cms\Modules\Core\Controllers\Admin;

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
        $role = $request->role ?? 'manager';
        $time = $request->time ?? 'month';
        $timeShipped = $request->timeShipped ?? 'month';

        $rankingTotal = $this->orderService->getRankingByRoleAndTime($role, $time);
        $rankingShipped = $this->orderService->getRankingShippedByTime($timeShipped);

        return view('Core::ranking.index', compact('rankingTotal', 'rankingShipped'));
    }
}
