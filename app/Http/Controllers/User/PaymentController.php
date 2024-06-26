<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Jobs\SendMailJob;
use App\Models\Item;
use App\Models\Seller;
use App\Models\OrderItem;
use App\Jobs\SendSellerOrderConfirmationEmail;
use App\Jobs\SendUserOrderConfirmationEmail;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = Auth::user()->cartItems;
        $lineItems = [];
        foreach ($cartItems as $item) {

            if ($item->pivot->amount > $item->stock) {
                return redirect()->route('cart.index');
            }

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

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $publicKey = env('STRIPE_PUBLIC_KEY');

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
        DB::beginTransaction();
        try {
            $user = Auth::user();

            // order作成
            $order = new Order();
            $user->orders()->save($order);

            $items = $user->cartItems;
            foreach ($items as $item) {
                // orderに商品追加
                $order->items()->attach(
                    $item->id, ['price' => $item->price, 'amount' => $item->pivot->amount]
                );
                // 商品在庫を減らす
                $item->stock -= $item->pivot->amount;
                $item->save();
            }
            // カートから商品を削除
            $user->cartItems()->detach();

            DB::commit();
        } catch(Exception $exception){
            DB::rollback();
        }

        SendUserOrderConfirmationEmail::dispatch($order);
        SendSellerOrderConfirmationEmail::dispatch($order, $user);
        return redirect()->route('index');
    }
}
