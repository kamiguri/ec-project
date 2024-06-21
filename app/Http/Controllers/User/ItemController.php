<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function show(Item $item)
    {
        $item->load('category');
        return view('items.show', compact('item'));
    }
}
