<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('amount', 'price');
    }

    // カートに追加したユーザーとのリレーション
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // いいねのリレーション
    public function usersWhoLiked()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function scopeMonthlySales(Builder $query, $seller_id)
    {
        $query->selectRaw(
                'SUM(order_items.price *  order_items.amount) AS sales, DATE_FORMAT(orders.created_at, "%Y-%m") AS month'
            )
            ->leftJoin('order_items', 'items.id', '=', 'order_items.item_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('items.seller_id', $seller_id)
            ->groupByRaw('DATE_FORMAT(orders.created_at, "%Y-%m")')
            ->orderByRaw('DATE_FORMAT(orders.created_at, "%Y-%m") DESC');
    }
}
