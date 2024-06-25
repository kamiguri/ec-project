<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index() {
        $user = Auth::user();
        $query = Item::query();
        $query->orderBy('created_at', 'desc');
        $items = $query->get();
        $favorite = Favorite::all();
        $myfavorite = $favorite->where('user_id', $user->id);
        return view('user.favorite.index',compact('items', 'user','myfavorite'));
    }
}
