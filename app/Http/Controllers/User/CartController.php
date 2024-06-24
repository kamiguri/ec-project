<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index() {
        return view('user.cart.index');
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::find($item_id);
        $amount = $request->amount;

        if ($item->stock === 0) {
            return redirect()->back()->with('error', '在庫切れです');
        } elseif ($item->stock < $amount) {
            return redirect()->back()->with('error', '在庫が足りません、商品数を減らしてください。');
        }

        $user = Auth::user();

        $cartItem = $user->cartItems()->where('item_id', $item_id)->first();
        $carItemAmount = ($cartItem?->pivot->amount ?? 0) + $amount;  // カートに追加済みの場合はカートのamountに足す

        $user->cartItems()->syncWithoutDetaching([$item_id => ['amount' => $carItemAmount]]);

        return redirect()->route('items.show', $item)->with('success', 'カートに追加しました');
    }
}
