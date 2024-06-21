<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function add(Request $request, Item $item)
    {
        // 1. 在庫チェック
        if ($item->stock === 0) {
            return redirect()->back()->with('error', '在庫切れです');
        }

        // 2. カートへの追加処理 (セッション or DB)
        $user = Auth::user();
        // ... ここにカートへの追加ロジックを実装 ...

        return redirect()->route('items.show', $item)->with('success', 'カートに追加しました');
    }
}
