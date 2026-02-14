<?php

namespace App\Jobs;

use App\Mail\OrderUpdatesMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderUpdatesMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public string $message;
    public int $orderNo;

    public $tries   = 3;
    public $backoff = [10, 60, 180];

    public function __construct(string $email, string $message)
    {
        $this->email = $email;
        $this->message  = $message;
        $this->onQueue('notifications');
    }

    public function handle()
    {
        Mail::to($this->email)->send(new OrderUpdatesMail($this->message));
    }

    public function failed(\Throwable $e): void
    {
        Log::error('orderUpdatesMailJob failed', [
            'email' => $this->email,
            'error' => $e->getMessage(),
        ]);
    }
}
