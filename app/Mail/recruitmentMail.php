<?php

namespace App\Mail;

use App\Models\ContentMail;
use App\Models\contentMailRecruitment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class recruitmentMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     */
    public function __construct (
        public contentMailRecruitment $contentMailRecruitment
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->contentMailRecruitment->heading,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.recruitmentTemplate',
            with: [
                'heading' => $this->contentMailRecruitment->heading,
                'name' => $this->contentMailRecruitment->name,
                'phonenumber' => $this->contentMailRecruitment->phonenumber,
                'gender' => $this->contentMailRecruitment->gender,
                'description' => $this->contentMailRecruitment->description,
            ]
        );
    }

    

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // $check = Mail::send('mail',$data, function($message) {
        //     $message->to('sv3milo3s@gmail.com', 'Tutorials Point')->subject
        //        ('Laravel Testing Mail with Attachment');
        //     $message->attach('D:\demo.pdf');
        //     $message->attach('D:\demo.pdf');
        //     $message->from('sv3milo3s@gmail.com','Virat Gandhi');
        //  });
        return [
            Attachment::fromPath(storage_path('app/public/sendFileMail/'.$this->contentMailRecruitment->file))
                ->as(storage_path('app/public/sendFileMail/'.$this->contentMailRecruitment->file))
                ->withMime('application/pdf')
        ];
    }
}
