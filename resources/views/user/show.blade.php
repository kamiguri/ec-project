<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">{{ $item->name }}</div>
                                    <div class="card-body">
                                        <img src="{{ $item->photo_path }}" alt="{{ $item->name }}" class="img-fluid" style="width: 150px; height: 150px;">
                                        <p>カテゴリー: {{ $item->category->name ?? '未設定' }}</p>
                                        <p>商品説明: {{ $item->description }}</p>
                                        <p>価格: {{ number_format($item->price) }}円</p>
                                        <p>在庫数: {{ $item->stock }}</p>
                                        @auth
                                            <form action="{{ route('cart.store', $item->id) }}" method="POST">
                                                @csrf
                                                <label>数量:
                                                    <select name="amount">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </label>
                                                @error('amount')
                                                    {{ $message }}
                                                @enderror
                                                @auth('users')
                                                    <button type="submit" class="btn btn-primary">カートに追加</button>
                                                @else
                                                    <p>Sellerアカウントでは商品の購入はできません。</p>
                                                @endauth
                                            </form>
                                            @auth('users')
                                                {{-- いいね解除フォーム --}}
                                                @if ($item->favorites()->where('user_id', auth()->id())->exists())
                                                    <form action="{{ route('items.unfavorite', $item->id) }}" method="POST"
                                                        style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-heart-broken"></i> いいね解除
                                                        </button>
                                                    </form>
                                                    @else{{-- いいねフォーム --}}
                                                    <form action="{{ route('items.favorite', $item->id) }}" method="POST"
                                                        style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-heart"></i> いいね
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        @else
                                            <p>カートに追加するには<a href="{{ route('login') }}">ログイン</a>してください。</p>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
