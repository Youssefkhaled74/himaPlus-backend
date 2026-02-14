<?php

namespace App\Jobs;

use App\Http\ServicesLayer\ForJawalyServices\ForJawalyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $mobile;
    public string $code;

    public $tries   = 3;
    public $backoff = [10, 60, 180];

    public function __construct(string $mobile, string $code)
    {
        $this->mobile = $mobile;
        $this->code   = $code;
        $this->onQueue('notifications');
    }

    public function handle(ForJawalyService $sms)
    {
        $sms->sendSMS($this->mobile, $this->code);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendSmsJob failed', [
            'mobile' => $this->mobile,
            'error'  => $e->getMessage(),
        ]);
    }
}
