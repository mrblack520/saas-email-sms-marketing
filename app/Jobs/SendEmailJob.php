<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaignData;

    public function __construct($campaignData)
    {
        $this->campaignData = $campaignData;
    }

    public function handle()
    {

            try {
                Mail::to($this->campaignData['to'])
                ->send(new SendMail($this->campaignData));

            } catch (\Exception $exception) {
                \Log::error('Error sending email: '.$exception->getMessage());
            }
    }
}
