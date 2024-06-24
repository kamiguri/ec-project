<!DOCTYPE html>
<html>

<head>
    <title>ご注文ありがとうございます</title>
</head>

<body>
    <h1>ご注文ありがとうございます</h1>

    <p>この度は、ご注文いただき誠にありがとうございます。</p>

    <p>ご注文の詳細はこちら</p>
    <ul>
        <li>注文番号: {{ $order->id }}</li>
        <li>注文日時: {{ $order->created_at }}</li>
        <li>合計金額: {{ $order->total_price }}</li>
    </ul>

    <p>今後とも、よろしくお願いいたします。</p>
</body>

</html>
