<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カートの商品
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($cartItems->isNotEmpty())
                        <div>
                            <p>合計 ¥
                                <span class="text-lg font-semibold">{{ number_format($totalPrice) }}</span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('purchase.create') }}">
                                <button>レジに進む</button>
                            </a>
                        </div>
                    @error('amount')
                        {{ $message }}
                    @enderror
                    @foreach ($cartItems as $item)
                        <div>
                            <ul>
                                <li>商品名: {{ $item->name }}</li>
                                <li><img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid"
                                        style="max-height: 200px;"></li>
                                <li>価格: ¥<span class="text-lg font-semibold">{{ number_format($item->price) }}</span></li>
                                <li>在庫数: {{ $item->stock }}</li>
                            </ul>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label>数量:
                                    <input type="number" name="amount" value="{{ $item->pivot->amount }}">
                                </label>
                                <button type="submit">更新</button>
                            </form>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </div>
                    @endforeach
                    @else
                        <p>カートに商品はありません</p>
                        <p><a href="{{ route('index') }}">商品を探す</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
