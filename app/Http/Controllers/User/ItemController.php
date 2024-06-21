<?php

namespace App\Http\Controllers\User;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ItemController extends Controller
{
    public function show($item_id)
    {
        $item = item::find($item_id);
        // dd($item);
        return view('user.show', compact('item'));
    }
}
