<?php

namespace Cms\Modules\Core;

use Cms\Modules\Core\Services\Contracts\NotificationServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\PrizeServiceContract;
use Cms\Modules\Core\Services\Contracts\WheelEventServiceContract;
use Illuminate\View\View;

class ViewComposer
{
    protected $globalData;
    protected $notificationService;
    protected $orderService;
    protected $wheelEventService;
    protected $prizeService;

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct
    (
        NotificationServiceContract $notificationService,
        OrderServiceContract $orderService,
        WheelEventServiceContract $wheelEventService,
        PrizeServiceContract $prizeService

    )
    {
        $this->notificationService = $notificationService;
        $this->orderService = $orderService;
        $this->wheelEventService = $wheelEventService;
        $this->prizeService = $prizeService;

        $notifications = $this->notificationService->getCurrentNotification();
        $top3Manager = $this->orderService->getTop3Manager();
        $top3Shipper = $this->orderService->getTop3Shipper();
        $wheelEventActive = $this->wheelEventService->wheelEventActive();
        if ($wheelEventActive) {
            $countPrize = $this->prizeService->countPrizeByUser(auth()->id(), $wheelEventActive->id);
        } else {
            $countPrize = 0;
        }
        $arrTop3Manager = [];
        $arrTop3Shipper = [];
        foreach ($top3Shipper as $index => $item) {
            $url = '/assets/img/top'.($index + 1).'.png';
            $arrTop3Shipper[$item->shipper->name] = '<img style="height:20px;" src="'.$url.'"/>';
        }
        foreach ($top3Manager as $index => $item) {
            $url = '/assets/img/top'.($index + 1).'.png';
            $arrTop3Manager[$item->manager->name] = '<img style="height:20px;" src="'.$url.'"/>';
        }

        $this->globalData = [
            'notifications' => $notifications,
            'top3Manager' => $top3Manager,
            'top3Shipper' => $top3Shipper,
            'arrTop3Manager' => $arrTop3Manager,
            'arrTop3Shipper' => $arrTop3Shipper,
            'wheelEventActive' => $wheelEventActive,
            'countPrize' => $countPrize
        ];
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('globalData', $this->globalData);
    }
}
