<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
  
    public static function getMonthlySales($sellerId): Collection
    {
        $data = DB::select(<<<EOD
            SELECT
                IFNULL(sales.price, 0) AS sales,
                DATE_FORMAT(calendar.month, "%Y-%m") AS month
            FROM
                (
                SELECT
                    SUM(
                        order_items.price * order_items.amount
                    ) AS price,
                    DATE_FORMAT(orders.created_at, "%Y-%m") AS month
                FROM
                    items
                LEFT JOIN order_items ON order_items.item_id = items.id
                LEFT JOIN orders ON orders.id = order_items.order_id
                WHERE
                    items.seller_id = {$sellerId}
                GROUP BY
                    DATE_FORMAT(orders.created_at, "%Y-%m")
                ORDER BY
                    DATE_FORMAT(orders.created_at, "%Y-%m")
                DESC
            ) AS sales
            RIGHT JOIN(
                SELECT
                    DATE_FORMAT(
                        DATE_ADD(
                            NOW(), INTERVAL - seq.num MONTH),
                            "%Y-%m-%d"
                        ) AS month,
                        seq.num
                    FROM
                        (
                        SELECT
                            @num := 1 AS num
                        UNION ALL
                    SELECT
                        @num := @num + 1
                    FROM
                        information_schema.columns
                    LIMIT 12
                    ) AS seq
                    ) AS calendar
                ON
                    DATE_FORMAT(calendar.month, "%Y-%m") = sales.month
        EOD);

        $collectionData = collect($data)->sortBy('month');

        return $collectionData;
    }

    public static function getDailySales($sellerId): Collection
    {
        $data = DB::select(<<<EOD
            SELECT
                IFNULL(sales.price, 0) AS sales,
                DATE_FORMAT(calendar.date, "%m-%d") AS date
            FROM
                (
                SELECT
                    SUM(
                        order_items.price * order_items.amount
                    ) AS price,
                    DATE_FORMAT(orders.created_at, "%Y-%m-%d") AS DATE
                FROM
                    items
                LEFT JOIN order_items ON order_items.item_id = items.id
                LEFT JOIN orders ON orders.id = order_items.order_id
                WHERE
                    items.seller_id = {$sellerId}
                GROUP BY
                    DATE_FORMAT(orders.created_at, "%Y-%m-%d")
                ORDER BY
                    DATE_FORMAT(orders.created_at, "%Y-%m-%d")
                DESC
            ) AS sales
            RIGHT JOIN(
                SELECT
                    DATE_FORMAT(
                        DATE_ADD(NOW(), INTERVAL - seq.num DAY),
                        "%Y-%m-%d") AS DATE,
                        seq.num
                    FROM
                        (
                        SELECT
                            @num := 1 AS num
                        UNION ALL
                    SELECT
                        @num := @num + 1
                    FROM
                        information_schema.columns
                    LIMIT 30
                    ) AS seq
                    ) AS calendar
                ON
                    calendar.date = sales.date
        EOD);

        $collectionData = collect($data)->sortBy('date');

        return $collectionData;
    }
}
