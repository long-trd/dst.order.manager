<?php

namespace Cms\Modules\Core;

use Cms\Modules\Core\Services\Contracts\NotificationServiceContract;
use Illuminate\View\View;

class ViewComposer
{

    protected $notifications;
    protected $notificationService;

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct
    (
        NotificationServiceContract $notificationService
    )
    {
        $this->notificationService = $notificationService;
        $this->notifications = $this->notificationService->getCurrentNotification();
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('globalNotification', $this->notifications);
    }
}
