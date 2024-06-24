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

        if ($item->stock === 0) {
            return redirect()->back()->with('error', '在庫切れです');
        }

        $user = Auth::user();

        $cartItem = $user->cartItems()->where('item_id', $item_id)->first();
        $itemAmount = ($cartItem?->pivot->amount ?? 0) + 1;  // カートに追加済みの場合はamountに足す

        $user->cartItems()->syncWithoutDetaching([$item_id => ['amount' => $itemAmount]]);

        return redirect()->route('items.show', $item)->with('success', 'カートに追加しました');
    }
}
