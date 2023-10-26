<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pTo;
    protected $pSubject;
    protected $pData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $data)
    {
        $this->pTo = $to;
        $this->pSubject = $subject;
        $this->pData = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->to($this->pTo['email'], $this->pTo['name'])
                    ->view('emails.alert')
                    ->subject($this->pSubject)
                    ->with($this->pData);
    }
}
