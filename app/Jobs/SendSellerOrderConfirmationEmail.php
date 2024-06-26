<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Mail\SellerOrderConfirmationEmail;
use Illuminate\Support\Facades\Log;

class SendSellerOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        Log::info('Sending seller order confirmation email...');
        // orderItems をループして、それぞれの item の seller にメールを送信
        foreach ($this->order->items as $item) {
            Mail::to($item->seller->email)->send(new SellerOrderConfirmationEmail($this->order));
        }
    }
}
