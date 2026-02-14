<?php

namespace App\Jobs;

use App\Mail\UserCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserCodeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public string $code;

    public $tries   = 3;
    public $backoff = [10, 60, 180];

    public function __construct(string $email, string $code)
    {
        $this->email = $email;
        $this->code  = $code;
        $this->onQueue('notifications');
    }

    public function handle()
    {
        Mail::to($this->email)->send(new UserCodeMail($this->code));
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendUserCodeMailJob failed', [
            'email' => $this->email,
            'error' => $e->getMessage(),
        ]);
    }
}
