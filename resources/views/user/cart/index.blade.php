<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カートの商品一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($cartItems->isNotEmpty())
                        <div>
                            <a href="{{ route('purchase.create') }}">
                                <button>レジに進む</button>
                            </a>
                        </div>
                    @endif
                    @error('amount')
                        {{ $message }}
                    @enderror
                    @foreach ($cartItems as $item)
                        <div>
                            <ul>
                                <li>商品名: {{ $item->name }}</li>
                                <li><img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid"
                                        style="max-height: 200px;"></li>
                                <li>価格: {{ $item->price }}円(JPY)</li>
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
                    <div>合計金額{{ $totalPrice }}円</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
