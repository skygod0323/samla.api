<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DownloadMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $download_code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->download_code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = env('APP_URL').'/api/download/checkDownload/'.$this->download_code;
        return $this->subject('Image Download')
            ->view('emails.download')->with([
                'link' => $link,
            ]);
    }
}