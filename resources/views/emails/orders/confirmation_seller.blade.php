<h1>{{ $items->first()->seller->name }}様</h1>
<h2>新規注文のお知らせ</h2>
<p>{{ $order->user->name }}様からご注文がありました。</p>

<table>
    <thead>
        <tr>
            <th>商品名</th>
            <th>数量</th>
            <th>価格</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->pivot->amount }}</td>
                <td>{{ $item->pivot->price }}円</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>合計金額: {{ $items->sum('pivot.price') }}円</p>

<p>詳細は管理画面をご確認ください。</p>
