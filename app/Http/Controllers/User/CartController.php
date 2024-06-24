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

        if (! $item) {
            abort(404, '商品が見つかりませんでした。');
        }

        $amount = $request->amount;

        if ($item->stock === 0) {
            return redirect()->back()->with('error', '在庫切れです');
        } elseif ($item->stock < $amount) {
            return redirect()->back()->with('error', '在庫が足りません、商品数を減らしてください。');
        }

        $user = Auth::user();

        $cartItem = $user->cartItems()->where('item_id', $item_id)->first();
        $cartItemAmount = ($cartItem?->pivot->amount ?? 0) + $amount;  // カートに追加済みの場合はカートのamountに足す

        $user->cartItems()->syncWithoutDetaching([$item_id => ['amount' => $cartItemAmount]]);

        return redirect()->route('items.show', $item)->with('success', 'カートに追加しました');
    }

    public function destroy(Request $request, $item_id)
    {
        $item = Item::find($item_id);
        if (! $item) {
            abort(404, '商品が見つかりませんでした。');
        }

        Auth::user()->cartItems()->detach($item_id);

        return redirect()->route('cart.index');
    }

    public function update(Request $request, $item_id)
    {
        $item = Item::find($item_id);
        if (! $item) {
            abort(404, '商品が見つかりませんでした。');
        }

        $amount = $request->amount;

        if ($item->stock === 0) {
            return redirect()->back()->with('error', '在庫切れです');
        } elseif ($item->stock < $amount) {
            return redirect()->back()->with('error', '在庫が足りません');
        }

        Auth::user()->cartItems()->updateExistingPivot($item_id, ['amount' => $amount]);

        return redirect()->route('cart.index')->with('success', 'カートを更新しました');
    }
}
