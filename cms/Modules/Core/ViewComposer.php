<?php

namespace Cms\Modules\Core;

use Cms\Modules\Core\Services\Contracts\NotificationServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Illuminate\View\View;

class ViewComposer
{
    protected $globalData;
    protected $notificationService;
    protected $orderService;

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct
    (
        NotificationServiceContract $notificationService,
        OrderServiceContract $orderService
    )
    {
        $this->notificationService = $notificationService;
        $this->orderService = $orderService;

        $notifications = $this->notificationService->getCurrentNotification();
        $top3Manager = $this->orderService->getTop3Manager();
        $top3Shipper = $this->orderService->getTop3Shipper();
        $arrTop3Manager = [];
        $arrTop3Shipper = [];
        foreach ($top3Shipper as $index => $item) {
            $arrTop3Shipper[$item->shipper->name] = ' - Top ' . ($index + 1);
        }
        foreach ($top3Manager as $index => $item) {
            $arrTop3Manager[$item->manager->name] = ' - Top ' . ($index + 1);
        }

        $this->globalData = [
            'notifications' => $notifications,
            'top3Manager' => $top3Manager,
            'top3Shipper' => $top3Shipper,
            'arrTop3Manager' => $arrTop3Manager,
            'arrTop3Shipper' => $arrTop3Shipper
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
