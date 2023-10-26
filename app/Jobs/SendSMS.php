<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pTo;
    protected $pFrom;
    protected $pText;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $text, $from=null)
    {
        $this->pTo = $to;
        $this->pFrom = $from;
        $this->pText = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sid = env('TWILIO_ID', 'AC1edb7b10d151c6ad5c344d88390377c3');
        $token = env('TWILIO_TOKEN', '54b6ecbe1149b72dd18c5b1343834f5d');
        $from = env('TWILIO_FROM', '+16206369802');
        if($this->pFrom == null){
            $this->pFrom = $from;
        }
        
        $client = new Client($sid, $token);
        $client->messages->create(
            $this->pTo,
            array(
                'from' => $this->pFrom,
                'body' => $this->pText
            )
        );
    }
}
