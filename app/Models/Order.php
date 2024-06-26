<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // 'id' を追加
        'user_id',
        'created_at',
        'total_price',
        // ... その他のfillableな属性
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items') // 'order_items' を指定
            ->withPivot('amount', 'price');
    }
}
