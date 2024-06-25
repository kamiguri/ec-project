<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Item;
use App\Mail\OrderConfirmationEmail;
use App\Mail\OrderComesInConfirmationEmail;
use Illuminate\Support\Facades\Log;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $order;
    public $seller;
    public $item;

    public function __construct(Seller $seller = null, Order $order, Item $item = null, User $user = null)
    {
        $this->user = $user;
        $this->order = $order;
        $this->seller = $seller;
        $this->item = $item;
    }

    public function handle(): void
    {
        \Log::info('Sending mail...'); // この行を追加

        // dd($this->user->email);
        //dd($this->seller->email);
        if ($this->user) {
        Mail::to($this->user->email)->send(new OrderConfirmationEmail($this->order));
        }
        if ($this->seller) {
            Mail::to($this->seller->email)->send(new OrderComesInConfirmationEmail($this->seller,$this->order, $this->item));
        }
    }
}
