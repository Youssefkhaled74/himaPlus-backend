<?php

namespace App\Traits;

use App\Http\ServicesLayer\FairbaseServices\FairbaseService;
use App\Jobs\NewOrderMailJob;
use App\Jobs\OrderUpdatesMailJob;

trait PushNotificationsTrait
{
    protected ?FairbaseService $fairbaseService = null;
    protected function fairbase(): FairbaseService
    {
        if (!$this->fairbaseService) {
            $this->fairbaseService = app(FairbaseService::class);
        }
        return $this->fairbaseService;
    }

    protected function targetNewOrderMailJob($email, $orderNo)
    {
        if (!is_null($email)) {
            dispatch(new NewOrderMailJob($email, $orderNo))->delay(now()->addMinute());
        }
    }

    protected function targetOrderUpdatesMailJob($email, $message)
    {        if (!is_null($email)) {
            dispatch(new OrderUpdatesMailJob($email, $message))->delay(now()->addMinute());
        }
    }

    protected function targetFairbaseServicePushNotification($fcm_token, $title, $content, $actionType, $target_id)
    {
        if (!is_null($fcm_token)) {
            return $this->fairbase()->pushNotification($fcm_token, $title, $content, $actionType, $target_id);
        }
    }

    protected function targetFairbaseServicePushMessage($message, $actionType, $target_id, $fcm_token)
    {
        return $this->fairbase()->saveChatMessage($message, $actionType, $target_id, $fcm_token);
    }
}
