<h1>ご注文ありがとうございます</h1>
<p>{{ $order->user->name }}様</p>
<p>この度は、{{ config('app.name') }}をご利用いただき、誠にありがとうございます。</p>

<p>ご注文内容は以下の通りです。</p>

<table>
    <thead>
        <tr>
            <th>商品名</th>
            <th>数量</th>
            <th>価格</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->pivot->amount }}</td>
                <td>{{ $item->pivot->price }}円</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>合計金額: {{ $order->items->sum('pivot.price') }}円</p>

<p>今後とも、{{ config('app.name') }}をよろしくお願い申し上げます。</p>
