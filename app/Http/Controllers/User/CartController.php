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

        // 1. 在庫チェック
        if ($item->stock === 0) {
            return redirect()->back()->with('error', '在庫切れです');
        }

        // 2. カートへの追加処理 (セッション or DB)
        $user = Auth::user();

        $user->cartItems()->syncWithoutDetaching([$item_id => ['amount' => 1]]);
        // ... ここにカートへの追加ロジックを実装 ...

        return redirect()->route('items.show', $item)->with('success', 'カートに追加しました');
    }
}
