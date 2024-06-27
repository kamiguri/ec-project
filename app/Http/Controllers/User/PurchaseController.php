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
                $item->total_price = ceil(($item->pivot->price * $item->pivot->amount) * 1.1);
            }
        }
        return view('user.purchase.index', compact('orders'));
    }

    public function create()
    {
        $cartItems = Auth::user()->cartItems;
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            if ($item->pivot->amount > $item->stock) {
                return redirect()->route('cart.index');
            }
            $totalPrice += $item->price * $item->pivot->amount;
        }
        return view('user.purchase.create', compact('cartItems', 'totalPrice'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input("keyword");
        //  $orders = [];

        $user = Auth::user();
        if (!empty($keyword)) {
            $searches = Order::where("user_id",$user->id)
                    ->OrderBy("created_at","DESC")
                    ->whereHas("items", function($q) use ($keyword) {
                    $q->where("name", "LIKE", "%{$keyword}%");
                    })->get();
        }
        //  dd($orders);
        return view('user.purchase.index', compact('searches', 'keyword',"user"));
    }



}
