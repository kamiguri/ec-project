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
use App\Models\Seller;
use App\Models\OrderItem;

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
        // テストデータの作成
        $user = User::first();
        $seller = Seller::first();
        $item = Item::first();

        // Order を作成
        $order = new Order([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);
        $order->save();

        // OrderItem を作成し、order_items テーブルにデータを直接挿入
        $orderItem = new OrderItem([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'amount' => 1, // 購入数を指定
            'price' => $item->price,
        ]);
        $orderItem->save();

        // Order と Item のリレーションを作成し、pivot 情報を設定
        // $order->items()->attach($item->id, ['price' => $item->price, 'amount' => 1]); // amount は仮に 1 としています

        // $order->save(); // attach() メソッドの後にも save() を実行する

        // SendMailJob をディスパッチ
        SendMailJob::dispatch($seller, $order, $item, $user);
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
