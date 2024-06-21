<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = Item::all();
        return view('user.index', compact('items','user'));
    }
    public function show($item_id)
    {
        $item = item::find($item_id);
        return view('user.show', compact('item'));
    }

    public function search(Request $request){
        //商品名、カテゴリー、新着順

        $id = 0;
        $id = Auth::id();
        if($id) {
            $user = Auth::user()->name;
        }
        $keys = explode(" ",$request->keyword);
        $i=0;
        $query=Item::query();
        $items = Item::all();
        $query->orderBy('created_at', 'desc');
        foreach($keys as $key){
            if($i === 0){
            $query->where("name","LIKE","%{$key}%");
            }else{
            $query->orWhere("name","LIKE","%{$key}%");
            }
            $i++;
        }
        $searches = $query->get();
        return view('user.index',compact('searches','items','id'));
    }

}
