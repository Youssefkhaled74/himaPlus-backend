<?php

namespace App\Jobs;

use App\Mail\NewOrderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewOrderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public int $orderNo;

    public $tries   = 3;
    public $backoff = [10, 60, 180];

    public function __construct(string $email, int $orderNo)
    {
        $this->email = $email;
        $this->orderNo  = $orderNo;
        $this->onQueue('notifications');
    }

    public function handle()
    {
        Mail::to($this->email)->send(new NewOrderMail($this->orderNo));
    }

    public function failed(\Throwable $e): void
    {
        Log::error('newOrderMailJob failed', [
            'email' => $this->email,
            'error' => $e->getMessage(),
        ]);
    }
}
