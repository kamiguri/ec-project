<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\StoreCartRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index()
    {
        $totalPrice = 0;
        $cartItems = Auth::user()->cartItems;
        foreach ($cartItems as $item) {
            $totalPrice += $item->price * $item->pivot->amount;
        }
        return view('user.cart.index', compact('cartItems', 'totalPrice'));
    }

    public function store(StoreCartRequest $request, $item_id)
    {
        $item = Item::find($item_id);

        if (!$item) {
            abort(404, '商品が見つかりませんでした。');
        }

        $amount = $request->amount;

        $user = Auth::user();

        $cartItem = $user->cartItems()->where('item_id', $item_id)->first();
        $cartItemAmount = ($cartItem?->pivot->amount ?? 0) + $amount;  // カートに追加済みの場合はカートのamountに足す

        $user->cartItems()->syncWithoutDetaching([$item_id => ['amount' => $cartItemAmount]]);

        return redirect()->route('show', $item)->with('success', 'カートに追加しました');
    }

    public function destroy(Request $request, $item_id)
    {
        $item = Item::find($item_id);
        if (!$item) {
            abort(404, '商品が見つかりませんでした。');
        }

        Auth::user()->cartItems()->detach($item_id);

        return redirect()->route('cart.index');
    }

    public function update(UpdateCartRequest $request, $item_id)
    {
        $item = Item::find($item_id);
        if (!$item) {
            abort(404, '商品が見つかりませんでした。');
        }

        $amount = $request->amount;

        Auth::user()->cartItems()->updateExistingPivot($item_id, ['amount' => $amount]);

        return redirect()->route('cart.index')->with('success', 'カートを更新しました');
    }
}
