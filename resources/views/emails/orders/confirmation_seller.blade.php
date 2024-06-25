<!DOCTYPE html>
<html>

<head>
    <title>ユーザーから注文が入りました</title>
</head>

<body>
    <h1>注文が入りました</h1>

    <p>この度は、ご注文いただき誠にありがとうございます。</p>

    <p>ご注文の詳細はこちら</p>
    <h1>注文詳細</h1>
    <p>注文ID: {{ $orderId }}</p>
    <p>アイテム名: {{ $itemName }}</p>
    <p>価格: ¥{{ $itemPrice }}</p>
    <p>数量: {{ $itemAmount }}</p>
    <p>今後とも、よろしくお願いいたします。</p>
</body>

</html>
