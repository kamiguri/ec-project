{{-- @extends('layouts.app') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $item->name }}</div>
                <div class="card-body">
                    <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid">

                    <p>カテゴリー: {{ $item->category->name ?? '未設定' }}</p>
                    <p>商品説明: {{ $item->description }}</p>
                    <p>価格: {{ number_format($item->price) }}円</p>
                    <p>在庫数: {{ $item->stock }}</p>

                    @auth
                        <form action="{{ route('cart.add', $item) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">カートに追加</button>
                        </form>
                    @else
                        <p>カートに追加するには<a href="{{ route('login') }}">ログイン</a>してください。</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
