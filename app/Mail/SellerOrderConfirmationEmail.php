<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerOrderConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '新規注文のお知らせ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.confirmation_seller', // メールテンプレートのパス
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
