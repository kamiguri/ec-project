<?php

namespace App\Http\Controllers\User;

use App\Models\Category;
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
        $categories=Category::all();
        //ユーザーの注文とそれに関連するアイテムを取得
        $orders = $user->orders()
                  ->with(['items.category'])
                  ->orderBy('created_at', 'desc')
                  ->get();
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $item->total_price = ceil(($item->pivot->price * $item->pivot->amount) * 1.1);
            }
        }
        return view('user.purchase.index', compact('orders',"categories"));
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
        //商品名、カテゴリー、新着順
        $id = 0;
        $key_count = 0;
        $id = Auth::id();
        $user = Auth::user();
        $categories = Category::all();
        $orders = $user->orders()
                  ->with(['items.category'])
                  ->orderBy('created_at', 'desc');
        //           ->get();
        // foreach ($orders as $order) {
        //     foreach ($order->items as $item) {
        //         $item->total_price = ceil(($item->pivot->price * $item->pivot->amount) * 1.1);
        //     }
        // }
        if ($id) {
            $user = Auth::user()->name;
        }
        $keys = $request->keyword;
        $keys1 = $request->keyword1;
        if ($keys !== null) {
            $keys = explode(" ", $request->keyword);
            $key_count++;
        }
        if ($keys1 !== 'null') {
            $keys1 = explode(" ", $request->keyword1);
        }
        $keys2 = null;
        if ($keys !== null && $keys1 !== 'null') {
            $keys2 = array_merge($keys, $keys1);
        }

        $i = 0; // 初期値
        $query = Item::query();
        $items = Item::all();
        if ($keys !== null && $keys1 !== 'null') {
            foreach ($keys2 as $key) {
                if ($i === 0) {
                    $orders->where("name", "LIKE", "%{$key}%"); //$i==0
                } else {
                    $orders->orWhere("name", "LIKE", "%{$key}%")
                        ->orWhere("category_id", $key);
                }
                $i++; //increment +1される
            }
        } else if ($keys !== null && $keys1 === 'null') {
            foreach ($keys as $key) {
                if ($i === 0) {
                    $orders->where("name", "LIKE", "%{$key}%");
                } else {
                    $orders->orWhere("name", "LIKE", "%{$key}%");
                }
                $i++;
            }
        } else if ($keys === null && $keys1 !== 'null') {
            foreach ($keys1 as $key) {
                if ($i === 0) {
                    $orders->where("category_id", $key);
                }
                $i++;
            }
        }
        $orders->orderBy('created_at', 'desc');
        // dd($orders);
        $searches = $orders->get();
        return view('user.purchase.index',compact('searches', "orders",'items', 'id', 'categories'));
    }



}
