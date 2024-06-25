<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use App\Models\User;
use App\Jobs\SendMailJob;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $publicKey = env('STRIPE_PUBLIC_KEY');

        $cartItems = Auth::user()->cartItems;
        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $item->name,
                        'description' => $item->description,
                    ],
                    'currency' => 'jpy',
                    'unit_amount' => $item->price,
                ],
                'quantity' => $item->pivot->amount,
            ];
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [$lineItems],
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('purchase.create'),
        ]);

        return view('user.purchase.checkout',
        compact('checkout_session', 'publicKey'));
    }

    public function success(Request $request)
    {
        $user = Auth::user();
        // テスト用のOrderデータを作成
        $order = new Order([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);
        //保存
        $order->save();
        // メール送信 (非同期)
        SendMailJob::dispatch($user, $order);
        // dd($user);

        // return redirect()->route('index');
    }

    // キャンセル時の処理
    public function cancel()
    {
        // ...
    }

    // 決済完了後の処理
    public function complete()
    {
        // ...
    }

    // エラー時の処理
    public function error()
    {
        // ...
    }
}
