<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Item;
use App\Models\Category;
use App\Models\Favorite;

use function Laravel\Prompts\form;

class ItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Item::query();
        $categories = Category::all();
        $query->orderBy('created_at', 'desc');
        $items = $query->get();
        return view('user.index', compact('items', 'user', 'categories'));
    }
    public function show($item_id)
    {
        $item = item::find($item_id);
        return view('user.show', compact('item'));
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
        $i = 0;
        $query = Item::query();
        $items = Item::all();
        if ($keys !== null && $keys1 !== 'null') {
            //商品名とカテゴリーの両方に入力がある時
            foreach ($keys2 as $key) {
                if ($i === 0) {
                    $query->where("name", "LIKE", "%{$key}%");
                } else {
                    $query->orWhere("name", "LIKE", "%{$key}%")
                        ->orWhere("category_id", $key);
                }
                $i++;
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

    //お気に入り機能の関数
    public function favorite(Request $request, $item_id)
    {
        // dd($request, $item_id);

        // 既にいいね済みの場合は処理を行わない
        if ($request->user()->favorites()->where('item_id', $item_id)->exists()) {
            return back()->with('info', '既にいいね済みです。');
        }

        // データベースにいいねを保存
        $request->user()->favorites()->attach($item_id);

        return back()->with('success', 'お気に入りに追加しました。');
    }

    public function unfavorite(Request $request, $item_id)
    {

        // いいねしていない場合は処理を行わない
        if (!$request->user()->favorites()->where('item_id', $item_id)->exists()) {
            return back()->with('info', 'いいねされていません。');
        }

        // データベースからいいねを削除
        $request->user()->favorites()->detach($item_id);

        return back()->with('success', 'お気に入りから削除しました。');
    }
}
