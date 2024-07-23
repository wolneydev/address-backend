<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;
    private $data =[];

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->data =$data;
       //
        //
    }

    /**
     * Get the message envelope.
     */

    //  public function build(){
    //     dd('g');
    //     return $this->from()
    //     ->subject($this->data['subject'])->view('emails.index')
    //     ->with('data',$this->data);
    //  }
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('listas.wolney@gmail.com','Laravel ma'),
            subject: $this->data['subject'],
            data:$this->data
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.index',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
