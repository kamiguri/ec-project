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
        $items = Item::all();
        return view('user.index', compact('items'));
    }
    public function show($item_id)
    {
        $item = item::find($item_id);
        // dd($item);
        return view('user.show', compact('item'));
    }
}
