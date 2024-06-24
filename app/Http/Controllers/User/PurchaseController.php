<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index(){
        //現在のユーザーを取得
        $user = Auth::user();

        //ユーザーの注文とそれに関連するアイテムを取得
        $orders = $user->orders()->with(['items.category'])->get();
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $item->total_price = ($item->pivot->price * $item->pivot->amount) * 1.1;
            }
        }
        return view('user.purchase.index', compact('orders'));
    }
}
