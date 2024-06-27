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
        $categories = Category::all();
        $sellerId = Auth::user();
        $query = Item::query()->where('seller_id', $sellerId->id)->orderBy('created_at','desc');

        $items = $query->get();
        return view("seller.items.index",compact('items','categories'));
    }
    public function create()
    {
        $categories = Category::all(); // カテゴリー一覧を取得
        return view('seller.items.create', compact('categories'));
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

    public function show(Request $request) {
        $item = Item::find($request->item_id);
        $stock_text="";
        if ($item->is_show === 1 && $item->stock > 0){
            $stock_text = "現在は表示中です！";
        }else{
            $stock_text = "現在は非表示です！";
        }
        return view("seller.show",compact('item','stock_text'));
    }

    public function edit($id){
        $item=Item::find($id);
        $categories = Category::all();
        return view("seller.items.edit",compact("item","categories"));
    }

    public function update(Request $request,$id){
        $item=Item::find($id);
        $item->name=$request->input("name");
        if(isset($request->photo_path)){
            $photoPath = $request->file('photo_path')->store('public/item_images');
            $photoPath = str_replace('public/', 'storage/', $photoPath); // assetヘルパーで使用できるパスに変換
            $item->photo_Path = $photoPath;
        }
        $item->description=$request->input("description");
        $item->price=$request->input("price");
        $item->category_id=$request->input("category_id");
        $item->is_show = $request->input('is_show');
        $item->save();
        return redirect()->route('seller.show', $id);
    }

    public function stock_edit($id)
    {
        $item=Item::find($id);
        return view("seller.stock",compact("item"));
    }

    public function stock_update(Request $request,$id)
    {
        $item=Item::find($id);
        $item->stock=$request->input("stock");
        $item->save();
        return view("seller.stock",compact("item"));
    }

    public function analysis()
    {
        $monthlyData = Item::getMonthlySales(Auth::id());
        $monthlySalesData = $monthlyData->pluck('sales')->toArray();
        $monthLabels = $monthlyData->pluck('month')->toArray();

        $dailyData = Item::getDailySales(Auth::id());
        $dailySalesData = $dailyData->pluck('sales')->toArray();
        $dateLabels = $dailyData->pluck('date')->toArray();

        return view('seller.analysis', compact('monthlySalesData', 'monthLabels', 'dailySalesData', 'dateLabels'));

    }

    public function search(Request $request)
    {
        //商品名、カテゴリー、新着順
        $id = 0;
        $key_count = 0;
        $id = Auth::id();
        $categories = Category::all();
        if ($id) {
            $user = Auth::user()->name;
        }
        $keys = $request->keyword; //商品名のキーワード
        $keys1 = $request->keyword1;//カテゴリーのキーワード
        $keys_kana = mb_convert_kana($keys,'s'); //全角スペースがある場合は半角に変更

        if ($keys !== null) {
            $keys_kana = explode(" ", $keys_kana);
            $key_count++;
        }
        if ($keys1 !== 'null') {
            $keys1 = explode(" ", $request->keyword1);
        }
        $keys2 = null;
        if ($keys !== null && $keys1 !== 'null') {
            $keys2 = array_merge($keys_kana, $keys1);//商品名とカテゴリーを配列に入れる
        }

        $i = 0; // 初期値
        $query = Item::query();
        $items = Item::all();
        $query->where('is_show','1')->where('stock','>','0');
        if ($keys !== null && $keys1 !== 'null') {
            //商品名とカテゴリーの両方に入力がある時
            foreach ($keys2 as $key) {
                if ($i === 0) {
                    $query->where("name", "LIKE", "%{$key}%"); //$i==0
                } else {
                    $query->orWhere("name", "LIKE", "%{$key}%")
                        ->orWhere("category_id", $key);
                }
                $i++; //increment +1される
            }
        } else if ($keys !== null && $keys1 === 'null') {
            //商品名にのみ入力がある時
            foreach ($keys_kana as $key) {
                if ($i === 0) {
                    $query->where("name", "LIKE", "%{$key}%");
                } else {
                    $query->orWhere("name", "LIKE", "%{$key}%");
                }
                $i++;
            }
        } else if ($keys === null && $keys1 !== 'null') {
            //カテゴリーにのみ入力がある時
            foreach ($keys1 as $key) {
                if ($i === 0) {
                    $query->where("category_id", $key);
                }
                $i++;
            }
        }
        $query->orderBy('created_at', 'desc');
        $searches = $query->get();
        return view('user.index', compact('searches', 'items', 'id', 'categories'));
    }
}
