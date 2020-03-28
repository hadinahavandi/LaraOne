<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $mailPost;

    /**
     * @param mixed $mailPost
     */
    public function setMailPost($mailPost): void
    {
        $this->mailPost = $mailPost;
    }
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('sweetsoftir@gmail.com','Sweet Software Group')
        ->subject($this->mailPost->subject)
            ->view('mail.mailpost',['dataItem'=>$this->mailPost]);
    }
}
