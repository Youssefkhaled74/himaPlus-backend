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
            try {
                dispatch(new NewOrderMailJob($email, $orderNo))->delay(now()->addMinute());
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }

    protected function targetOrderUpdatesMailJob($email, $message)
    {
        if (!is_null($email)) {
            try {
                dispatch(new OrderUpdatesMailJob($email, $message))->delay(now()->addMinute());
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }

    protected function targetFairbaseServicePushNotification($fcm_token, $title, $content, $actionType, $target_id)
    {
        if (!is_null($fcm_token)) {
            try {
                return $this->fairbase()->pushNotification($fcm_token, $title, $content, $actionType, $target_id);
            } catch (\Throwable $e) {
                report($e);
                return null;
            }
        }

        return null;
    }

    protected function targetFairbaseServicePushMessage($message, $actionType, $target_id, $fcm_token)
    {
        try {
            return $this->fairbase()->saveChatMessage($message, $actionType, $target_id, $fcm_token);
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }
}
