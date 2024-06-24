<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Item::query();
        $query->orderBy('created_at', 'desc');
        $items = $query->get();
        return view('user.index', compact('items', 'user'));
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
        if ($id) {
            $user = Auth::user()->name;
        }
        $keys = $request->keyword;
        $keys1 = $request->keyword1;
        if ($keys !== null) {
            $keys = explode(" ", $request->keyword);
            $key_count++;
        }
        if ($keys1 !== 'null') {
            $keys1 = explode(" ", $request->keyword1);
        }
        $keys2 = null;
        if ($keys !== null && $keys1 !== 'null') {
            $keys2 = array_merge($keys, $keys1);
        }
        $i = 0;
        $query = Item::query();
        $items = Item::all();
        if ($keys !== null && $keys1 !== 'null') {
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
            foreach ($keys as $key) {
                if ($i === 0) {
                    $query->where("name", "LIKE", "%{$key}%");
                } else {
                    $query->orWhere("name", "LIKE", "%{$key}%");
                }
                $i++;
            }
        } else if ($keys === null && $keys1 !== 'null') {
            foreach ($keys1 as $key) {
                if ($i === 0) {
                    $query->where("category_id", $key);
                }
                $i++;
            }
        }
        $query->orderBy('created_at', 'desc');
        $searches = $query->get();
        return view('user.index', compact('searches', 'items', 'id'));
    }
}
