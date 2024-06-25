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

    public function __construct(?Seller $seller, ?Order $order, ?Item $item, ?User $user)
    {
        $this->seller = $seller;
        $this->order = $order;
        $this->item = $item;
        $this->user = $user;
    }

    public function handle(): void
    {
        \Log::info('Sending mail...');

        if ($this->user) {
            Mail::to($this->user->email)->send(new OrderConfirmationEmail($this->order));
        }


        if ($this->seller) {
            // $order を使って、pivot 情報を含む item を取得
            $itemWithPivot = $this->order->items()->find($this->item->id);

            // $itemWithPivot が null かどうかを確認
            \Log::info('itemWithPivot:', ['itemWithPivot' => $itemWithPivot]);
            \Log::info('item id:', ['itemId' => $this->item->id]);

            \Log::info('Order Items:', ['items' => $this->order->items()->get()->toArray()]);
            \Log::info('Item ID:', ['itemId' => $this->item->id]);

            Mail::to($this->seller->email)->send(new OrderComesInConfirmationEmail(
                $this->seller,
                $this->order,
                $this->item,
                // $itemWithPivot // $itemWithPivot を使う
            ));
        }
    }
}
