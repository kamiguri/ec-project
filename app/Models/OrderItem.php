<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items'; // テーブル名を明示的に指定

    protected $fillable = [
        'order_id',
        'item_id',
        'amount',
        'price',
    ];

    // Order モデルとのリレーション
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item モデルとのリレーション
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
