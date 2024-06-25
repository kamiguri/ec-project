<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', // これを追加
        'category_id',
        'name',
        'photo_path',
        'description',
        'price',
        'stock',
        'is_show',
    ];
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('price', 'amount');
    }
}
