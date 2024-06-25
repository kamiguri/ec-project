<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderComesInConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $item;
    public $seller;
    /**
     * Create a new message instance.
     */
    public function __construct($seller, $order, $item)
    {
        $this->order = $order;
        $this->item = $item;
        $this->seller = $seller;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Comes In Confirmation Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.confirmation_seller',
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

    public function build()
    {
        \Log::info('Building mail...seller');
        \Log::info('Order Items:', ['items' => $this->order]);
        \Log::info('Item ID:', ['itemId' => $this->item->id]);
        \Log::info('Seller ID:', ['seller_id' => $this->seller->id]);
        // \Log::info('Order Items:', ['items' => $this->order->items()->get()->toArray()]);
        // \Log::info('Item ID:', ['itemId' => $this->item->id]);

        return $this->view('emails.orders.confirmation_seller');
        // ->with([
        //     'orderId' => $this->order->id,
        //     'itemName' => $this->item->name,
        //     'itemPrice' => $this->item->pivot ? $this->item->pivot->price : null, // null チェックを追加
        //     'itemAmount' => $this->item->pivot ? $this->item->pivot->amount : null, // null チェックを追加
        // ]);
        // return $this->subject('注文が入りました')
        //     ->view('emails.orders.confirmation_seller');
    }
}
