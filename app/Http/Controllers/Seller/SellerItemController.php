<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category; // カテゴリーモデルをインポート
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ファイル保存に必要

class SellerItemController extends Controller
{
    public function index()
    {
        return view("seller.items.index");
    }
    public function create()
    {
        $categories = Category::all(); // カテゴリー一覧を取得
        return view('seller.items.create', compact('categories'));
    }

    public function edit(){

    }
    public function store(Request $request)
    {
        // 1. バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'photo_path' => 'required|image', // 画像ファイル必須
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id' // categoriesテーブルに存在するID
        ]);

        // 2. ファイルアップロード & 保存パス取得
        $photoPath = $request->file('photo_path')->store('public/item_images');
        $photoPath = str_replace('public/', 'storage/', $photoPath); // assetヘルパーで使用できるパスに変換

        // 3. 商品情報保存
        Item::create([
            'seller_id' => Auth::user()->id, // ログイン中のsellerのIDを設定
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'photo_path' => $photoPath,
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'is_show' => true,
        ]);

        // 4. リダイレクト
        return redirect()->route('seller.items.index')->with('success', '商品を登録しました');
    }

    // ...他の商品管理機能 (表示、更新、削除など) ...

    public function stock_edit($id){
        $item=Item::find($id);
        return view("seller.stock",compact("item"));
    }
}
