<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;
    public $data;
    public $type;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data, $type = '')
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new SendEmail($this->data, $this->type);

        Mail::to($this->data['email'])->send($email);
    }
}
