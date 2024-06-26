<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category; // カテゴリーモデルをインポート
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ファイル保存に必要
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class SellerItemController extends Controller
{
    public function index()
    {
        $sellerId = Auth::user();
        $query = Item::query()->where('seller_id', $sellerId->id);
        $items = $query->get();
        return view("seller.items.index",compact('items'));
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
        return view("seller.show",compact('item'));
    }

    public function edit($id){
        $item=Item::find($id);
        $categories = Category::all();
        return view("seller.items.edit",compact("item","categories"));
    }

    public function update(Request $request,$id){

        $item=Item::find($id);
        $item->name=$request->input("name");
        $item->description=$request->input("description");
        $item->price=$request->input("price");
        $item->category_id=$request->input("category_id");
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
        $sellerId = Auth::id();

        $monthlyData = DB::select(<<<EOD
            SELECT
                IFNULL(sales.price, 0) AS sales,
                DATE_FORMAT(calendar.month, "%Y-%m") AS month
            FROM
                (
                SELECT
                    SUM(
                        order_items.price * order_items.amount
                    ) AS price,
                    DATE_FORMAT(orders.created_at, "%Y-%m") AS month
                FROM
                    items
                LEFT JOIN order_items ON order_items.item_id = items.id
                LEFT JOIN orders ON orders.id = order_items.order_id
                WHERE
                    items.seller_id = {$sellerId}
                GROUP BY
                    DATE_FORMAT(orders.created_at, "%Y-%m")
                ORDER BY
                    DATE_FORMAT(orders.created_at, "%Y-%m")
                DESC
            ) AS sales
            RIGHT JOIN(
                SELECT
                    DATE_FORMAT(
                        DATE_ADD(
                            NOW(), INTERVAL - seq.num MONTH),
                            "%Y-%m-%d"
                        ) AS month,
                        seq.num
                    FROM
                        (
                        SELECT
                            @num := 1 AS num
                        UNION ALL
                    SELECT
                        @num := @num + 1
                    FROM
                        information_schema.columns
                    LIMIT 12
                    ) AS seq
                    ) AS calendar
                ON
                    DATE_FORMAT(calendar.month, "%Y-%m") = sales.month
        EOD);

        $monthlyData = collect($monthlyData)->sortBy('month');
        $monthlySalesData = $monthlyData->pluck('sales')->toArray();
        $monthLabels = $monthlyData->pluck('month')->toArray();

        $dailyData = DB::select(<<<EOD
            SELECT
                IFNULL(sales.price, 0) AS sales,
                DATE_FORMAT(calendar.date, "%m-%d") AS date
            FROM
                (
                SELECT
                    SUM(
                        order_items.price * order_items.amount
                    ) AS price,
                    DATE_FORMAT(orders.created_at, "%Y-%m-%d") AS DATE
                FROM
                    items
                LEFT JOIN order_items ON order_items.item_id = items.id
                LEFT JOIN orders ON orders.id = order_items.order_id
                WHERE
                    items.seller_id = {$sellerId}
                GROUP BY
                    DATE_FORMAT(orders.created_at, "%Y-%m-%d")
                ORDER BY
                    DATE_FORMAT(orders.created_at, "%Y-%m-%d")
                DESC
            ) AS sales
            RIGHT JOIN(
                SELECT
                    DATE_FORMAT(
                        DATE_ADD(NOW(), INTERVAL - seq.num DAY),
                        "%Y-%m-%d") AS DATE,
                        seq.num
                    FROM
                        (
                        SELECT
                            @num := 1 AS num
                        UNION ALL
                    SELECT
                        @num := @num + 1
                    FROM
                        information_schema.columns
                    LIMIT 30
                    ) AS seq
                    ) AS calendar
                ON
                    calendar.date = sales.date
        EOD);

        $dailyData = collect($dailyData)->sortBy('date');
        $dailySalesData = $dailyData->pluck('sales')->toArray();
        $dateLabels = $dailyData->pluck('date')->toArray();

        return view('seller.analysis', compact('monthlySalesData', 'monthLabels', 'dailySalesData', 'dateLabels'));

    }
}
