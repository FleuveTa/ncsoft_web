<?php

namespace App\Jobs;

use App\Mail\ConcatEmail;
use App\Models\ContentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $contentMail;
    /**
     * Create a new job instance.
     */
    public function __construct($details, $contentMail)
    {
        $this->details = $details;
        $this->contentMail = $contentMail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
    }
}
