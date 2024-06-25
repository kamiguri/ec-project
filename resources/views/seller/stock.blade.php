<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>
<h1>在庫登録画面</h1>

<h2>商品名:{{$item->name}}</h2>
<h2>在庫数:{{$item->stock}}</h2>

<form action="/seller/item/{{$item->id}}/stock" method="post">
@csrf
<h3>在庫数:<input type="text" name="stock" value=""></h3>

<div>
    <button type="submit">更新する</button>
</div>

</form>

<a href="{{ route('seller.items.index') }}">商品一覧へ</a>
