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
use App\Models\Item;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        // 決済セッションを作成するための Stripe API を呼び出す
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        try {
            $session = $stripe->checkout->sessions->create([
                // 決済に必要なパラメータを設定
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
                // ...
            ]);

            // セッション ID を返却
            return response()->json(['sessionId' => $session->id]);
        } catch (ApiErrorException $e) {
            // エラー処理
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $user = Auth::user();
        $item = Item::all();
        // テスト用のOrderデータを作成
        $order = new Order([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);
        //保存
        $order->save();
        // メール送信 (非同期)
        SendMailJob::dispatch(null, $order, null, $user);

        foreach ($order->items as $item) {
            $item->total_price = $item->pivot->price * $item->pivot->amount;
            $seller = $item->seller;
            if ($seller) {
                dd($seller);
                // 販売者へのメール送信 (非同期)
                SendMailJob::dispatch($seller, $order, $item, null);
            }
        }

        //return redirect()->route('index');
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
